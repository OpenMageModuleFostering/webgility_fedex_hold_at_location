<?php
include_once "../app/Mage.php";
$app = Mage::app('default'); 
$eavSetId = Mage::getSingleton('core/resource')->getConnection('core_write');
	
								//$url = 'http://devportal1.webgility.com/product-licensing.php';
								$url = 'https://portal.webgility.com/product-licensing.php';
								
								if($_REQUEST['type']=="enable_plugin")
								{
									$eavSetId->query("update webgility_settings set `enable`='".$_REQUEST['enable']."'");
									if($_REQUEST['enable']==1)
									{
										$enable="enabled";
									}
									else
									{
										$enable="disabled";
									}
									
									$SetIds=$eavSetId->query("SELECT * FROM `webgility_settings`");
									$row = $SetIds->fetch();
									
									$data1 = array("Product" => "fedex_hal","method" => "updateActivityLog" ,"activity" => "fedexPlugin", "status"=>$enable , "email" => $row['email'] , "Key" => $row['webgility_key']);
								}
								
								if($_REQUEST['type']=="new")
								{
									$name = explode(" ",$_REQUEST['name']);
									$fname = $name[0];
									$lname = $name[1];
									$data1 = array("Product" => "fedex_hal","method" => "addSubscription" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"first_name"=>$fname,"last_name"=>$lname,"phone"=>$_REQUEST['phone']);
									
								}
								else if($_REQUEST['type']=="already")
								{
								$data1 = array("Key" => "c7deec9dce2ba8856f65bfabc3ad0e44 ","Product" => "fedex_hal","method" => "getClientInfo" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
								}
								
								
								//$data1 = array("Key" => "","Product" => "fedex_hal","method" => "getClientInfo" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
								//$data1 = array("Product" => "fedex_hal","method" => "addSubscription" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"first_name"=>'sunil',"last_name"=>'ramsinghani',"phone"=>"9827593423");
								$data_string = json_encode($data1); 
								//$data = "request =".$data_string;
								$request = array("request" => $data_string);

								$final_string = curl_request($url, $request);
								$string = json_decode(json_decode($final_string , true));

								if(isset($string->ClientInfo))
								{
									if($string->ClientInfo->LicenseKey!="")
									{
										
										$eavSetId->query("update webgility_settings set `email`='".$_REQUEST['email']."',`password`='".$_REQUEST['password']."',`webgility_key`='".$string->ClientInfo->LicenseKey."'");
										
										$data1 = array("Key" => $string->ClientInfo->LicenseKey,"Product" => "fedex_hal","method" => "getFedEXHALAPICredential" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
										$data_string = json_encode($data1); 
									//$data = "request =".$data_string;
										$request = array("request" => $data_string);
										$final_string = curl_request($url, $request);
										$string = json_decode(json_decode($final_string , true));

									}
								}
								

								
								$SetIds=$eavSetId->query("SELECT * FROM `webgility_settings`");
								$row = $SetIds->fetch();
								if($string->StatusCode==0 && $row['id']=="")
								{
									
									$eavSetId->query("insert into webgility_settings(`email` ,`password` ) values ('".$_REQUEST['email']."','".$_REQUEST['password']."')");
								}
								
								$arr['StatusMessage'] =	$string->StatusMessage;
								$arr['StatusCode'] =	$string->StatusCode;
								if($_REQUEST['enable']==1)
								{
									$arr['plugin_enable'] =	1;
								}
								echo $_GET['callback']."(".json_encode($arr).");";  // 09

							
function curl_request($url, $fields){
$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
rtrim($fields_string,'&');

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POST,count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

//execute post
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//var_dump($ch);
$response = (string)curl_exec($ch);
curl_close($ch);
return $response;
}							
							
?>