# WP Search Replace CLI

[![Latest Stable Version](https://poser.pugx.org/andreekeberg/wp-search-replace-cli/v/stable)](https://packagist.org/packages/andreekeberg/wp-search-replace-cli) [![Total Downloads](https://poser.pugx.org/andreekeberg/wp-search-replace-cli/downloads)](https://packagist.org/packages/andreekeberg/wp-search-replace-cli) [![License](https://poser.pugx.org/andreekeberg/wp-search-replace-cli/license)](https://packagist.org/packages/andreekeberg/wp-search-replace-cli)

Command line tool to replace serialized strings in WordPress database dump files.

## Requirements

- PHP 4.0.0 or higher

## Installation

```
composer global require andreekeberg/wp-search-replace-cli
```

## Usage

```
wp-search-replace [options]
```

### Options

|Option|Description|Default|
|------|-----------|-------|
|**--input**, **-i**|Path to input file||
|**--search**, **-s**|The value being searched for||
|**--replace**, **-r**|Replacement string||
|**--output**, **-o**|Path to output file (optional)|`STDOUT`|

## Contributing

Read the [contribution guidelines](CONTRIBUTING.md).

## Changelog

Refer to the [changelog](CHANGELOG.md) for a full history of the project.

## License

WP Search Replace CLI is licensed under the [MIT license](LICENSE).
