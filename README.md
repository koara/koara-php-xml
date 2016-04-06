[![Koara](http://www.koara.io/logo.png)](http://www.koara.io)

[![Build Status](https://img.shields.io/travis/koara/koara-php-xml.svg)](https://travis-ci.org/koara/koara-php-xml)
[![Coverage Status](https://img.shields.io/coveralls/koara/koara-php-xml.svg)](https://coveralls.io/github/koara/koara-php-xml?branch=master)
[![Latest Version](https://img.shields.io/packagist/v/koara/koara-xml.svg)](https://packagist.org/packages/koara/koara-xml)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://github.com/koara/koara-php-xml/blob/master/LICENSE)

# koara-php-xml
[Koara](http://www.koara.io) is a modular lightweight markup language. This project is for parsing Koara to Xml without external dependencies.

## Getting Started
This project can be installed via Composer:

``` bash
$ composer require koara/koara-xml
```

## Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Koara\Parser;
use Koara\Module;
use Koara\Renderer\XmlRenderer;

$parser = new Parser();

// Enable which modules to parse (all are parsed by default)
$parser->setModules("paragraphs", "headings", "lists", "links", "images", "formatting", "blockquotes", "code");

// Parse string or file and generate AST
$document = $parser->parse('Hello World!');

// Render as Xml
$renderer = new XmlRenderer();
$document->accept($renderer);

echo $renderer->getOutput();
```

## Configuration
### Parser
### Renderer
- `setDeclarationTag()`: 
  Add a declaration tag to the XML document.
