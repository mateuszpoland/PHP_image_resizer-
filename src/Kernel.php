<?php
declare(strict_types=1);

namespace ClickMeeting;

use ClickMeeting\Service\FileProcessor;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Gumlet\ImageResizeException;
use \Gumlet\ImageResize;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle()
        ];
    }

    protected function configureContainer(ContainerConfigurator $c): void
    {
        $c->extension('framework', [
            'secret' => 'S0ME_SECRET'
        ]);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->add('home', '/')->controller([$this, 'indexAction']);
        $routes->add('first', '/cropImage')->controller([$this, 'cropImage']);
        $routes->add('third', '/getItems/{collectionName}')->controller([$this, 'thirdTask']);
    }

    public function indexAction(): Response
    {
        return new Response(
            '<html>
                <body>
                    <h2>Przytnij obrazek</h2>
                    <form action="/cropImage" method="POST" enctype="multipart/form-data">
                        <input type="file" name="images[]", accept="image/png, image/jpg" multiple/>
                        <label for="dimensions">Wpisz wymiary (width x height)</label>
                        <div>
                            <input type="number" name="width" placeholder="szerokość"/>
                            <input type="number" name="height" placeholder="wysokość"/>
                        </div>
                        <div>
                            <input type="submit" value="przytnij" name="submit"/>
                        </div>
                    </form>
                </body>
            </html>'
        );
    }

    public function cropImage()
    {
        $tmpFilePaths = $_FILES['images']['tmp_name'];
        $width = (int)$_POST['width'];
        $height = (int)$_POST['height'];
        
        $total_files = count($_FILES['images']['name']);
        $imageNames = $_FILES['images']['name'];
        #$uploadPath = '/tmp/uploads';
        $uploadPath = __DIR__. '/uploads/processed/';
        //$response = new Response($file);
        for($i = 0; $i < $total_files; $i++){
            $tmpFilePath = $tmpFilePaths[$i];
            $uploadFilePath =  __DIR__ . '/uploads/' . $_FILES['images']['name'][$i];
            move_uploaded_file($tmpFilePath, $uploadFilePath);
            $image = new ImageResize($uploadFilePath);
            $width = $image->getSourceWidth();
            $height = $image->getSourceHeight();
            $orientation = ($width >= $height) ? 'HORIZONTAL' : 'VERTICAL';
            $image->scale(50);
            $image->save(__DIR__. '/uploads/processed/scaled.png');
        }
       try {
            $fileProcessor = new FileProcessor();
            $fileProcessor->processFiles($imageNames, $uploadPath, $width, $height);
        } catch(ImageResizeException $e) {
            new Response('
                <pre>${$e->getMessage()}</pre>
            ');
        }
        die;
        //$disp = $response->headers->makeDisposition(
        //    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        //    $file
        //);
        //$response->headers->set('Content-Disposition', $disp);
        return $response;
    }
}
