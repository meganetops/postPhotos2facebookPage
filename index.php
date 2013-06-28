<?php 
require'facebook-php-sdk/src/facebook.php';
$facebook = new Facebook(array(
  'appId'  =>'アプリID',
  'secret'=>'アプリsecret',
));
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();

if($user){
	$facebook->setFileUploadSupport(true);
	$pages = $facebook->api("/me/accounts");

	foreach($pages["data"] as $page) {
	    if($page["name"] == "facebookページの名前") {
	         $pid = $page["id"];
	         $result = $facebook->api("/$pid/photos", "post", array(
				'message' => 'Photo Caption',
				'image'   => '@' . realpath("画像のパス"),
	            "access_token" => $page["access_token"]
	         ));
	         //var_dump($result);
	    }
	}
}else{
	$url = $facebook->getLoginUrl(array(
		'scope' => 'publish_stream','manage_pages'
	));
	header('Location:'.$url);
}
