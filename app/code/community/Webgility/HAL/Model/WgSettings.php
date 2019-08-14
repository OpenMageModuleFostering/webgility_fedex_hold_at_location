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

class Webgility_HAL_Model_WgSettings
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
		// Mage::helper("adminhtml")->getUrl("adminhtml/controllername/actionname")
		$system_config_url= Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit/section/hal_options/");
		
		
		$user = Mage::getSingleton('admin/session');
		$userId = $user->getUser()->getUserId();
		$userEmail = $user->getUser()->getEmail();
		$userFirstname = $user->getUser()->getFirstname();
		$userLastname = $user->getUser()->getLastname();
		$userUsername = $user->getUser()->getUsername();
		$userPassword = $user->getUser()->getPassword();
		$phone = Mage::getStoreConfig('general/store_information/phone'); 
		$address = Mage::getStoreConfig('general/store_information/address'); 
		$store_name = Mage::getStoreConfig('general/store_information/name');
		
		$userEmail_web = $user->getUser()->getEmail();
		$userFirstname_web = $user->getUser()->getFirstname();
		$userLastname_web = $user->getUser()->getLastname();
		$userUsername_web = $user->getUser()->getUsername();
		$userPassword_web = $user->getUser()->getPassword();
		
		if($address!="")
		{
			$fedex_address = explode(",",$address);
		}
		$eavSetId = Mage::getSingleton('core/resource')->getConnection('core_write');
		$SetIds=$eavSetId->query("SELECT * FROM `webgility_settings`");
		$row = $SetIds->fetch();
		
		$session = $adminuser = Mage::getSingleton('admin/session');
            /* @var $adminuser Mage_Admin_Model_User */
        $adminuser = $session->getUser();
        $adminuser->setReloadAclFlag(true);
		$session->refreshAcl();
				
		if($row['fedex_email']!="")
		{
			$userEmail = $row['fedex_email'];
		}
		if($row['fedex_name']!="")
		{
			$userFirstname = $row['fedex_name'];
		}
		if($row['fedex_name']!="")
		{
			$userLastname = "";
		}
		if($row['fedex_address1']!="")
		{
			$fedex_address[0] = $row['fedex_address1'];
		}
		if($row['fedex_city']!="")
		{
			$fedex_address[1] = $row['fedex_city'];
		}
		if($row['fedex_zip']!="")
		{
			$fedex_address[3] = $row['fedex_zip'];
		}
		if($row['fedex_phone']!="")
		{
			$phone = $row['fedex_phone'];
		}
		if($row['fedex_company']!="")
		{
			$store_name = $row['fedex_company'];
		}
		
		
		
		
		$add2=$row['fedex_address2'];
		$fax=$row['fedex_fax'];
		$account_no=$row['account_no'];
		$meter_no=$row['Meter_no'];
		$state=$row['fedex_state'];
		
		$enable=$row['enable'];
		if($meter_no!="")
		{
			$system_config_url_meter= "<br><b>Enable/Disable extension <a href=".Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit/section/hal_options/").">Click Here </a></b>";
		}
		$enable_array = array("Yes"=>"1","No"=>"0");
		
		$enable_drop = '<select name="enable" id="enable" >';
		foreach($enable_array as $key=>$value)
		{
			$selected = '';
			if($enable==$value) 
			{ 
				$selected ='selected'; 
			}
			$enable_drop .='<option value="'.$value.'" '.$selected.' >'.$key.'</option>';
		}
		
		$enable_drop .= '</select>';
		
		if($meter_no!="")
		{
			$style_meter='style="display:block;"';
			$meter_value = "value=".$meter_no;
		}
		else
		{
			$style_meter='style="display:none;"';
		}

		
		$base_path = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$stateCollection = Mage::getModel('directory/country')->load('US')->getRegions()->toOptionArray();
		
		$state_array = array("Alabama"=>"AL","Alaska"=>"AK","Arizona"=>"AZ","Arkansas"=>"AR","California"=>"CA","Colorado"=>"CO","Connecticut"=>"CT","Delaware"=>"DE","District Of Columbia"=>"DC","Florida"=>"FL","Georgia"=>"GA","Hawaii"=>"HI","Idaho"=>"ID","Illinois"=>"IL","Indiana"=>"IN","Iowa"=>"IA","Kansas"=>"KS","Kentucky"=>"KY","Louisiana"=>"LA","Maine"=>"ME","Maryland"=>"MD","Massachusetts"=>"MA","Michigan"=>"MI","Minnesota"=>"MN","Mississippi"=>"MS","Missouri"=>"MO","Montana"=>"MT","Nebraska"=>"NE","Nevada"=>"NV","New Hampshire"=>"NH","New Jersey"=>"NJ","New Mexico"=>"NM","New York"=>"NY","North Carolina"=>"NC","North Dakota"=>"ND","Ohio"=>"OH","Oklahoma"=>"OK","Oregon"=>"OR","Pennsylvania"=>"PA","Rhode Island"=>"RI","South Carolina"=>"SC","South Dakota"=>"SD","Tennessee"=>"TN","Texas"=>"TX","Utah"=>"UT","Vermont"=>"VT","Virginia"=>"VA","Washington"=>"WA","West Virginia"=>"WV","Wisconsin"=>"WI","Wyoming"=>"WY");
		
		$state_drop = '<select name="state" id="state" ><option value="">Please select</option>';
		foreach($state_array as $key=>$value)
		{
			$selected = '';
			if($state==$value) 
			{ 
				$selected ='selected'; 
			}
			$state_drop .='<option value="'.$value.'" '.$selected.' >'.$key.'</option>';
		}
		
		$state_drop .= '</select>';
	
		
		if($row["email"]!="")
		{
			//$style='style="display:none;"';
			$style1='style="display:none;"';
			$style='style="display:block;"';
			if($row["Meter_no"]!="")
			{
				$style_meter='style="display:block;"';
			}
			else
			{
				$style_meter='style="display:none;"';
			}
		}
		else
		{
			$style='style="display:none;"';
			$style1='style="display:block;"';
		}
		$state_drop .='</select>';
		//echo $this->getUrl($yourDynamicVariable);
		
		$str = '
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
			<script>
				var jq = jQuery.noConflict();
				function create_account()
				{
					document.getElementById("LoadingImage1").style.display="block";
					var email = document.getElementById("email1").value;
					var pass = document.getElementById("pass1").value;
					var name = document.getElementById("name").value;
					var phone = document.getElementById("phone").value;
					
					if(name=="")
					{
						document.getElementById("LoadingImage1").style.display="none";
						document.getElementById("err_msg").innerHTML = "<b>Please enter name</b>";
						
					}
					else  if(email=="")
					{
						document.getElementById("LoadingImage1").style.display="none";
						document.getElementById("err_msg").innerHTML = "<b>Please enter email</b>";

					}
					else if(pass=="")
					{
						document.getElementById("LoadingImage1").style.display="none";
						document.getElementById("err_msg").innerHTML = "<b>Please enter password</b>";
						
					}
					
					else if(phone==""  && !isNaN(phone))
					{
						document.getElementById("LoadingImage1").style.display="none";
						document.getElementById("err_msg").innerHTML = "<b>Please enter numeric phone</b>";
						
					}
					else
					{
						document.getElementById("crt_account").disabled = true;
						 var data = "email="+ encodeURIComponent(email) +"&password="+ pass+"&name="+ name+"&phone="+ phone+"&type=new"; 
							jq.ajax({
							 url:"'.$base_path.'/fedex//webgility_portal.php",
							 data:data,
							 dataType: "jsonp", // Notice! JSONP <-- P (lowercase)
							 success:function(json){
							document.getElementById("crt_account").disabled = false;
							 if(json.StatusCode == "0")
							 {
							 	document.getElementById("LoadingImage1").style.display="none";
								
								document.getElementById("err_msg").innerHTML="<b>Webgility account created successfully</b>";
								setTimeout(function(){
											document.getElementById("show_webgility").style.display="none";
								
								document.getElementById("fedex_register").style.display="block";
								},3000);
								
								 // do stuff with json (in this case an array)
								//document.getElementById("save_button").style.display="none";
								//document.getElementById("fedex_account").style.display="block";
							}
							else
							{
								document.getElementById("LoadingImage1").style.display="none";
								document.getElementById("err_msg").innerHTML="<b>"+json.StatusMessage+"</b>";
								//alert(json.StatusMessage);
							}
							 },
							 error:function(){
							 document.getElementById("LoadingImage1").style.display="none";
							 document.getElementById("crt_account").disabled = false;
								 alert("Error");
							 },
						});
					}
				}
				
				function already_exist()
				{
					//jq("#LoadingImage").show();
					document.getElementById("LoadingImage").style.display="block";
					document.getElementById("err_msg_1").innerHTML = "";
					var email = document.getElementById("email").value;
					var pass = document.getElementById("password").value;
					
					if(email=="")
					{
						document.getElementById("LoadingImage").style.display="none";
						document.getElementById("err_msg_1").innerHTML = "<b>Please enter email</b>";

					}
					else if(pass=="")
					{
						document.getElementById("LoadingImage").style.display="none";
						document.getElementById("err_msg_1").innerHTML = "<b>Please enter password</b>";
						
					}
					else
					{
						document.getElementById("alrdy_exist").disabled = true;
						 var data = "email="+ encodeURIComponent(email) +"&password="+ pass+"&type=already"; 
							jq.ajax({
							 url:"'.$base_path.'/fedex/webgility_portal.php",
							 data:data,
							 dataType: "jsonp", // Notice! JSONP <-- P (lowercase)
							 success:function(json){
							document.getElementById("alrdy_exist").disabled = false;
							 if(json.StatusCode == "0")
							 {
							 	document.getElementById("LoadingImage").style.display="none";
								
								document.getElementById("plugin").innerHTML="<b>Plugin registered successfully</b>";
								
								setTimeout(function(){
											document.getElementById("show_webgility").style.display="none";
								document.getElementById("fedex_register").style.display="block";
								},3000)
								
								 // do stuff with json (in this case an array)
								//document.getElementById("save_button").style.display="none";
								//document.getElementById("fedex_account").style.display="block";
							}
							else
							{
								
								document.getElementById("LoadingImage").style.display="none";
							
								document.getElementById("err_msg_1").innerHTML="<b>"+json.StatusMessage+"</b>";
							}
							 },
							 error:function(){
							 document.getElementById("LoadingImage").style.display="none";
							 document.getElementById("alrdy_exist").disabled = false;
								 alert("Error");
							 },
						});
					}
				}
				
				function fedex_meter()
				{
					document.getElementById("err_msg_2").innerHTML ="";
					document.getElementById("LoadingImage2").style.display="block";
					var fedex_account = document.getElementById("fedex_account").value;
					var company = document.getElementById("company").value;
					var name = jq.trim(document.getElementById("fedex_name").value);
					var add1 = document.getElementById("add1").value;
					var add2 = document.getElementById("add2").value;
					var city = document.getElementById("city").value;
					var state = document.getElementById("state").value;
					var zip = document.getElementById("zip").value;
					var phone = document.getElementById("fedex_phone").value;
					var fax = document.getElementById("fax").value;
					var email = document.getElementById("email2").value;
					var web_email = document.getElementById("web_email").value;
					var web_key = document.getElementById("web_key").value;
					
					if(fedex_account=="" )
					{
						
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter FedEx account</b>";

					}
					else if(isNaN(fedex_account))
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter numeric FedEx account</b>";

					}
					else if(company=="" )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter company</b>";

					}
					else if(name=="" )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter name</b>";

					}
					else if(add1=="" )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter address 1</b>";

					}
					
					else if(city=="" )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter city</b>";

					}
					else if(state==0 )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter state</b>";

					}
					else if(zip=="" && !isNaN(zip))
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter numeric ZIP/Postal code</b>";

					}
					else if(phone=="" && !isNaN(phone) )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter numeric phone</b>";

					}
					
					else if(email=="" )
					{
						document.getElementById("LoadingImage2").style.display="none";
						document.getElementById("err_msg_2").innerHTML = "<b>Please enter email</b>";

					}
					else
					{
						
						
						document.getElementById("register").disabled = true;
						 var data = "fedex_account="+ encodeURIComponent(fedex_account) +"&company="+ company+"&name="+name+"&add1="+ encodeURIComponent(add1) +"&add2="+ encodeURIComponent(add2)+"&city="+city+"&state="+ state+"&zip="+zip+"&email="+ encodeURIComponent(email) +"&fax="+ fax+"&phone="+phone; 
							jq.ajax({
							 url:"'.$base_path.'/fedex/fedex_meter.php",
							 data:data,
							 dataType: "jsonp", // Notice! JSONP <-- P (lowercase)
							 success:function(json){
							 
							 document.getElementById("register").disabled = true;
							 document.getElementById("LoadingImage2").style.display="none";
							
							
							var meter = json.meter;

							if(meter!="")
							{
								
								document.getElementById("meter_number").style.display="block";
								document.getElementById("fedex_meter_number").value=meter;
								//document.getElementById("enable_plugin").style.display="block";
								update_portal(meter,web_email,web_key,fedex_account);
								 document.getElementById("LoadingImage2").style.display="block";
								document.getElementById("err_msg_2").innerHTML = "<b>Account registered successfully  with FedEx.You will be redirected to enable your plugin.</b>";
								window.setTimeout(function() {

								location.href = "'.$system_config_url.'";
								}, 5000);
								
								//document.getElementById("meter_number").innerHTML="<br/><b>Meter Number : "+json.meter+"</b><br/>";
									
									 // do stuff with json (in this case an array)
									//document.getElementById("save_button").style.display="none";
									//document.getElementById("fedex_account").style.display="block";
									
							}
							else
							{
								 document.getElementById("register").disabled = false;
								document.getElementById("err_msg_2").innerHTML = "<b>There is a problem generating meter number. Please try again.</b>";
							}
							
							
							 },
							 error:function(){
							 document.getElementById("register").disabled = false;
							  document.getElementById("LoadingImage2").style.display="none";
								 alert("Error");
							 },
						});
					}
				}
				
				function update_portal(meter,web_email,web_key,account_no)
				{
					
						 var data = "meter_no="+ encodeURIComponent(meter) +"&account_id="+ account_no+"&email="+encodeURIComponent(web_email)+"&Key="+ encodeURIComponent(web_key); 
						
							jq.ajax({
							 url:"'.$base_path.'/fedex/fedex_webgility.php",
							 data:data,
							 dataType: "jsonp", // Notice! JSONP <-- P (lowercase)
							 success:function(json){
										
							
							 },
							 error:function(){
								// alert("Error");
							 },
						});
					
				}
				
				function show_already_webgility()
				{
					document.getElementById("show_already").style.display = "block";
					document.getElementById("show_new").style.display = "none";
					document.getElementById("create_new").checked = false;
				}
				function show_new_webgility()
				{
					document.getElementById("show_new").style.display = "block";
					document.getElementById("show_already").style.display = "none";
					document.getElementById("already").checked = false;
				}
				
				function configForm_submit()
				{
					document.getElementById("err_msg_2").innerHTML = "";
					document.getElementById("LoadingImage").style.display="block";
					var enable = document.getElementById("enable").value;
					 var data = "enable="+ encodeURIComponent(enable) +"&type=enable_plugin"; 
							jq.ajax({
							 url:"'.$base_path.'/fedex/webgility_portal.php",
							 data:data,
							 dataType: "jsonp", // Notice! JSONP <-- P (lowercase)
							 success:function(json){
							 if(json.plugin_enable==1)
							 {
								 alert("Hold at FedEx Location Enabled");
							}
							else
							{
								 alert("Hold at FedEx Location Disabled");
							}
							location.reload();
							 },
							 error:function(){
								 alert("Error");
							 },
						});
					
				}
				
			</script>
			
		<div class="main-col-inner">
                            <div id="messages"></div>

						
						<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-bottom:#999999 solid 1px; border-right:#999999 solid 1px; border-top:#999999 solid 1px; border-left:#999999 solid 1px;">
	  <tr>
		<td colspan="2" valign="middle" bgcolor="#6F8992"><span style="color:#FFFFFF; padding-left:8px; font-size:1.05em;"><b>Register your plug-in</b></span></td>
	  </tr>
	  <tr>
	  <td width="20px;">
	  </td>
		<td>
		<div id="show_webgility" '.$style1.'>
			<form action="" method="post">
				<table width="50%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="30" style="padding-top:8px;">Enter your Webgility credentials, or create a new Webgility account</td>
    </tr>
  <tr>
    <td colspan="2" headers="30"><input name="create_new"  id="create_new" type="radio" value="create_new" checked onClick="show_new_webgility();"/> &nbsp;Create a Webgility Account<br/>
    <br/></td>
    </tr>
<tr>
	<td>
		<div id="show_new" >
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td  height="30" style="padding-left:30px;">Name  * </td>
				<td ><input type="text" id="name" name="name" style="width: 274px;" value="'.$userFirstname_web.' '.$userLastname_web.'"/></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;">Email *  </td>
				<td><input type="text" id="email1" name="email1" style="width: 274px;"  value="'.$userEmail_web.'" /></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;">Password  * </td>
				<td><input type="password" id="pass1" name="pass1" style="width: 274px;"/></td>
			  </tr>
			 
			  <tr>
				<td height="30" style="padding-left:30px;">Phone  * </td>
				<td><input type="text" id="phone" name="phone" style="width: 274px;" value="'.$phone.'"/></td>
			  </tr>
			   <tr>
				<td height="30" style="padding-left:30px;"></td>
				<td><input type="checkbox" id="tnc" name="tnc"/>&nbsp;&nbsp;I agree to <a href="http://www.webgility.com/hal/license.txt" target="_blank">Webgility License</a>, <a href="http://www.webgility.com/terms_and_conditions.php" target="_blank">Terms & Conditions</a> and <a href="http://www.webgility.com/privacy_policy.php" target="_blank">Privacy Policy</a></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><div id="create_disply_message"><input type="button" value="Create Account" onClick="create_account();" id="crt_account" /></div><div id="LoadingImage1" style="display: none; padding-top:15px;">
			<img src="'.$base_path.'/downloader/skin/images/ajax-loader-tr.gif">
			</div></td>
			  </tr>
			 <tr><td>&nbsp;</td><td><div id="err_msg" style="color:red;"></div></td></tr>
			  <tr>
				<td  height="30" style="padding-left:30px;">* Required fields </td>
				<td ></td>
			  </tr>
		</table>
	</td>
	</tr>
</table>

			</form>
			
			
			<form action="" method="post">
				<table width="50%" border="0" cellspacing="0" cellpadding="0">
 
  <tr>
    <td colspan="2" headers="30"><input name="already" id="already" type="radio" value="create_new"  onclick="show_already_webgility();"/> &nbsp;Already have a Webgility Account<br/><br/></td>
    </tr>
 <tr>
 	<td colspan="2">
		<div id="show_already" style="display:none;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td height="30" style="padding-left:30px;">Email  * </td>
				<td><input type="text" name="email" id="email" style="width: 274px;" value="'.$row["email"].'" /></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;">Password * </td>
				<td><input type="password" name="password" id="password" style="width: 274px;"  value="'.$row["password"].'"/></td>
			  </tr>
			  
			  <tr>
				<td>&nbsp;</td>
				<td><div id="plugin"><input type="button" value="Connect" onClick="already_exist();" id="alrdy_exist"/></div><div id="LoadingImage" style="display: none; padding-top:15px;">
			<img src="'.$base_path.'/downloader/skin/images/ajax-loader-tr.gif">
			</div></td>
			  </tr>
			  <tr><td>&nbsp;</td><td><div id="err_msg_1" style="color:red;"></div></td></tr>
			   <tr>
				<td  height="30" style="padding-left:30px;">* Required fields </td>
				<td ></td>
			  </tr>
			</table>
			</div>
		</td>
	</tr>
</table>

			</form>
			</div>
		</td>
	  </tr>
	</table>
	
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#999999" style="border-bottom:#999999 solid 1px; border-right:#999999 solid 1px; border-top:#999999 solid 1px; border-left:#999999 solid 1px;">
	  <tr>
		<td colspan="2" valign="middle" bgcolor="#6F8992"><span style="color:#FFFFFF; padding-left:8px; font-size:1.05em;"><b>Register with FedEx</b></span></td>
	  </tr>
	  <tr>
	  <td width="20px;">
	  </td>
		<td>
		<div id="fedex_register" '.$style.'>
			
				<table width="50%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="30" style="padding-top:8px;">Please register your FedEx account<br/><br/></td>
    </tr>
<tr>
	<td>
		<div id="show_new">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="42%" height="30" style="padding-left:30px;"> FedEx Account * </td>
				<td width="58%"><input type="text" id="fedex_account" name="fedex_account" style="width: 174px;" onclick="" value="'.$account_no.'" /><br>Need a FedEx account? <a target="_blank"  href="https://www.fedex.com/fcl/web/jsp/contactInfo1.jsp?appName=oadr&locale=us_en&step3URL=https%3A%2F%2Fwww.fedex.com%2Ffcl%2FExistingAccountFclStep3&afterwardsURL=https%3A%2F%2Fwww.fedex.com%2Ffcl%2Foptionhome&programIndicator=ss90705920">Click here<br><br></td>
			  </tr>
			 <tr>
			  	<td colspan="2">
				<div id="meter_number" '.$style_meter.'>
				<table width="100%">
				<tr>	
					<td width="42%"  height="30" style="padding-left:30px;"> Meter Number </td>
					<td width="58%"><input type="text" id="fedex_meter_number" name="fedex_meter_number" style="width: 274px;" readonly '.$meter_value.' /></td>
				</tr>
				</table>
				</div>
				</td>
			  </tr>
			  
			  <tr>
				<td height="30" style="padding-left:30px;"> Company * </td>
				<td><input type="text" id="company" name="company" style="width: 274px;" value="'.$store_name.'" /></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;"> Contact name * </td>
				<td><input type="text" id="fedex_name" name="fedex_name" style="width: 274px;" value="'.$userFirstname.' '.$userLastname.'"/></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;"> Address 1 * </td>
				<td><input type="text" id="add1" name="add1" style="width: 274px;" value="'.$fedex_address[0].'"/></td>
			  </tr>
			   <tr>
				<td height="30" style="padding-left:30px;"> Address 2 </td>
				<td><input type="text" id="add2" name="add2" style="width: 274px;" value="'.$add2.'"/></td>
			  </tr>
			   <tr>
				<td height="30" style="padding-left:30px;"> City * </td>
				<td><input type="text" id="city" name="city" style="width: 274px;" value="'.$fedex_address[1].'"/></td>
			  </tr>
			   <tr>
				<td height="30" style="padding-left:30px;"> State*  </td>
				<td>'.$state_drop.'</td>
			  </tr>
			   <tr>
				<td height="30" style="padding-left:30px;"> ZIP/Postal code * </td>
				<td><input type="text" id="zip" name="zip" style="width: 274px;" value="'.$fedex_address[3].'" maxlength = "5"/></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;"> Phone * </td>
				<td><input type="text" id="fedex_phone" name="fedex_phone" style="width: 274px;" value="'.$phone.'" maxlength = "10"/></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;"> Fax  </td>
				<td><input type="text" id="fax" name="fax" style="width: 274px;" value="'.$fax.'"/></td>
			  </tr>
			  <tr>
				<td height="30" style="padding-left:30px;"> Email * </td>
				<td><input type="text" id="email2" name="email2" style="width: 274px;" value="'.$userEmail.'"/></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><input type="button" value="Register" onClick="fedex_meter();" id="register" /><input type="hidden" id="web_email" name="web_email" style="width: 274px;" value="'.$row["email"].'"/><input type="hidden" id="web_key" name="web_key" style="width: 274px;" value="'.$row["webgility_key"].'"/><div id="LoadingImage2" style="display: none;  padding-top:15px;">
			<img src="'.$base_path.'/downloader/skin/images/ajax-loader-tr.gif">
			</div></td>
			  </tr>
			  <tr><td>&nbsp;</td><td><div id="err_msg_2" style="color:black; line-height:25px;"></div></td></tr>
			  
			  <tr><td>&nbsp;</td><td>'.$system_config_url_meter.'</td></tr>
			   <tr>
				<td  height="30" style="padding-left:30px;">* Required fields </td>
				<td ></td>
			  </tr>
		</table>
		
	</td>
	</tr>
</table>
</div>
</td>
	</tr>
</table>

	</td>
	</tr>
</table>

						
                   </div>';
		//$str .= "to download a free trial of the eCC Desktop software.<br>";
		$str .= " <div>";
		//$str .= '<div>Once eCC is installed on your desktop, enter this as your eCC Store Module URL to get connected to this store : <a target="_blank" href="'.$this->eccUrl().'">'.$this->eccUrl().'</a></div>';
		//$str .= '<div><br>Copy this key to the eCC Desktop software when connecting to the store : <strong>'.(string)Mage::getConfig()->getNode('global/crypt/key') .'</strong></div><div>&nbsp;</div>'; 
		//$str .= '<div>eCC Magento Go v'.$ModuleVersion['version'].'<br>Last updated: 11/12/2011<br>&copy; 2011 Webgility LLC</div>'; 
		return $str;		
	
	} 
	public function eccUrl()
	{
		return $str1 = str_replace('index.php/','ecc/ecc-magento.php',Mage::getBaseUrl());
		
	} 
}
?>