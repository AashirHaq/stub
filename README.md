# Stub package

![Build Status](https://travis-ci.org/AashirHaq/stub.png?branch=master)  ![Packagist Downloads](https://img.shields.io/packagist/dt/AashirHaq/stub?color=dark%20green&logo=github)


### About
Generate CRUD of provided model name including Controller Services and Views

## Getting Started

### Installation

**aashirhaq/stub** requires PHP ^7.3|^8.0.

```shell
composer require aashirhaq/stub
```
### Basic Usage

1. Add `Aashirhaq\Stub\StubServiceProvider::class,` inside `config/app.php` under `Package Service Providers` sections.
2. Use ``` php artisan generate:skeleton {name-of-model} ``` to generate skeleton.
