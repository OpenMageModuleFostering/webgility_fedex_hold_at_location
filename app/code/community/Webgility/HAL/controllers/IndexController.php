<?php
/*
 © Copyright Webgility LLC 2011
    ----------------------------------------
 All materials contained in these files are protected by United States copyright
 law and may not be reproduced, distributed, transmitted, displayed, published or
 broadcast without the prior written permission of Webgility LLC. You may not
 alter or remove any trademark, copyright or other notice from copies of the
 content.
 File last updated: 13/09/2011
*/

class Webgility_HAL_IndexController extends Mage_Core_Controller_Front_Action {        
    public function indexAction() {
	$request = $this->getRequest();
	if(!$request->getParam('request'))
	{
		echo "Access denied!";

	}else
	{
		try
		{
			$xml = Mage::getSingleton('hal/desktop')->parseRequest($request->getParam('request'));		

		}catch (Exception $e)
		{
			echo $e;
		}
	}
	
    }
}
?>