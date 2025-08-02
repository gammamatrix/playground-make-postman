# Playground: Make Postman

[![Playground CI Workflow](https://github.com/gammamatrix/playground-make-postman/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-make-postman/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-make-postman/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground Make Postman Tool for building out [Laravel](https://laravel.com/docs/11.x) applications.

## Installation

**NOTE:** This is a development tool and not meant for normal installations.

## `artisan about`

Playground Make provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-make-postman.png" alt="screenshot of artisan about command with Playground Make."> -->

## Configuration

You can publish the config file with:
```sh
php artisan vendor:publish --provider="Playground\Make\Postman\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground-make-postman.php](config/playground-make-postman.php)

## Commands

### Build a Postman Collection for a Playground Resource

#### Build the complete collection

```sh
artisan playground:make:postman --force --file resources/configurations/playground-cms-resource/postman.json
```

#### Build the base collection

```sh
artisan playground:make:postman CMS --force --type playground-resource --controller-package resources/configurations/playground-cms-resource/package.playground-cms-resource.json
```
- This command will add authentication steps for Sanctum and Sessions.

##### Build the collection and the all the model end points

```sh
artisan playground:make:postman CMS --force --type playground-resource --controller-package resources/configurations/playground-cms-resource/package.playground-cms-resource.json --model-package resources/configurations/playground-cms/package.playground-cms.json
```

#### Add the Page end points to the collection

```sh
artisan playground:make:postman Page --force --type playground-model --controller-package resources/configurations/playground-cms-resource/package.playground-cms-resource.json --model-file resources/configurations/playground-cms/model.page.json
```

#### Add the Snippet end points to the collection

```sh
artisan playground:make:postman Snippet --force --type playground-model --controller-package resources/configurations/playground-cms-resource/package.playground-cms-resource.json --model-file resources/configurations/playground-cms/model.snippet.json
```

### Build a Postman Collection for a Playground API

#### Build the base collection

```sh
artisan playground:make:postman CMS --force --type playground-api --controller-package resources/configurations/playground-cms-api/package.playground-cms-api.json
```
- This command will add authentication steps for Sanctum.

#### Add the Page end points to the collection

```sh
artisan playground:make:postman Page --force --type playground-model --controller-package resources/configurations/playground-cms-api/package.playground-cms-api.json --model-file resources/configurations/playground-cms/model.page.json
```

#### Add the Snippet end points to the collection

```sh
artisan playground:make:postman Snippet --force --type playground-model --controller-package resources/configurations/playground-cms-api/package.playground-cms-api.json --model-file resources/configurations/playground-cms/model.snippet.json
```


## PHPStan

Tests at level 9 on:
- `config/`
- `lang/`
- `src/`
- `tests/Feature/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
