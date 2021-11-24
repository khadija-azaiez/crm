# CRM Project - Formation

cette application sert à gerer une entreprise

## Installation

```git clone```

```composer install```

## Create the docker images for the DB & phpmyadmin

```docker-compose up -d```

## Start the project

```php -S 127.0.0.1:8010 -t public```


## Create the database

```php bin/console doctrine:migration:migrate```


visit ```127.0.0.1:8010``` and try to connect

enjoy !