<?php
error_reporting(0);
include ('function.php');
date_default_timezone_set('Asia/Jakarta');
echo "$Green
	    ___  ____  _____  ____  ____  ____  _  _ 
	   / __)(  _ \(  _  )(_  _)(_  _)( ___)( \/ )
	   \__ \ )___/ )(_)(   )(   _)(_  )__)  \  / 
	   (___/(__)  (_____) (__) (____)(__)   (__) \n"."$White               Samsung Galaxy Free 3 Month offer\n\n\n";

echo "\n$Yellow Spotify Validation Offer Samsung Galaxy";
echo "\n$White ▶ 1. Signup Spotify And Get Cookie Browser";
echo "\n ▶ 2. Signup Spotify And Get Bearer Authorization";
echo "\n ▶ 3. Signup And Claim Offer Samsung Galaxy Series 3 Month";
echo "\n\n Choose : ";
$choose = trim(fgets(STDIN));

$load = getConfig();
$email = randUser().rand(111,999)."@gmail.com";
$pass = $load['password'];
echo "\n ▶ $email + $pass";
$register = signup($email,$pass);
list($head,$param) = explode("\r\n\r\n",$register,2);
$json = json_decode($param, true);
if(preg_match('/success/i',$param)){
	$logintoken = $json['success']['login_token'];
	$username = $json['success']['username'];
	} else if(preg_match('/error/i',$param)){
	echo "$Red ▶ IP Rate limited, Please airplane mode ";
	die;
	}

$get = getCSRF();
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $get, $matches);
$cookies = array();
foreach($matches[1] as $item) {
    parse_str($item, $cookie);
    $cookies = array_merge($cookies, $cookie);
}
$csrf = $cookies['sp_sso_csrf_token'];
$csrfsid = $cookies['__Host-sp_csrf_sid'];
$login = authlogin($logintoken,$csrf,$csrfsid);
list($head,$param) = explode("\r\n\r\n",$login,2);
$getok = explode('set-cookie: sp_dc=',$login)[1];
$token = explode(';',$getok)[0];
if($choose == "1"){
	echo "\n$Green ▶ Cookie Browser : $token\n\n";
	die;
	}
if($token == null)
	{
		echo "\n$Red ▶ Grabber Cookie Failed, Please run again"; die;
	}
$getAccess = getAccessToken($token);
$x = json_decode($getAccess, true);
if($choose == "2"){
	$bearer = $x['accessToken'];
	echo "\n$Green ▶ Bearer Authorization : $bearer\n\n";
	die;
	}
if($x['isAnonymous'] == false)
	{
		$bearer = $x['accessToken'];
		echo "\n$White ▶ Successfully Grabber Bearer and Cookie <3";
		$linkdevices = activateSamsung($bearer);
		echo "\n$Green ▶ Successfully Claim Offer Samsung Galaxy Series";
		echo "\n$White ▶ Try to visit Samsung offers and activate immediately\n\n";
		system("xdg-open https://www.spotify.com/id/redirect-in-app/android_premium_promotion/?offerSlug=samsung-global2022-pdp-3m-3m-trial-one-time-code");
		$res_acc = '{"email":"'.$email.'","password":"'.$pass.'"}';
		file_put_contents('res_spotify.json', "$res_acc\n", FILE_APPEND);
	}





