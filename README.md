# Laravel Code Generator

Laravel Code Generator is a PHP Laravel Package that uses blade for generating any type of code for you.

## Installation

Use composer to install Laravel Code Generator.

```bash
composer require --dev victoryoalli/laravel-code-generator
```

```bash
php artisan vendor:publish --provider="VictorYoalli\LaravelCodeGenerator" --tag=views,config --force
```

## Usage

#### Basic Usage
```php
php artisan code:generate 'App\Model' -t 'path/to/template.blade.php' -o 'path/to/output.php'
```

#### Example
```php
php artisan code:generate 'App\User' -t 'path/to/template.blade.php' -o 'path/to/output.php'
```


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
### config/laravel-code-generator.php
