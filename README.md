# PHP_image_resizer

This solution was implemented using simple HTTP API.
Scaffolding - index.php front controller using Kernel.php (Symfony) and symfony routing.
Used composer autoloader.

# Setup and usage

1. cd directory of your choice
2. git clone https://github.com/mateuszpoland/PHP_image_resizer-.git
3. cd PHP_image_resizer
4. composer install
5. php -S localhost:8080
6. Visit your browser on url: localhost:8080

# To DO:

1. Performance check and move the whole functionality to WebWorker or another async service, like database + cron.
It will be impossible for bigger data load to be handled via HTTP, as it hits timeout very soon.

2. Unit tests of classes: FileProcessor, FileZipper, ResponseBuilder
3. Debugging 
4. Introducing scaling based on width and height provided by user.
