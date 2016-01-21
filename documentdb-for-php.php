<?php

$da_date = gmdate('D, d M Y H:i:s T', strtotime('+2 minutes'));
$master = 'master';
$token = '1.0';
$api_version = '2015-08-06';
$apptype = 'application/json';
$useragent = 'documentdb.php.sdk/1.0.0';
$cachecontrol = 'no-cache';


function getauthtoken($master,$token,$sig) {
	$authtoken = "type=".$master."&ver=".$token."&sig=".$sig;
	return $authtoken;
}

function gettoken($master_key,$vrb,$rtype,$rid,$da_date) {
    $key = base64_decode($master_key);
    $st_to_sign = $vrb . "\n" .
                      $rtype . "\n" .
                      $rid . "\n" .
                      $da_date . "\n" .
                      "\n";
    $sig = base64_encode(hash_hmac('sha256', strtolower($st_to_sign), $key, true));
    return $sig;
}

function getauthheaders($apptype,$useragent,$cachecontrol,$da_date,$api_version,$authtoken) {
	 return Array(
             'Accept: ' . $apptype,
             'User-Agent: ' . $useragent,
             'Cache-Control: ' . $cachecontrol,
             'x-ms-date: ' . $da_date,
             'x-ms-version: ' . $api_version,
             'authorization: ' . urlencode($authtoken)
           );
}

function querycoll($host, $db_rid, $coll_rid, $query,$apptype,$useragent,$cachecontrol,$da_date,$api_version,$master,$token,$master_key,$da_date){
	$header = getauthheaders($apptype,$useragent,$cachecontrol,$da_date,$api_version,getauthtoken($master,$token,gettoken($master_key,'POST','docs',$coll_rid,$da_date)));
    $header[] = 'Content-Length:' . strlen($query);
    $header[] = 'Content-Type:application/sql';
    $header[] = 'x-ms-documentdb-isquery:True';
	//print "<pre>";print_r($header);print "</pre>";
    $options = array(
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $query,
    );
    return request($host, "/dbs/" . $db_rid . "/colls/" . $coll_rid . "/docs", $options);
}

 function request($host, $path, $options)
  {
    $curl = curl_init($host . $path);
    curl_setopt($curl, CURLOPT_SSLVERSION, 1);
 //   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLINFO_HEADER_OUT, true);  
curl_setopt($curl,CURLOPT_VERBOSE,true); 
    curl_setopt_array($curl, $options);
//	$information = curl_getinfo($curl);print "<pre>";print_r($information);print "</pre>";
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
	
	
  }