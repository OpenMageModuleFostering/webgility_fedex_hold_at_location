<?php
include_once "../app/Mage.php";
$app = Mage::app('default'); 
$base_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
$eavSetId = Mage::getSingleton('core/resource')->getConnection('core_write');

$arr=array();
$zipcode = $_REQUEST['q'];
$q_id = $_REQUEST['q_id'];

$eavSetId->query("insert into webgility_orders(`orderid` ) values ('".$q_id."')");

 $url = $base_path.'fedex/LocateShipAddressWebServiceClient1.php';

								$data1 = array("data_array_pin" => $zipcode);
							
								$ch = curl_init($url);
								curl_setopt($ch, CURLOPT_POST ,1);
								curl_setopt($ch, CURLOPT_POSTFIELDS ,$data1 );
								curl_setopt($ch, CURLOPT_REFERER, 'http://cart.nova1.webgility.com/zencart_1_5_1');
								curl_setopt($ch, CURLOPT_FOLLOWLOCATION ,1);
								curl_setopt($ch, CURLOPT_HEADER ,0); // DO NOT RETURN HTTP HEADERS
								curl_setopt($ch, CURLOPT_RETURNTRANSFER ,1); // RETURN THE CONTENTS OF THE CALL
								$Rec_Data = curl_exec($ch);
								curl_close($ch);
								
								$arr['name'] =	$Rec_Data;
								
//$arr['name'] =	"test";
echo $_GET['callback']."(".json_encode($arr).");";  // 09


?>