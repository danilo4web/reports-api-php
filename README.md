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

### ROUTES API

#### Create Report
```
POST http://0.0.0.0:8080/api/v1/reports
{
    "sql": "select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id"
}
```

#### Export Report
```
POST http://0.0.0.0:8080/api/v1/reports/export
{
    "id": "1",
    "dateStart": "2022-11-02",
    "dateEnd": "2022-12-30"
}
```

#### Download it:
```
GET http://0.0.0.0:8080/api/v1/reports/download/fileExample.csv
```