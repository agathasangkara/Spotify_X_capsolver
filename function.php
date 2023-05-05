<?php
function curl($param,$headers,$url,$customreq,$post,$curlheader,$method){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		if($post==true){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		}
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
		if($customreq==true){
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if($curlheader==true){
			curl_setopt($ch, CURLOPT_HEADER, 1);
		}
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		 echo 'Error:' . curl_error($ch);
   	 }
		curl_close($ch);
		return $result;
}

function sessionId(){
      return sprintf(
         '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0x0fff) | 0x4000,
         mt_rand(0, 0x3fff) | 0x8000,
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
}

function uniqueId(){
      return sprintf(
         '%04x%04x%04x%04x',
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0x0fff) | 0x4000,
         mt_rand(0, 0x3fff) | 0x8000,
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff),
         mt_rand(0, 0xffff)
      );
}

function randDomain(){
	$arraymail = array('yahoo.com','yahoo.co.id','gmail.com','outlook.com','yahoo.co.id','icloud.com','hotmail.com');
	$datas = array_rand($arraymail, true);
	return $arraymail[$datas];
}

function randomUser($ua){
	$url = "http://ninjaname.horseridersupply.com/indonesian_name.php";
	$param = "number_generate=1&gender_type=male&submit=Generate";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$run = curl($param,$headers,$url,$customreq = null,$post = true,$curlheader = false,$method = null);
	$data = explode('&bull;',$run)[1];
	return explode('<br/>',$data)[0];
}

function randomUseragent(){
	$browser = array('Mozilla','Firefox','Explorer');
	$datas = array_rand($browser, true);
	$browser = $browser[$datas];

	$androidVersion = array('4.0','4.4','5.0','6.0','5.5','7.0','8','9','10','11','12','13');
	$datas = array_rand($androidVersion, true);
	$androidVersion = $androidVersion[$datas];

	$os = array('Windows','Linux');
	$datas = array_rand($os, true);
	$os = $os[$datas];

	$mobile = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 7);
	$chromeVersion = rand(11,99). ".". rand(1,9). ".". rand(1111,9999). ".". rand(10,99);
	$safariVersion = rand(111,999). ".". rand(11,99);
	$browserVersion = rand(1,9). ".". rand(0,9);
	return $ua = "$browser/$browserVersion ($os; Android $androidVersion; $mobile) AppleWebKit/$safariVersion (KHTML, like Gecko) Chrome/$chromeVersion Mobile Safari/$safariVersion";
}

function getConfig($Red){
	if(file_exists("config.json")){
	$file = file_get_contents("config.json");
	return json_decode($file, true);
	} else {
	system("touch config.json");
	echo " $Red !! Write file config.json\n"; die;
	}
}

function signup($email,$pass,$ttl,$username,$iid,$ua,$gender,$apikey){
	$url = "https://spclient.wg.spotify.com/signup/public/v2/account/create";
	$param = '{"account_details":{"birthdate":"'.$ttl.'","consent_flags":{"eula_agreed":true,"send_email":false,"third_party_email":true},"display_name":"'.$username.'","email_and_password_identifier":{"email":"'.$email.'","password":"'.$pass.'"},"gender":'.$gender.'},"callback_uri":"https://www.spotify.com/signup/challenge?locale=id","client_info":{"api_key":"'.$apikey.'","app_version":"v2","capabilities":[1],"installation_id":"'.$iid.'","platform":"www"},"tracking":{"creation_flow":"","creation_point":"https://www.spotify.com/id/premium/","referrer":"checkout"},"recaptcha_token":"null"}';
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Accept: */*';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	return curl($param,$headers,$url,$customreq = null,$post = true,$curlheader = false,$method = null);
}

function generateCsrf($ua){
	$url = "https://accounts.spotify.com/en/login";
	$method = "GET";
	$headers = array();
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: __Host-device_id=AQASTaFlcfRwTXhko6Y5HZmzSochQ7qB8ghzHLlyBgthfH9Rv8iTUtZ8lf0hHvhQmbGdaN_E8CDrhttjU88OBKO0DzZZE7nTlTM;sp_sso_csrf_token=013acda7193cecfaa271306f303c2b43f45eb6380431363732343535393236303530;__Host-sp_csrf_sid=b7eb719dbaf5cf8c9e5eec8888cc25a813c37db179091fc3d2d324f2d70143bd';
	return curl($param =null,$headers,$url,$customreq = true,$post = false,$curlheader = true,$method = "GET");
}

function authlogin($logintoken,$csrf,$csrfsid,$ua){
	$url = "https://www.spotify.com/api/signup/authenticate";
	$param = "splot=$logintoken";
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'X-Csrf-Token: '.$csrf;
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'Accept: */*';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: __Host-sp_csrf_sid='.$csrfsid;
	return curl($param,$headers,$url,$customreq = null,$post = true,$curlheader = true,$method = null);
}

function getAccessToken($token){
	$url = "https://open.spotify.com/get_access_token?reason=transport&productType=web_player";
	$method = "GET";
	$headers = array();
	$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; RMX2061) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.186 Mobile Safari/537.36';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'Accept: */*';
	$headers[] = 'Accept-Encoding: gzip, deflate, br';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'cookie: sp_dc='.$token;
	return curl($param =null,$headers,$url,$customreq = true,$post = false,$curlheader = false,$method = "GET");
}

function generateClient($ua,$did1,$genDevices){
	$url = "https://clienttoken.spotify.com/v1/clienttoken";
	$param = '{"client_data":{"client_version":"1.2.12.1.g9462dde0","client_id":"d8a5ed958d274c2e8ee717e6a4b0971d","js_sdk_data":{"device_brand":"'.$genDevices.'","device_model":"samsung","os":"android","os_version":"2","device_id":"'.$did1.'","device_type":"phone"}}}';
	$headers = array();
	$headers[] = 'Content-Length: '.strlen($param);
	$headers[] = 'Accept: application/json';
	$headers[] = 'User-Agent: '.$ua;
	$headers[] = 'Content-Type: application/json';
	return curl($param,$headers,$url,$customreq = null,$post = true,$curlheader = false,$method = null);
}

function activateSamsung($bearer,$client,$genDevices,$did,$serial){
	$url = "https://spclient.wg.spotify.com/premium-destination-hubs/v2/page?locale=id&device_id=$did&partner_id=&referrer_id=&build_model=$genDevices&cache_key=free&show_unsafe_unpublished_content=false&manufacturer=samsung";
	$method = "GET";
	$headers = array();
	$headers[] = 'Accept-Language: id-ID;q=1, en-US;q=0.5';
	$headers[] = 'User-Agent: Spotify/8.8.14.575 Android/30 '.$serial;
	$headers[] = 'Spotify-App-Version: 8.8.14.575';
	$headers[] = 'X-Client-Id: 9a8d2f0ce77a4e248bb71fefcb557637';
	$headers[] = 'App-Platform: Android';
	$headers[] = 'Client-Token: '.$client;
	$headers[] = 'Authorization: Bearer '.$bearer;
	$headers[] = 'Accept-Encoding: gzip';
	return curl($param =null,$headers,$url,$customreq = true,$post = false,$curlheader = false,$method = "GET");
}

$Grey   = "\e[1;30m";
$Red    = "\e[0;31m";
$Green  = "\e[0;32m";
$Yellow = "\e[0;33m";
$Blue   = "\e[1;34m";
$Purple = "\e[0;35m";
$Cyan   = "\e[0;36m";
$White  = "\e[0;37m";

function banner($Green,$White){
	echo "$Green
  ()                       
  /\          _/_   /)     
 /  )  _   __ /  o // __  ,
/__/__/_)_(_)<__<_//_/ (_/_
     /           />     /  
    '           </     '   "."$White Agathasangkara\n\n";
}

function generateAccount($Red,$White,$Green,$Grey,$Blue){
	
	requirement:
	$load = getConfig($Red);
	//var_dump($load);
	$apikey = $load['Spotify']['apikey_spotify'];
	$email_setting = $load['Setting']['email_auto'];
	$pass = $load['Spotify']['password'];
	
	ceckpoint:
	echo "\n ϟ Berapa akun : ";
	$u = trim(fgets(STDIN));
	for ($i = 0; $i < $u;$i++){
	$ua = randomUseragent();
	if($email_setting == true){
		$username = randomUser($ua);
		$domain = randDomain();
		$uname = str_replace(' ','',$username);
		$randStr = rand(11,99);
		$email = "$uname$randStr@$domain";
	} else {
		$username = randomUser($ua);
		echo "\n ϟ Email : ";
		$email = trim(fgets(STDIN));
		echo " ϟ Pass  : ";
		$pass = trim(fgets(STDIN));
	}
	
	$randMonth = rand(1, 12);
	$randDate = rand(1, 30);
	$bulan = $randMonth < 10 ? $randMonth = "0" . $randMonth : $randMonth = $randMonth;
	$tanggal = $randDate < 10 ? $randDate = "0" . $randDate : $randDate = $randDate;
	$tahun = rand(1980,2003);
	$ttl = "$tahun-$bulan-$tanggal";
	$iid = sessionId();
	$gender = rand(1,4);
	$register = signup($email,$pass,$ttl,$username,$iid,$ua,$gender,$apikey);
	if(preg_match('/login_token/i',$register)){
		$x = json_decode($register, true);
		$logintoken = $x['success']['login_token'];
		//echo "\n$White ϟ ($Green $email $White) Process Claim ";
		} else if(preg_match('/already_exists/i',$register)){
		echo "\n$Red ϟ Sudah ada akun untuk email ini.\n\n$White";
		goto ceckpoint;
		} else{
		var_dump("\n\n$register\n\n"); die;
	}
	
	$gen = generateCsrf($ua);
	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $gen, $matches);
		$cookies = array();
		foreach($matches[1] as $item) {
   		 parse_str($item, $cookie);
   		 $cookies = array_merge($cookies, $cookie);
	}
	
	$csrf = $cookies['sp_sso_csrf_token'];
	$csrfsid = $cookies['__Host-sp_csrf_sid'];
	$login = authlogin($logintoken,$csrf,$csrfsid,$ua);
	preg_match('/sp_dc=([^;]+)/', $login, $matches);
	$token = $matches[1];
	if($token == null){
		echo "\n$Red ϟ Grabber token failure\n\n"; goto ceckpoint;
	}
	$tokentobearer = getAccessToken($token);
	$x = json_decode($tokentobearer, true);
	if($x['isAnonymous'] == false){
		$bearer = $x['accessToken'];
	}
	
		$did = uniqueId();
		$did1 = sessionId();
		$genDevices = "SM-".substr(str_shuffle('ABCEEFGIHJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
		$serial = "($genDevices)";
		$getclient = generateClient($ua,$did1,$genDevices);
		$json = json_decode($getclient, true);
		$client = $json['granted_token']['token'];
		$destinationSpotify = activateSamsung($bearer,$client,$genDevices,$did,$serial);
		echo "\n$White ϟ ($Green $email $White) SUCCESS ";
		$saved = '{"Email":"'.$email.'","Password":"'.$pass.'"}';
		file_put_contents('res_spotify.json', "$saved\n", FILE_APPEND);
	}
	
	echo "\n\n ϟ Done Create Spotify Account by Agathasangkara\n\n$Grey Donasi $White($Blue DANA $White) : 0895415306281\n\n";
}




?>