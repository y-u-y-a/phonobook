#!/bin/bash

docker exec -it phonoBook.php bash -c "composer install  && npm install && php artisan migrate"
exit
