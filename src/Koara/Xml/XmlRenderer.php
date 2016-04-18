<?php

namespace Koara\Xml;

use Koara\Ast\BlockElement;
use Koara\Ast\ListItem;
use Koara\Ast\Paragraph;
use Koara\Renderer;

class XmlRenderer implements Renderer
{
    /**
     * @var string
     */
    private $out;

    /**
     * @var int
     */
    private $level = 0;

    /**
     * @var int[]
     */
    private $listSequence = [];

    /**
     * @var string
     */
    private $declarationTag;
    
    public function visitDocument($node)
    {
    	$this->out = "";
    	if($this->declarationTag != null) {
	        $this->out = $this->declarationTag."\n";
    	}
    	
        if($node->getChildren() != null && sizeof($node->getChildren()) > 0) {
        	$this->out .= "<document>\n";
	        $node->childrenAccept($this);
	        $this->out .= "</document>";
        } else {
        	$this->out .= "<document />";
        }
    }

    public function visitHeading($node)
    {
        $this->level++;
        $this->indent();
		$this->out .= "<heading level=\"".$node->getValue()."\"";
		if($node->getChildren() != null && sizeof($node->getChildren()) > 0) {
			$this->out .= ">\n";
			$this->level++;
			$node->childrenAccept($this);
			$this->level--;
			$this->indent();
			$this->out .= "</heading>\n";
		} else {
			$this->out .= " />\n";
		}
		$this->level--;
    }

    public function visitBlockQuote($node)
    {
    	$this->level++;
    	$this->indent();
    	$this->out .= "<blockquote";
    	if($node->getChildren() != null && sizeof($node->getChildren()) > 0) {
    		$this->out .= ">\n";
    		$this->level++;
    		$node->childrenAccept($this);
    		$this->level--;
    		$this->indent();
    		$this->out .= "</blockquote>\n";
    		$this->level--;
    	} else {
    		$this->out .= " />\n";
    	}
    }

    public function visitListBlock($node)
    {
    	$this->level++;
    	$this->indent();
    	$this->out .= "<list ordered=\"".($node->isOrdered() ? "true": "false")."\">\n";
    	$node->childrenAccept($this);
    	$this->indent();
    	$this->out .= "</list>\n";
    	$this->level--;
    }

    public function visitListItem($node)
    {
    	$this->level++;
    	$this->indent();
    	$this->out .= "<listitem";
    	if($node->getNumber() != null) {
    		$this->out .= " number=\"".$node->getNumber()."\"";
    	}
    	if($node->getChildren() != null && sizeof($node->getChildren()) > 0) {
    		$this->out .= ">\n";
    		$node->childrenAccept($this);
    		$this->indent();
    		$this->out .= "</listitem>\n";
    	} else {
    		$this->out .= " />\n";
    	}
    	$this->level--;
    }

    public function visitCodeBlock($node)
    {
    	$this->level++;
    	$this->indent();
    	$this->out .= "<codeblock";
    	if($node->getLanguage() != null) {
    		$this->out .= " language=\"".$node->getLanguage()."\"";
    	}
    	if($node->getValue() != null && strlen($node->getValue()) > 0) {
    		$this->out .= ">";
    		$this->level++;
    		$this->out .= $this->escape($node->getValue());
    		$this->level--;
    		$this->out .= "</codeblock>\n";
    		$this->level--;
    	} else {
    		$this->out .= " />\n";
    	}
    }

    public function visitParagraph($node)
    {
    	$this->level++;
    	$this->indent();
    	$this->out .= "<paragraph>\n";
    	$this->level++;
    	$node->childrenAccept($this);
    	$this->level--;
    	$this->indent();
    	$this->out .= "</paragraph>\n";
    	$this->level--;
    }

    public function visitBlockElement($node)
    {
    }

    public function visitImage($node)
    {
    	$this->indent();
      	$this->out .= "<image url=\"".$this->escapeUrl($node->getValue())."\">\n";
		$this->level++;
		$node->childrenAccept($this);
		$this->level--;
		$this->indent();
		$this->out .= "</image>\n";
    }

    public function visitLink($node)
    {
    	$this->indent();
    	$this->out .= "<link url=\"".$this->escapeUrl($node->getValue())."\">\n";
    	$this->level++;
    	$node->childrenAccept($this);
    	$this->level--;
    	$this->indent();
    	$this->out .= "</link>\n";
    }

    public function visitStrong($node)
    {
    	$this->indent();
    	$this->out .= "<strong>\n";
    	$this->level++;
    	$node->childrenAccept($this);
    	$this->level--;
    	$this->indent();
    	$this->out .= "</strong>\n";
    }

    public function visitEm($node)
    {
    	$this->indent();
        $this->out .= "<em>\n";
		$this->level++;
		$node->childrenAccept($this);
		$this->level--;
		$this->indent();
		$this->out .= "</em>\n";
    }

    public function visitCode($node)
    {
    	$this->indent();
    	$this->out .= "<code>\n";
    	$this->level++;
    	$node->childrenAccept($this);
    	$this->level--;
    	$this->indent();
    	$this->out .= "</code>\n";
    }

    public function visitText($node)
    {
    	$this->indent();
    	$this->out .= "<text>";
    	$this->out .= $this->escape($node->getValue());
    	$this->out .= "</text>\n";
    }

    public function escape($text)
    {
        return str_replace(
          array('&', '<', '>', '"'),
          array('&amp;', '&lt;', '&gt;', '&quot;'),
          $text
        );
    }

    public function visitLineBreak($node)
    {
    	$this->indent();
    	$this->out .= "<linebreak />\n";
    }

    public function escapeUrl($text)
    {
        return str_replace(
          array(' ', '"', '`', '<', '>', '[', ']', '\\'),
          array('%20', '%22', '%60', '%3C', '%3E', '%5B', '%5D', '%5C'),
          $text
        );        
    }

    public function indent()
    {
        $repeat = $this->level * 2;
        for ($i = $repeat - 1; $i >= 0; --$i) {
            $this->out .= ' ';
        }
    }

    public function getOutput()
    {
        return trim($this->out);
    }
    
    public function setDeclarationTag($declarationTag) {
    	$this->declarationTag = $declarationTag;
    }
    
}
