<?php
$API_DOMAIN =	"backendserver.com/";
$request 	=	json_decode($_POST['jsonString'],true);
$action 	=	$request['action'];
$curl 		= 	curl_init();
switch ($action) {
	case 'show_shops':
		show_data('shop/show');
		break;
	case 'show_products':
		show_data('shop/'.$request['shop_id'].'/products');
		break;
	case 'add_shop':
		add_shop('shop',$request);
		break;
	case 'add_product':
		add_product('shop/'.$request['shop_id'].'/product',$request);
		break;
	case 'delete_product':
		delete_product('shop/'.$request['shop_id'].'/product/'.$request['product_id'],$request);
		break;
	case 'update_product':
		update_product('shop/'.$request['shop_id'].'/product/'.$request['product_id'],$request);
		break;
	default:
		# code...
		break;
}
function curlHeader($path){
	global $API_DOMAIN;
	global $curl;
	$url 		=	$API_DOMAIN.$path;
	curl_setopt($curl, CURLOPT_URL, $url);
	return $curl;
}
function curlResponse($curl){
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLINFO_HEADER_OUT, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
	$response    = 	curl_exec($curl);
	$info        = 	curl_getinfo($curl);
	echo $response;
}
function show_data($path){
	$curl =	curlHeader($path);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
	curlResponse($curl);
}
function add_shop($path,$requestArray){
	$curl 			=	curlHeader($path);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestArray));
	curlResponse($curl);
}
function add_product($path,$requestArray){
	$curl 			=	curlHeader($path);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestArray));
	curlResponse($curl);
}
function delete_product($path,$requestArray){
	$curl 			=	curlHeader($path);
	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestArray));
	curlResponse($curl);
}
function update_product($path,$requestArray){
	$curl 			=	curlHeader($path);
	if($requestArray['product_update_type']=='patch'){	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
	}
	else{
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
	}
	curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($requestArray));
	curlResponse($curl);
}
curl_close($curl);