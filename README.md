# Fruit Management

Custom issue tracker

## Video review
[![Fruit Management ](http://img.youtube.com/vi/LGGKk6gk4lM/0.jpg)](https://www.youtube.com/watch?v=LGGKk6gk4lM "Fruit Management ")

## Requirements

### As "classic"
    * Apache >= 2.2
    * PHP >= 7.4
    * MySQL >= 5

### As Docker container
    * Docker Compose

## Installation

### Get last sources
```
git clone https://github.com/timmson/fruit-management.git 
cd fruit-management
```

### Install PHP and Composer
See installation depending on you platform

### Run
```
composer install --prefer-dist --no-progress -d web
docker-compose up -d --build
```

### Open in browser
```
http://localhost:8080
```

Access: fruit fruit
