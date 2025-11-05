# GetDbInfo Laravel Package

Access database info through the command line in your Laravel projects.

## Installation

```bash
composer require ridwnhoq/get-db-info
```

## Service Provider

The package service provider is auto-discovered. If you need to register manually:

```php
// config/app.php
'providers' => [
    // ...existing providers...
    GetDbInfo\Providers\GetDbProvider::class,
],
```

## Usage

After installation, you can use the provided artisan command:

```bash
php artisan get:db-info
```

## Configuration

No additional configuration is required. The package uses your default Laravel database settings.

## Contributing

Feel free to submit issues or pull requests on GitHub.

## License

MIT
