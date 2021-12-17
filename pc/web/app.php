<?php

$url = $_GET['url'];
$token= '1718713';//token 
$url = 'https://j.languang.wfss100.com/json/?url='.$url.'&token='.$token; 
function curl_https($url, $timeout=30){    
$ch = curl_init();    
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);   
curl_setopt($ch, CURLOPT_URL, $url);    
curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);    
$response = curl_exec($ch);    
if($error=curl_error($ch)){        
die($error);    }    
curl_close($ch);    
return $response;}
$response = curl_https($url, 5);
echo $response;?>
