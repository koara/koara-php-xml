[![Koara](http://www.koara.io/logo.png)](http://www.koara.io)

[![Build Status](https://img.shields.io/travis/koara/koara-php-html.svg)](https://travis-ci.org/koara/koara-php-html)
[![Coverage Status](https://img.shields.io/coveralls/koara/koara-php-html.svg)](https://coveralls.io/github/koara/koara-php-html?branch=master)
[![Latest Version](https://img.shields.io/packagist/v/koara/koara-xml.svg)](https://packagist.org/packages/koara/koara-xml)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://github.com/koara/koara-php-html/blob/master/LICENSE)

# Koara-php-html
[Koara](http://www.koara.io) is a modular lightweight markup language. This project can render the koara AST to Html in php.  
The AST is created by the [core koara parser](https://github.com/koara/koara-php).

## Getting started
- Download [ZIP file](https://github.com/koara/koara-php-xml/archive/0.10.0.zip)
- Composer

  ``` bash
  $ composer require koara/koara-xml
  ```

## Usage
```php
<?php 

require_once __DIR__ . '/vendor/autoload.php';
	
use Koara\Parser;
use Koara\Xml\XmlRenderer;

$parser = new Parser();
$result = $parser->parse("Hello World!"); 
$renderer = new XmlRenderer();
$result->accept($renderer);
echo $renderer->getOutput();

?>
```

## Configuration
You can configure the Renderer:

-  **$renderer->setDeclarationTag($declarationTag)**  
   Default:	`null`
   
   Add an XML Declaration Tag add the top of the generated output.  