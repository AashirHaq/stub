# Stub package

![Build Status](https://travis-ci.org/AashirHaq/stub.png?branch=master)  ![Github All Releases](https://img.shields.io/github/downloads/aashirhaq/stub/total.svg)

### About
Generate CRUD of provided model name including Controller Services and Views

## Getting Started

### Installation

**aashirhaq/stub** requires PHP >= 7.4.

```shell
composer require aashirhaq/stub
```
### Basic Usage

1. Use ``` php artisan generate:skeleton {name-of-model} ``` to generate skeleton
2. Add `Aashirhaq\Stub\StubServiceProvider::class,` inside `config/app.php` under `Application Service Providers` sections.
