[![Koara](https://www.codeaddslife.com/koara.png)](https://www.codeaddslife.com/koara)

[![Build Status](https://img.shields.io/travis/koara/koara-php-xml.svg)](https://travis-ci.org/koara/koara-php-xml)
[![Coverage Status](https://img.shields.io/coveralls/koara/koara-php-xml.svg)](https://coveralls.io/github/koara/koara-php-xml?branch=master)
[![Latest Version](https://img.shields.io/packagist/v/koara/koara-xml.svg)](https://packagist.org/packages/koara/koara-xml)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://github.com/koara/koara-php-xml/blob/master/LICENSE)

# Koara-php-xml
[Koara](https://www.codeaddslife.com/koara) is a modular lightweight markup language. This project can render the koara AST to Xml in php.  
The AST is created by the [core koara parser](https://github.com/koara/koara-php).

## Getting started
- Download [ZIP file](https://github.com/koara/koara-php-xml/archive/0.15.0.zip)
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