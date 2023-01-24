<?php
error_reporting(0);
function curl($param,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}
	
function signup($email,$pass)
	{
		$url = "https://spclient.wg.spotify.com/signup/public/v2/account/create";
		$param = '{
  "account_details": {
    "birthdate": "1999-07-21",
    "consent_flags": {
      "eula_agreed": true,
      "send_email": true,
      "third_party_email": false
    },
    "display_name": "Agatha",
    "email_and_password_identifier": {
      "email": "'.$email.'",
      "password": "'.$pass.'"
    },
    "gender": 1
  },
  "callback_uri": "https://www.spotify.com/signup/challenge?forward_url\u003dhttps%3A%2F%2Fwww.spotify.com%2Faccount%2Foverview%2F\u0026locale\u003did",
  "client_info": {
    "api_key": "a1e486e2729f46d6bb368d6b2bcda326",
    "app_version": "v2",
    "capabilities": [
      1
    ],
    "installation_id": "1e543f1f-0945-4d27-84f0-ea065451435a",
    "platform": "www"
  },
  "tracking": {
    "creation_flow": "",
    "creation_point": "https://www.spotify.com/id/login/",
    "referrer": ""
  }
}';
		$headers = array();
		$headers[] = 'Content-Length: '.strlen($param);
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; RMX2061) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.186 Mobile Safari/537.36';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Accept: */*';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
		return curl($param,$headers,$url);
	}

function authCsrf($method,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}

function getCSRF()
	{
		$url = "https://accounts.spotify.com/en/login";
		$method = "GET";
		$headers = array();
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; RMX2061) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.186 Mobile Safari/537.36';
		$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
		$headers[] = 'Cookie: __Host-device_id=AQASTaFlcfRwTXhko6Y5HZmzSochQ7qB8ghzHLlyBgthfH9Rv8iTUtZ8lf0hHvhQmbGdaN_E8CDrhttjU88OBKO0DzZZE7nTlTM;sp_sso_csrf_token=013acda7193cecfaa271306f303c2b43f45eb6380431363732343535393236303530;__Host-sp_csrf_sid=b7eb719dbaf5cf8c9e5eec8888cc25a813c37db179091fc3d2d324f2d70143bd';
		return authCsrf($method,$headers,$url);
	}

function authlogin($logintoken,$csrf,$csrfsid)
	{
		$url = "https://www.spotify.com/api/signup/authenticate";
		$param = "splot=$logintoken";
		$headers = array();
		$headers[] = 'Content-Length: '.strlen($param);
		$headers[] = 'X-Csrf-Token: '.$csrf;
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; RMX2061) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.186 Mobile Safari/537.36';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		$headers[] = 'Accept: */*';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
		$headers[] = 'Cookie: __Host-sp_csrf_sid='.$csrfsid;
		return curl($param,$headers,$url);
	}

function getAccessToken($token)
	{
		$url = "https://open.spotify.com/get_access_token?reason=transport&productType=web_player";
		$method = "GET";
		$headers = array();
		$headers[] = 'User-Agent: Mozilla/5.0 (Linux; Android 10; RMX2061) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.186 Mobile Safari/537.36';
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		$headers[] = 'Accept: */*';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
		$headers[] = 'cookie: sp_dc='.$token;
		return path($method,$headers,$url);
	}

function activateSamsung($bearer)
	{
		$url = "https://spclient.wg.spotify.com/premium-destination-hubs/v2/page?locale=id&device_id=$devicerand&partner_id=&referrer_id=&build_model=Samsung%20galaxy%207edge&cache_key=free&show_unsafe_unpublished_content=false&manufacturer=Samsung";
		$method = "GET";
		$headers = array();
		$headers[] = 'Accept-Language: id-ID;q=1, en-US;q=0.5';
		$headers[] = 'User-Agent: Spotify/8.6.22 Android/29 (Samsung galaxy 7edge)';
		$headers[] = 'Spotify-App-Version: 8.6.4';
		$headers[] = 'X-Client-Id: 9a8d2f0ce77a4e248bb71fefcb557637';
		$headers[] = 'App-Platform: Android';
		$headers[] = 'Client-Token: AAAe4GtZCWsL2WL1ntKfw8L3fwJQ9X6TW67S3EbkHNSxXpyFelfUiM1SnOtDfIDI5Mw7abFQEarXmPnnQDw8K7lRD/xc33YJbdPkRgkwWVSJMYWyeXXQmJivxDHr4zVMSMb+JQoBUbmhKWnFUXv9Qwtkxwy68KHEITg2wQL3YvtLnEro69gfOBcUpd+jmDl6cd5diPTjM4JXduw7ahv5MTrxk975DsYdaRuu1XA45F3j2e+yfZuPGmXvmXomsMdtaAH1bXplhI40SKPfz4H63ZtsBGKeMdJG37nevN7/A3vLDG0Wz7kX1/DnM79XHtKB/ld5IDoT9js=';
		$headers[] = 'Authorization: Bearer '.$bearer;
		$headers[] = 'Accept-Encoding: gzip';
		return path($method,$headers,$url);
	}

function randUser()
	{
		$fp = file_get_contents('https://names.drycodes.com/1?nameOptions=boy_names');
		$pp = explode('"',$fp)[1];
		$us = explode('"',$pp)[0];
		$p = str_replace('_',' ',$us);
		$change = str_replace('_','',$us);
		return strtolower($change);
	}

function devices()
	{
		if(file_exists(".e")){
			} else {
				file_put_contents('.e', "$saved\n", FILE_APPEND);
				$gask = send();
			}
	}

$Grey   = "\e[1;30m";
$Red    = "\e[0;31m";
$Green  = "\e[0;32m";
$Yellow = "\e[0;33m";
$Blue   = "\e[1;34m";
$Purple = "\e[0;35m";
$Cyan   = "\e[0;36m";
$White  = "\e[0;37m";

function getConfig(){
	if(file_exists("config.json")){
	$file = file_get_contents("config.json");
	$data = json_decode($file, true);
	return $data;
	} else {
		system("touch config.json");
		echo " ▶ Write file config.json\n"; die;
		}
	}

function path($method,$headers,$url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_ENCODING, "GZIP,DEFLATE");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
   		echo 'Error:' . curl_error($ch);
			}
		curl_close($ch);
		return $result;
	}

