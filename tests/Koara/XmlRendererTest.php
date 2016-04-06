<?php
namespace Koara;

use Koara\Xml\XmlRenderer;

class XmlRendererTest extends \PHPUnit_Framework_TestCase {

	private $renderer;
	private $document;
	
	public function setUp() {
		$parser = new Parser();
		$this->document = $parser->parse("Test");
		$this->renderer = new XmlRenderer();
	}
	
	public function testBasic() {
		$expected = "<document>\n";
 		$expected .= "  <paragraph>\n";
 		$expected .= "    <text>Test</text>\n";
 		$expected .= "  </paragraph>\n";
 		$expected .= "</document>";
		
 		$this->document->accept($this->renderer);
 		$this->assertEquals($expected, $this->renderer->getOutput());
	}
	
	public function testAddDeclarationTag() {
 		$expected = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
 		$expected .= "<document>\n";
 		$expected .= "  <paragraph>\n";
 		$expected .= "    <text>Test</text>\n";
 		$expected .= "  </paragraph>\n";
 		$expected .= "</document>";
	
 		$this->renderer->setDeclarationTag("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
 		$this->document->accept($this->renderer);
 		$this->assertEquals($expected, $this->renderer->getOutput());
	}
	

}