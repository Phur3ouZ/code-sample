<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Code sample

Using Laravel as the framework, this aims to demonstrate an understanding of:

- REST APIs following an MVC pattern
- Schema migrations
- Commands
- Unit tests

## Requirements

1. PHP 8.0+
2. [Composer](https://getcomposer.org/download/) (v2.1.9])

## Installation

1. Clone repository
2. Install packages (notably, laravel sail)
    1. `composer install`
3. Copy environment variables
    1. `cp .env.example .env`
4. Start up containers (in daemon mode)
    1. `./vendor/bin/sail up -d`
5. Generate key and run migrations & seeds
    1. `./vendor/bin/sail artisan key:generate`
    2. `./vendor/bin/sail artisan migrate`
    3. `./vendor/bin/sail artisan db:seed`

## Usage

### REST API

- GET api/items
- POST api/items
- GET api/items/{item}
- PUT api/items/{item}
- DELETE api/items/{item}

Request body

```json
{
    "barcode": "string",
    "name": "string",
    "description": "string",
    "prices": [
        {
            "amount": "number",
            "currency": "NZD"
        }
    ]
}
```

### Unit tests

`./vendor/bin/sail artisan test`

### Command

`./vendor/bin/sail artisan currency:load --truncate`
