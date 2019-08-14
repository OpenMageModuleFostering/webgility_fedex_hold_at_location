<?php

// Copyright 2009, FedEx Corporation. All rights reserved.
// Version 2.0.0

require_once('library/fedex-common.php');

//The WSDL is not included with the sample code.
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "wsdl/GlobalShipAddressService_v1.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");

$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
'CspCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')),
	'UserCredential' => array(
		'Key' => getProperty('userkey'), 
		'Password' => getProperty('userpassword'))
);
$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter'),
	'ClientProductId'=>'',
	'ClientProductVersion'=>'',
	'Localization'=>array('LanguageCode'=>'','LocaleCode'=>'')
	
);
$request['TransactionDetail'] = array('CustomerTransactionId' => '*** Search Locations Request v1 using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'gsai', 
	'Major' => '1', 
	'Intermediate' => '0', 
	'Minor' => '0'
);


$request['BeginningRecordIndex'] =1;
$request['MaximumMatchCount'] =10;
$request['DistanceUnits'] ='MI';

$bNearToPhoneNumber = false;
if ($bNearToPhoneNumber)
{
	$request['LocationsSearchCriterion'] = 'PHONE_NUMBER';
    $request['PhoneNumber'] = getProperty('searchlocationphonenumber'); // Replace 'XXX' with phone number
}
else
{
    $request['LocationsSearchCriterion'] = 'ADDRESS';
	$request['Address'] = array(array('StreetLines'=>''),
										  'City'=>'',
										  'StateOrProvinceCode'=>'',
										  'PostalCode'=>$_REQUEST['data_array_pin'],
										  'CountryCode'=>'US');
}
/*
$request['EffectiveDate'] = date('Y-m-d');


$request['MultipleMatchesAction'] = 'RETURN_ALL';
$request['SortDetail'] = array(
	'Criterion' => 'DISTANCE',
	'Order' => 'LOWEST_TO_HIGHEST'
);
$request['Constraints'] = array(
	'RadiusDistance' => array(
		'Value' => 15.0,
		'Units' => 'KM'
	),
	'ExpressDropOfTimeNeeded' => '15:00:00.00',
	'ResultFilters' => 'EXCLUDE_LOCATIONS_OUTSIDE_STATE_OR_PROVINCE',
	'SupportedRedirectToHoldServices' => array(
		'FEDEX_EXPRESS', 'FEDEX_GROUND', 'FEDEX_GROUND_HOME_DELIVERY'
	),
	'RequiredLocationAttributes' => array(
		'ACCEPTS_CASH','ALREADY_OPEN'
	),
	'ResultsRequested' => 1,
	'LocationContentOptions' => array(
		'HOLIDAYS'
	),
	'LocationTypesToInclude' => array(
		'FEDEX_OFFICE'
	)
);
*/
 //$request['LocationsSearchCriterion'] =
 $request['NearToAddress'] =array('StreetLines'=>'',
										  'City'=>'',
										  'StateOrProvinceCode'=>'',
										  'PostalCode'=>$_REQUEST['data_array_pin'],
										  'CountryCode'=>'',
										  'Residential'=>true
										  );
										  
$request['DropoffServicesDesired'] = array('HoldAtLocation' => 1, 'Ground' => 1, 'Express' => 1);
//print_r($request);
//die();

try 
{
	if(setEndpoint('changeEndpoint'))
	{
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client ->searchLocations($request);
	/*//$response = $client ->searchLocations('<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://fedex.com/ws/gsai/v1"><SOAP-ENV:Body><ns1:SearchLocationsRequest><ns1:WebAuthenticationDetail><ns1:CspCredential><ns1:Key>0ZqHJz0HoExFw2N0</ns1:Key><ns1:Password>XlViitsEA13udiYHifNko7EgV</ns1:Password></ns1:CspCredential><ns1:UserCredential><ns1:Key>cGCXscWPffq8J2Wy</ns1:Key><ns1:Password>UPCK8E2IJU7dI3vYsFSz4yJOV</ns1:Password></ns1:UserCredential></ns1:WebAuthenticationDetail><ns1:ClientDetail><ns1:AccountNumber>472099426</ns1:AccountNumber><ns1:MeterNumber>105283893</ns1:MeterNumber><ns1:ClientProductId></ns1:ClientProductId><ns1:ClientProductVersion></ns1:ClientProductVersion><ns1:Localization><ns1:LanguageCode></ns1:LanguageCode><ns1:LocaleCode></ns1:LocaleCode></ns1:Localization></ns1:ClientDetail><ns1:TransactionDetail><ns1:CustomerTransactionId>*** Search Locations Request v1 using PHP ***</ns1:CustomerTransactionId></ns1:TransactionDetail><ns1:Version><ns1:ServiceId>gsai</ns1:ServiceId><ns1:Major>1</ns1:Major><ns1:Intermediate>0</ns1:Intermediate><ns1:Minor>0</ns1:Minor></ns1:Version><ns1:LocationsSearchCriterion>ADDRESS</ns1:LocationsSearchCriterion><ns1:Address><ns1:City></ns1:City><ns1:StateOrProvinceCode></ns1:StateOrProvinceCode><ns1:PostalCode>85016</ns1:PostalCode><ns1:CountryCode>US</ns1:CountryCode></ns1:Address></ns1:SearchLocationsRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>');
*/
	//mail("sunilr@webgility.com","final hal req",$client->__getLastRequest());
	//mail("sunilr@webgility.com","final hal res",$client->__getLastResponse());
    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR')
    {
	
	$i=0;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="0" id="fedex_tb">
<?php
	 foreach($response->AddressToLocationRelationships->DistanceAndLocationDetails as $hal)
		{

		?>
		 
		 <?php
		 	if($i<10)
			{
	
				$address=$hal->LocationDetail->LocationContactAndAddress->Address;
				$address_map = $address->StreetLines." ".$address->City.",".$address->StateOrProvinceCode.",".$address->PostalCode;
		 		//print_r($hal->LocationDetail->MapUrl);
		 		 //$address = $hal->BusinessName." ".$hal->BusinessDescription." ".$hal->LocationDetail->LocationContactAndAddress->Address->StreetLines." ".$hal->BusinessAddress->City.",".$hal->BusinessAddress->StateOrProvinceCode.",".$hal->BusinessAddress->PostalCode;
				 		$state_array = array("1"=>"AL","2"=>"AK","4"=>"AZ","5"=>"AR","12"=>"CA","13"=>"CO","14"=>"CT","15"=>"DE","16"=>"DC","18"=>"FL","19"=>"GA","21"=>"HI","22"=>"ID","23"=>"IL","24"=>"IN","25"=>"IA","26"=>"KS","27"=>"KY","28"=>"LA","29"=>"ME","31"=>"MD","32"=>"MA","33"=>"MI","34"=>"MN","35"=>"MS","36"=>"MO","37"=>"MT","38"=>"NE","39"=>"NV","40"=>"NH","41"=>"NJ","42"=>"NM","43"=>"NY","44"=>"NC","45"=>"ND","47"=>"OH","48"=>"OK","49"=>"OR","51"=>"PA","53"=>"RI","54"=>"SC","55"=>"SD","56"=>"TN","57"=>"TX","58"=>"UT","59"=>"VT","61"=>"VA","62"=>"WA","63"=>"WV","64"=>"WI","65"=>"WY");
						foreach($state_array as $key=>$value)
						{

							if($address->StateOrProvinceCode==$value) 
							{ 
								$selected =$key; 
							}
							
						}
		 echo '
				  <tr>
					<td width="60%"><input type="radio" id="ship_add" class="hal_radio" name="ship_add" onchange="save_shipment(\''.$hal->BusinessName.'\',\''.$address->StreetLines.'\',\''.$hal->BusinessDescription.'\',\''.$address->City.'\',\''.$selected.'\',\''.$address->PostalCode.'\');">&nbsp;'.$address->StreetLines." ".$address->City." ".$address->StateOrProvinceCode." ".$address->PostalCode.'</td>
					<td width="20%" class="fedex_api">'.round($hal->Distance->Value, 3).' '.$hal->Distance->Units.'</td>
					<td width="20%" class="fedex_api"><a target="_blank" href="http://maps.google.com/?q='.urlencode($address_map).'" >View map</a></td>
				  </tr>';
 
		
		// echo $hal->BusinessName." ".$hal->BusinessDescription." ".$hal->BusinessAddress->StreetLines." ".$hal->BusinessAddress->City." ".$hal->BusinessAddress->StateOrProvinceCode." ".$hal->BusinessAddress->PostalCode."<br/>";
				
		$i++;
		
			}
		}			
	
    	//echo '<table border="1">';
       // printString($response->TotalResultsAvailable, '', 'Total Locations Found');
		//printString($response->ResultsReturned, '', 'Locations Returned');
		//printString('','','Address Information Used for Search');
		//locationDetails($response->AddressToLocationRelationships->MatchedAddress, ''); 
		//printString('','','LocationDetails');
		//locationDetails($response->AddressToLocationRelationships->DistanceAndLocationDetails, '');
		echo '</table>';
       
        //printSuccess($client, $response);
    }
    else
	{
		echo '<table width="100%" border="1" cellspacing="0" cellpadding="0" id="fedex_tb"><tr>
					<td style="padding:5px;">
					<p style="color:red">'.$response->Notifications->Message.'</p>';
				//echo $response->Notifications->Message;
       			// printError($client, $response);
			echo '</td></tr></table>';
    } 
    
    writeToLog($client);    // Write to log file   

} catch (SoapFault $exception) {
    printFault($exception, $client);
}

function printString($value, $spacer, $description){
	echo '<tr><td>'.$description.'</td><td>'.$value.'</td></tr>';
}

function locationDetails($details, $spacer){
	foreach($details as $key => $value){
		if(is_array($value) || is_object($value)){
        	$newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'.'</td><td>'.$spacer .$key.'</td><td>&nbsp;</td></tr>';
    		locationDetails($value, $newSpacer);
    	}elseif(empty($value)){
    		if (!is_numeric($value)){
    			echo '<tr><td>'.'</td><td>'.$spacer.$key .'</td><td>&nbsp;</td></tr>';
    		}
    	}else{
    		echo '<tr><td>'.'</td><td>'.$spacer.$key.'</td><td>'.$value.'</td></tr>';
    	}
    }
}
?>








