<?php

$baseurl = "https://webservices.amazon.co.jp/onca/xml";

// リクエストのパラメータ作成
$params = array();
$params["Service"]          = "AWSECommerceService";
$params["AWSAccessKeyId"]   = Access_Key_ID;
$params["Version"]          = "2013-08-01";
$params["Operation"]        = "ItemSearch";
$params["SearchIndex"]      = $SearchIndex;
$params["Keywords"]         = $Keywords;
$params["AssociateTag"]     = Associate_tag;
$params["ResponseGroup"]    = "ItemAttributes,Offers, Images";
$params["MinimumPrice"]     = "100";
$params["ItemPage"]         = "1";


$base_request = "";
foreach ($params as $k => $v) { $base_request .= "&" . $k . "=" . $v; }
$base_request = $baseurl . "?" . substr($base_request, 1);

$params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
$base_request .= "&Timestamp=" . $params['Timestamp'];

$base_request = "";
foreach ($params as $k => $v) {
	$base_request .= '&' . $k . '=' . rawurlencode($v);
	$params[$k] = rawurlencode($v);
}
$base_request = $baseurl . "?" . substr($base_request, 1);

$base_request = preg_replace("/.*\?/", "", $base_request);
$base_request = str_replace("&", "\n", $base_request);

ksort($params);
$base_request = "";
foreach ($params as $k => $v) { $base_request .= "&" . $k . "=" . $v; }
$base_request = substr($base_request, 1);
$base_request = str_replace("&", "\n", $base_request);

$base_request = str_replace("\n", "&", $base_request);

$parsed_url = parse_url($baseurl);
$base_request = "GET\n" . $parsed_url['host'] . "\n" . $parsed_url['path'] . "\n" . $base_request;

$signature = base64_encode(hash_hmac('sha256', $base_request, Secret_Access_Key, true));
$signature = rawurlencode($signature);

$base_request = "";
foreach ($params as $k => $v) { $base_request .= "&" . $k . "=" . $v; }
$base_request = $baseurl . "?" . substr($base_request, 1) . "&Signature=" . $signature;
