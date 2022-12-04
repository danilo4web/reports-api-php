This is a report api microservice build using laravel 9. The goal is only demonstrate knowledge:

#### Clone repo from github to your local machine:
```git clone https://github.com/danilo4web/reports-api-php.git```

#### Use the docker env to set up containers needed:
```docker-compose up -d --build```

#### Composer install:
```docker-compose run --rm php composer install```

#### Create .env FILE:
```cp .env.example .env```

#### Create and populate database with the fake data:
```docker-compose run --rm php php artisan migrate --seed```

#### Check PSR-12:
```docker-compose run --rm php composer check-psr12```