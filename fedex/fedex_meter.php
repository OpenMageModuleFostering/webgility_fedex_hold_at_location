<?php

include_once "../app/Mage.php";
$app = Mage::app('default'); 

$name = explode(" ",$_REQUEST['name']);
$fname = $name[0];
$lname = $name[1];

//$xml_data ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v2="http://fedex.com/ws/registration/v2"> <soapenv:Body> <v2:RegisterWebCspUserRequest> <v2:WebAuthenticationDetail> <v2:CspCredential> <v2:Key>TWAlZC3VUB3XAi6J</v2:Key> <v2:Password>KqHbNMxIPiCFtjhDVZVPYfvjK</v2:Password> </v2:CspCredential> </v2:WebAuthenticationDetail> <v2:ClientDetail> <v2:AccountNumber>'.$_REQUEST["fedex_account"].'</v2:AccountNumber> <v2:ClientProductId>XFEN</v2:ClientProductId> <v2:ClientProductVersion>8197</v2:ClientProductVersion> </v2:ClientDetail> <v2:Version> <v2:ServiceId>fcas</v2:ServiceId> <v2:Major>2</v2:Major> <v2:Intermediate>1</v2:Intermediate> <v2:Minor>0</v2:Minor> </v2:Version> <v2:BillingAddress> <v2:StreetLines>'.$_REQUEST["add1"].'</v2:StreetLines> <v2:StreetLines>'.$_REQUEST["add2"].'</v2:StreetLines> <v2:City>'.$_REQUEST["city"].'</v2:City> <v2:StateOrProvinceCode>'.$_REQUEST["state"].'</v2:StateOrProvinceCode> <v2:PostalCode>'.$_REQUEST["zip"].'</v2:PostalCode> <v2:CountryCode>US</v2:CountryCode> </v2:BillingAddress> <v2:UserContactAndAddress> <v2:Contact> <v2:PersonName> <v2:FirstName>'.$fname.'</v2:FirstName> <v2:LastName>'.$lname.'</v2:LastName> </v2:PersonName> <v2:CompanyName>'.$_REQUEST["company"].'</v2:CompanyName> <v2:PhoneNumber>'.$_REQUEST["phone"].'</v2:PhoneNumber> <v2:EMailAddress>'.$_REQUEST["email"].'</v2:EMailAddress> </v2:Contact> <v2:Address> <v2:StreetLines>'.$_REQUEST["add1"].'</v2:StreetLines> <v2:StreetLines>'.$_REQUEST["add2"].'</v2:StreetLines> <v2:City>'.$_REQUEST["city"].'</v2:City> <v2:StateOrProvinceCode>'.$_REQUEST["state"].'</v2:StateOrProvinceCode> <v2:PostalCode>'.$_REQUEST["zip"].'</v2:PostalCode> <v2:CountryCode>US</v2:CountryCode> </v2:Address> </v2:UserContactAndAddress> </v2:RegisterWebCspUserRequest> </soapenv:Body> </soapenv:Envelope>';

$xml_data ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v2="http://fedex.com/ws/registration/v2"> <soapenv:Body> <v2:RegisterWebCspUserRequest> <v2:WebAuthenticationDetail> <v2:CspCredential> <v2:Key>0ZqHJz0HoExFw2N0</v2:Key> <v2:Password>XlViitsEA13udiYHifNko7EgV</v2:Password> </v2:CspCredential> </v2:WebAuthenticationDetail> <v2:ClientDetail> <v2:AccountNumber>'.$_REQUEST["fedex_account"].'</v2:AccountNumber> <v2:ClientProductId>XFEN</v2:ClientProductId> <v2:ClientProductVersion>9173</v2:ClientProductVersion> </v2:ClientDetail> <v2:Version> <v2:ServiceId>fcas</v2:ServiceId> <v2:Major>2</v2:Major> <v2:Intermediate>1</v2:Intermediate> <v2:Minor>0</v2:Minor> </v2:Version> <v2:BillingAddress> <v2:StreetLines>'.$_REQUEST["add1"].'</v2:StreetLines> <v2:StreetLines>'.$_REQUEST["add2"].'</v2:StreetLines> <v2:City>'.$_REQUEST["city"].'</v2:City> <v2:StateOrProvinceCode>'.$_REQUEST["state"].'</v2:StateOrProvinceCode> <v2:PostalCode>'.$_REQUEST["zip"].'</v2:PostalCode> <v2:CountryCode>US</v2:CountryCode> </v2:BillingAddress> <v2:UserContactAndAddress> <v2:Contact> <v2:PersonName> <v2:FirstName>'.$fname.'</v2:FirstName> <v2:LastName>'.$lname.'</v2:LastName> </v2:PersonName> <v2:CompanyName>'.$_REQUEST["company"].'</v2:CompanyName> <v2:PhoneNumber>'.$_REQUEST["phone"].'</v2:PhoneNumber> <v2:EMailAddress>'.$_REQUEST["email"].'</v2:EMailAddress> </v2:Contact> <v2:Address> <v2:StreetLines>'.$_REQUEST["add1"].'</v2:StreetLines> <v2:StreetLines>'.$_REQUEST["add2"].'</v2:StreetLines> <v2:City>'.$_REQUEST["city"].'</v2:City> <v2:StateOrProvinceCode>'.$_REQUEST["state"].'</v2:StateOrProvinceCode> <v2:PostalCode>'.$_REQUEST["zip"].'</v2:PostalCode> <v2:CountryCode>US</v2:CountryCode> </v2:Address> </v2:UserContactAndAddress> </v2:RegisterWebCspUserRequest> </soapenv:Body> </soapenv:Envelope>';

//mail("sunilr@webgility.com","final register req",$xml_data);

$url = "https://ws.fedex.com:443/web-services";
//$url = "https://wsbeta.fedex.com:443/web-services";

$first_register = curl_request($url, $xml_data);
//mail("sunilr@webgility.com","final register req",$first_register);
//$xmlTree = new SimpleXMLElement($first_register);
/*$xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><env:Header xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"/><soapenv:Body><v2:RegisterWebCspUserReply xmlns:env="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:v2="http://fedex.com/ws/registration/v2"><v2:HighestSeverity>SUCCESS</v2:HighestSeverity><v2:Notifications><v2:Severity>SUCCESS</v2:Severity><v2:Source>fcas</v2:Source><v2:Code>0000</v2:Code><v2:Message>Success</v2:Message></v2:Notifications><v2:Version> <v2:ServiceId>fcas</v2:ServiceId> <v2:Major>2</v2:Major> <v2:Intermediate>1</v2:Intermediate> <v2:Minor>0</v2:Minor> </v2:Version><v2:Credential><v2:Key>zU9AlTKIJ6avb35X</v2:Key><v2:Password>qxxKxFp4ytkEQprMy8xLNUR1M</v2:Password></v2:Credential></v2:RegisterWebCspUserReply></soapenv:Body></soapenv:Envelope>');
*/
//$xml_element = new SimpleXMLElement($first_register); // SOAP XML
//$xml = simplexml_load_string($first_register);
$xml = simplexml_load_string($first_register, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
$xml->registerXPathNamespace('v2', 'http://www.ebxml.org/namespaces/messageHeader');

$key = (string)$xml->children('soapenv', true)->Body->children('v2', true)->RegisterWebCspUserReply->Credential->Key;
$Password = (string)$xml->children('soapenv', true)->Body->children('v2', true)->RegisterWebCspUserReply->Credential->Password;


if($key!="" && $Password!="")
{
	$xml_data ="<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' xmlns='http://fedex.com/ws/registration/v2'>
	                                    <soapenv:Body>
		                                <SubscriptionRequest xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:xsd='http://www.w3.org/2001/XMLSchema'><WebAuthenticationDetail> <CspCredential> <Key>0ZqHJz0HoExFw2N0</Key> <Password>XlViitsEA13udiYHifNko7EgV</Password> </CspCredential> <UserCredential> <Key>".$key."</Key> <Password>".$Password."</Password> </UserCredential> </WebAuthenticationDetail> <ClientDetail> <AccountNumber>".$_REQUEST["fedex_account"]."</AccountNumber> <MeterNumber/> <ClientProductId>XFEN</ClientProductId> <ClientProductVersion>9173</ClientProductVersion> </ClientDetail>  <TransactionDetail>
                                            <CustomerTransactionId>Subscribe WebServices for 630081440</CustomerTransactionId>
                                        </TransactionDetail><Version> <ServiceId>fcas</ServiceId> <Major>2</Major> <Intermediate>0</Intermediate> <Minor>0</Minor> </Version> <CspSolutionId>182</CspSolutionId> <CspType>CERTIFIED_SOLUTION_PROVIDER</CspType> <Subscriber> <AccountNumber>".$_REQUEST["fedex_account"]."</AccountNumber> <Contact> <PersonName>".$_REQUEST['name']."</PersonName> <CompanyName>".$_REQUEST["company"]."</CompanyName> <PhoneNumber>".$_REQUEST["phone"]."</PhoneNumber> <FaxNumber/> <EMailAddress>".$_REQUEST["email"]."</EMailAddress> </Contact> <Address> <StreetLines>".$_REQUEST["add1"]." ".$_REQUEST["add2"]."</StreetLines> <City>".$_REQUEST["city"]."</City> <StateOrProvinceCode>".$_REQUEST["state"]."</StateOrProvinceCode> <PostalCode>".$_REQUEST["zip"]."</PostalCode> <CountryCode>US</CountryCode> </Address> </Subscriber> <AccountShippingAddress> <StreetLines>".$_REQUEST["add1"]." ".$_REQUEST["add2"]."</StreetLines> <City>".$_REQUEST["city"]."</City> <StateOrProvinceCode>".$_REQUEST["state"]."</StateOrProvinceCode> <PostalCode>".$_REQUEST["zip"]."</PostalCode> <CountryCode>US</CountryCode> </AccountShippingAddress> </SubscriptionRequest> </soapenv:Body> </soapenv:Envelope> ";

	//mail("sunilr@webgility.com","final register req",$xml_data);
	$url = "https://ws.fedex.com:443/web-services";
	//$url = "https://wsbeta.fedex.com:443/web-services";
	$first_subscribe = curl_request($url, $xml_data);
	//mail("sunilr@webgility.com","final register req",$first_subscribe);

	$xml = simplexml_load_string($first_subscribe, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
	$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
	$xml->registerXPathNamespace('v2', 'http://www.ebxml.org/namespaces/messageHeader');
	$meter = (string)$xml->children('soapenv', true)->Body->children('v2', true)->SubscriptionReply->MeterNumber;
	
		$eavSetId = Mage::getSingleton('core/resource')->getConnection('core_write');
	
		$eavSetId->query("update webgility_settings set `csp_key` ='".$key."',`csp_password`='".$Password."',`account_no`='".$_REQUEST["fedex_account"]."',`Meter_no`='".$meter."',`fedex_name` ='".$_REQUEST['name']."',`fedex_company`='".$_REQUEST["company"]."',`fedex_address1`='".$_REQUEST["add1"]."',`fedex_address2`='".$_REQUEST["add2"]."',`fedex_city`='".$_REQUEST["city"]."',`fedex_state`='".$_REQUEST["state"]."',`fedex_zip` ='".$_REQUEST["zip"]."',`fedex_phone`='".$_REQUEST["phone"]."',`fedex_fax`='".$_REQUEST["fax"]."',`fedex_email`='".$_REQUEST["email"]."'");

	  	$arr['meter'] =	$meter;
		//$arr['meter'] =	"118570584";						
		echo $_GET['callback']."(".json_encode($arr).");";  // 09
	
}



function curl_request($url, $fields){

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

//execute post
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//var_dump($ch);
$response = (string)curl_exec($ch);
curl_close($ch);
return $response;
}					
?>
