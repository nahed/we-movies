# we-movies
This application show a list of movies that could be filtered by categories

$ docker-compose build
$ docker-compose up -d
$ docker exec -it we-movies-php-fpm-1 bash // put the right name of php container

Inside the container run those commands
$ composer install && npm run dev

Now you can navigate to the application using this url: http://localhost:8080/movies
