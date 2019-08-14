<?php

								//$url = 'http://devportal1.webgility.com/product-licensing.php';
								$url = 'https://portal.webgility.com/product-licensing.php';
								
								$data1 = array("Product" => "fedex_hal","method" => "updateFedEXAccountDetails" ,"meter_no" => $_REQUEST['meter_no'], "account_id"=>$_REQUEST['account_id'] , "email" => $_REQUEST['email'] , "Key" => $_REQUEST['Key']);
									
															
								
								//$data1 = array("Key" => "","Product" => "fedex_hal","method" => "getClientInfo" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
								//$data1 = array("Product" => "fedex_hal","method" => "addSubscription" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"first_name"=>'sunil',"last_name"=>'ramsinghani',"phone"=>"9827593423");
								$data_string = json_encode($data1); 
								
								$request = array("request" => $data_string);
								
								$final_string = curl_request($url, $request);
								$string = json_decode(json_decode($final_string , true));
								

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
