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
									
									$data1 = array("product" => "fedex_hal","method" => "updateActivityLog" ,"activity" => "fedexPlugin", "status"=>$enable , "email" => $row['email'] , "Key" => $row['webgility_key']);
								}
								
								if($_REQUEST['type']=="new")
								{
									$name = explode(" ",$_REQUEST['name']);
									$fname = $name[0];
									$lname = $name[1];
									$data1 = array("product" => "fedex_hal","method" => "addSubscription" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"first_name"=>$fname,"last_name"=>$lname,"phone"=>$_REQUEST['phone']);
									
								}
								else if($_REQUEST['type']=="already")
								{
								$data1 = array("Key" => "c7deec9dce2ba8856f65bfabc3ad0e44 ","product" => "fedex_hal","method" => "getClientInfo" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
								}
								
								
								//$data1 = array("Key" => "","product" => "fedex_hal","method" => "getClientInfo" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
								//$data1 = array("product" => "fedex_hal","method" => "addSubscription" ,"email" => 'sunilr+123@webgility.com', "password"=>'webgility',"first_name"=>'sunil',"last_name"=>'ramsinghani',"phone"=>"9827593423");
								//$data_string = json_encode($data1); 
								$data_string = parseRequest($data1); 

								//$data = "request =".$data_string;

								$request = array("request" => $data_string);
								$final_string = curl_request($url, $request);
								$string = json_decode(parseResponse($final_string),true);

								$SetIds=$eavSetId->query("SELECT * FROM `webgility_settings`");
								$row = $SetIds->fetch();
								if($string['StatusCode']==0 && $row['id']=="")
								{
									
									$eavSetId->query("insert into webgility_settings(`email` ,`password` ) values ('".$_REQUEST['email']."','".$_REQUEST['password']."')");
								}

								if(isset($string['ClientInfo']))
								{
									if($string['ClientInfo']['LicenseKey']!="")
									{
										
										$eavSetId->query("update webgility_settings set `email`='".$_REQUEST['email']."',`password`='".$_REQUEST['password']."',`webgility_key`='".$string['ClientInfo']['LicenseKey']."'");
										
										$data1 = array("Key" => $string['ClientInfo']['LicenseKey'],"product" => "fedex_hal","method" => "getFedEXHALAPICredential" ,"email" => $_REQUEST['email'], "password"=>$_REQUEST['password'],"TrackLogin"=>false,"IsOpenIdLogin"=>false,"other"=>"");
										$data_string = parseRequest($data1);  
									//$data = "request =".$data_string;
										$request = array("request" => $data_string);
										$final_string = curl_request($url, $request);
										$string = json_decode(parseResponse($final_string),true);
										//$string = json_decode(json_decode($final_string , true));

									}
								}
								

								
								
								
								$arr['StatusMessage'] =	$string['StatusMessage'];
								$arr['StatusCode'] =	$string['StatusCode'];
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

/* encrypt request and response*/

function hexToString($hex) {
$str="";
for($i=0; $i<strlen($hex); $i=$i+2 ) {
$temp = hexdec(substr($hex, $i, 2));
if (!$temp) continue;
$str .= chr($temp);
}
return $str;
}

function stringToHex($str) {
$hex="";
$zeros = "";
$len = 2 * strlen($str);
for ($i = 0; $i < strlen($str); $i++){
$val = dechex(ord($str{$i}));
if( strlen($val)< 2 ) $val="0".$val;
$hex.=$val;
}
for ($i = 0; $i < $len - strlen($hex); $i++){
$zeros .= '0';
}
return $hex.$zeros;
}

function parseResponse($str){

$cipher_alg = MCRYPT_RIJNDAEL_128;
$key = "cf6463fafa3b4e94";
$hexiv="eb80101c99b2449fab7eecd7dd19e1d2";
$enc_string = mcrypt_decrypt($cipher_alg, $key,base64_decode($str) , MCRYPT_MODE_CBC, trim(hexToString(trim($hexiv))));
$str = @gzinflate(base64_decode($enc_string));

return $str;
}


function parseRequest($str) {
               

                       //return $str = json_encode($responseArray);
                       $responseArray=$str;
                       
                       $str = json_encode($responseArray);
                       $cipher_alg = MCRYPT_RIJNDAEL_128;
                       $key = "cf6463fafa3b4e94";
                       $hexiv="eb80101c99b2449fab7eecd7dd19e1d2";
                       $comp_string = base64_encode(gzdeflate($str,9));
                       $enc_string = mcrypt_encrypt($cipher_alg, $key,$comp_string , MCRYPT_MODE_CBC, trim(hexToString(trim($hexiv))));
                       return base64_encode($enc_string);
             
               
       }

					
							
?>