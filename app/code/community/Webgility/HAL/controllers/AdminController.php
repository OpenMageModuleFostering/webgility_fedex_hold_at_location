<?php
/*© Copyright 2013 Webgility Inc
    ----------------------------------------
 All materials contained in these files are protected by United States copyright
 law and may not be reproduced, distributed, transmitted, displayed, published or
 broadcast without the prior written permission of Webgility LLC. You may not
 alter or remove any trademark, copyright or other notice from copies of the
 content.
 
*/

class Webgility_HAL_AdminController extends Mage_Adminhtml_Controller_Action{        
    public function indexAction() {
			$this->loadLayout();
			$this->renderLayout();		
	}
	public function aboutAction()
	{
		
		$this->loadLayout();			
		$this->_addLeft($this->getLayout()
		->createBlock('core/text')
		->setText('&nbsp;'));
		
		$block = $this->getLayout()
		->createBlock('core/text')
		->setText(Mage::getSingleton('hal/WgBaseResponse')->message());           
		$this->_addContent($block);
		$this->renderLayout();
				
	}
	
	public function faqAction()
	{
		
		$this->loadLayout();			
		$this->_addLeft($this->getLayout()
		->createBlock('core/text')
		->setText('&nbsp;'));
		
		$block = $this->getLayout()
		->createBlock('core/text')
		->setText(Mage::getSingleton('hal/WgBaseResponse')->faq());           
		$this->_addContent($block);
		$this->renderLayout();
				
	}		
	
	public function settingsAction()
	{
		
		$this->loadLayout();			
		$this->_addLeft($this->getLayout()
		->createBlock('core/text')
		->setText('&nbsp;'));
		
		$block = $this->getLayout()
		->createBlock('core/text')
		->setText(Mage::getSingleton('hal/WgSettings')->message());           
		$this->_addContent($block);
		$this->renderLayout();
				
	}
		
}
?>