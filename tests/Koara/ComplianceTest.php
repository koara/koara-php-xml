<?php
namespace Koara;

use Koara\Xml\XmlRenderer;

class ComplianceTest extends \PHPUnit_Framework_TestCase {

	public function provider() {
		$i=0;
		$modules = scandir('testsuite/input');
		foreach ($modules as $module) {
			if($module != '.' && $module != '..' && $module != 'end2end.kd') {
				$testcases = scandir('testsuite/input/'.$module);
				foreach ($testcases as $testcase) {
					if($testcase != '.' && $testcase != '..') {
						$array[$i][0] = $module;
						$array[$i][1] = substr($testcase, 0, -3);
						$i++;
					}
				}
			}
		}
		return $array;
	}
	
	/**
	 * @dataProvider provider
	 */
	public function testKoaraToHtml5($module, $testcase) {		
			$xml = file_get_contents('testsuite/output/xml/'.$module.'/'.$testcase.'.xml');
	  		$xml = mb_convert_encoding($xml, 'UTF-8', mb_detect_encoding($xml, 'UTF-8, ISO-8859-1', true));
		 
	  		$parser = new Parser();
	  		$document = $parser->parseFile('testsuite/input/'.$module.'/'.$testcase.'.kd');
 		
	 		$renderer = new XmlRenderer();
	 		$document->accept($renderer);
	 		
	 		$this->assertEquals($html, $renderer->getOutput());
	}
	

}