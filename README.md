# project-ke-klinik-be
REST ful API for application ke klinik

## feature
- Add Patient with name
- Add Service with name
- Add Diagnose with name & service
- Add Appointment with patient_id & diagnose_id
- Get detail Appointment with id Appointment
- Edit Appointment with patient_id, diagnose_id & status by id appointment

## technology
- Laravel 11
- Mysql

## Installation

Install project-ke-klinik-be with composer


After clone project install composer
```bash
  composer install
```
create file .env & add this code to .env for configurate

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ke_klinik
DB_USERNAME=root
DB_PASSWORD=
```

generate key
```bash
  php artisan key:generate
```

migration
```bash
  php artisan migrate
```
generate swagger
```bash
  php artisan l5-swagger:generate
```

run queue:work
```bash
  php artisan queue:work
```

and now
```bash
  php artisan serve
```

    
## Authors

- [@muhammaddzakiardiansyah](https://www.github.com/muhammaddzakiardiansyah)

