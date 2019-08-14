<?php
/*© Copyright 2013 Webgility Inc
    ----------------------------------------
 All materials contained in these files are protected by United States copyright
 law and may not be reproduced, distributed, transmitted, displayed, published or
 broadcast without the prior written permission of Webgility LLC. You may not
 alter or remove any trademark, copyright or other notice from copies of the
 content.
 
*/

class Webgility_HAL_Model_WgBaseResponse
{
	
	private $responseArray = array();
	public function setStatusCode($StatusCode)
	{
		$this->responseArray['StatusCode'] = $StatusCode;
	}
	public function setStatusMessage($StatusMessage)
	{
		$this->responseArray['StatusMessage'] =$StatusMessage;
	}
	public function getBaseResponce()
	{
		return $this->responseArray;
	}
	
	public function message()
	{
		$modules = Mage::getConfig()->getNode('modules')->children();
		$modulesArray = (array)$modules;
		$ModuleVersion = (array)$modulesArray['Webgility_HAL'];
		$str = '<div><strong>Webgility extension for Fedex Hold At Location</strong></div><div>&nbsp;</div>';
		$str .= '<div>Webgility provides software to help simplify and automate eCommerce your business. We offer a suite of products that enable online retailers to integrate with QuickBooks, streamline order fulfillment, and easily manage inventory. As a certified FedEx CSP partner, our software seamlessly integrates with FedEx services to provide comprehensive shipping solutions. With Hold at FedEx Location, you can offer more shipping options for your customers. With Shiplark, you can process orders and print shipping labels instantly. And eCC allows you to manage shipping, inventory, and QuickBooks from one central place. Webgility has helped thousands of small- and medium-sized companies save time and money by automating their eCommerce. Learn more about us.<br>';
		$str .= 'To get started, visit <a target="_blank" href="http://staging.webgility.com/hold-at-location.php">www.webgility.com</a> ';
		
		$str .= " <div>";
		return $str;		
	
	}
	public function faq()
	{
		//$str .= '<div> To view FAQs or post a question on the Hold at FedEx Location Plugin, please visit our Community Site : <a target="_blank" href="http://community.webgility.com/webgility/topics/hold_at_fedex_location_faqs">click here</a> ';
		//$str .= " </div>";

		$str .= '<div><strong>What does this extension do?</strong></dev>';
		$str .= "<div>This extension gives your customers the option to pick up their FedEx packages at a FedEx retail location. There are 2,400 FedEx locations across the 
		U.S. to choose from, and the plug-in is only available for FedEx Express&reg; and FedEx Ground&reg; services and Magento Community edition.</div></br>";
		
		$str .= '<div><strong>What do I do after I install the extension?</strong></dev>';
		$str .= "<div>From the Webgility tab in your Magento Admin Panel, select Hold at FedEx Location. If you don't have 
		a Webgility Account or FedEx Account, you can register within the extension. Sign in to your FedEx and Webgility Accounts, and enable the plug-in.</div></br>";
		
		$str .= '<div><strong>What FedEx services are supported with Hold at FedEx Location?</strong></dev>';
		$str .= "<div>FedEx Express&reg; and FedEx Ground&reg;.</div></br>";
		
		$str .= '<div><strong>Are there any costs for me or my customer?</strong></dev>';
		$str .= "<div>The extension is free! There are no costs above your regular FedEx rates, and no surcharges for the customer.</div></br>";
		
		$str .= '<div><strong>How do customers select Hold at FedEx Location?</strong></dev>';
		$str .= "<div>Upon checkout, the customer selects \"Ship to different address,\" and then chooses \"Hold at FedEx Location.\"  The customer enters their zip code and selects from the list of FedEx retail locations. They proceed with checkout as usual.
		.</div></br>";
		
		$str .= '<div><strong>What happens if a customer chooses Hold at FedEx location incorrectly?</strong></dev>';
		$str .= "<div>If the order is not processed yet, the customer needs to contact the online store to request a manual change in shipping address.</div></br>";
		
		$str .= '<div><strong>Does this extension work for international orders?</strong></dev>';
		$str .= "<div>No. Hold as FedEx Location is only available within the U.S.</div></br>";
		
		$str .= '<div><strong>What will happen if I upgrade Magento?</strong></dev>';
		$str .= "<div>The extension is compatible with Magento Community editions, v1.7 and up.</div></br>";
		
		$str .= '<div><strong>I run several Magento stores. Do I need several copies of the extension?</strong></dev>';
		$str .= "<div>You only need one extension. You can toggle the extension \"on\" or \"off\" for individual stores within your Admin panel.</div></br>";
		
		$str .= '<div><strong>Do your extensions work with custom themes?</strong></dev>';
		$str .= "<div>Generally, our extensions are compatible with most custom themes if they were installed according to the instructions from the installation guide. However, some problems may occur for a number of third-party themes.
		</div></br>";
		
		$str .= '<div><strong>Who do I contact if I have questions or feedback?</strong></dev>';
		$str .= "<div>Email holdatfedex@webgility.com</br>
		</br>Thank you for installing the Hold at FedEx Location extension by Webgility! Learn more about our other Magento-compatible products at
		 <a target=\"_blank\" href=\"http://www.webgility.com/carts/magento.php\">webgility.com/magento</a></div>";
		
		
		return $str;		
	
	} 
	public function halUrl()
	{
		return $str1 = str_replace('index.php/','hal/hal-magento.php',Mage::getBaseUrl());
		
	} 
}
?>