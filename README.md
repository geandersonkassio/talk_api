# API - Talk backend

## Project setup

### Rename the env.example file to .env
```
mv .env.example .env
```

### Configure the database connection
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

### Configure the api key
```
JWT_KEY=
```

### Install the dependencies
```
composer install 
```

### Run migrations and seeders
```
php artisan migrate && php artinsa db:seed
```

### Run the test server
```
php -S localhost:8000 -t public
```

### [POSTMAN] Collection with the requests available in the api

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/edd61859a22797244aeb)
