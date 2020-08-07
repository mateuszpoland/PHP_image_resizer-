# PHP_image_resizer

This solution was implemented using simple HTTP API.
Scaffolding - index.php front controller using Kernel.php (Symfony) and symfony routing.
Used composer autoloader.

# Setup and usage

1. cd <directory of your choice>
2. git clone 
3. 
# To DO:

1. Performance check and move the whole functionality to WebWorker or another async service, like database + cron.
It will be impossible for bigger data load to be handled via HTTP, as it hits timeout very soon.

2. Unit tests of classes: FileProcessor, FileZipper, ResponseBuilder
3. 
