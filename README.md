This is a report api microservice build using laravel 9. The goal is only demonstrate knowledge:

#### Command to clone repository from the github to your local machine:
```git clone https://github.com/danilo4web/reports-api-php.git```

#### Command to build the docker environment (set up containers needed):
```docker-compose up -d --build```

#### Composer install:
```docker-compose run --rm php composer install```

#### Create .env FILE configuration:
```cp .env.example .env```

###### (You should provide a valid smtp account to send the mail reports)

#### Create and populate database with the fake data:
```docker-compose run --rm php php artisan migrate --seed```

#### Check PSR-12 - Coding Style:
```docker-compose run --rm php composer check-psr12```

### ROUTES API

#### Create a new report
```
POST http://0.0.0.0:8080/api/v1/reports
{
    "sql": "select u.name, t.amount, t.created_at from users u inner join transfers t on u.id = t.user_id"
}
```

#### Export a report
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

#### Postman collection with the endpoints from the app:
Download the postman collection: [Download Collection](https://raw.githubusercontent.com/danilo4web/reports-api-php/main/Report_API.postman_collection.json)
