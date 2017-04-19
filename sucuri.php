<?php 

function slice_substr($txt, $start, $end)
{
	return substr($txt, $start, $end-$start);
}

$website_url = "website using sucuri firewall";
$user_agent = "example user_agent";

$cURL = curl_init();

curl_setopt($cURL, CURLOPT_URL, $website_url);
curl_setopt($cURL, CURLOPT_HEADER, FALSE);
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, TRUE); 
curl_setopt($cURL, CURLOPT_TIMEOUT, 30);
curl_setopt($cURL, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($cURL, CURLOPT_USERAGENT, $user_agent);
curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
));

$output = curl_exec($cURL);
curl_close($cURL); 

$js_to_php = str_replace("path=/;max-age=86400'; location.reload();", '', base64_decode(preg_replace(array('/S=\'([^\';]+)(.|\r\n|\n)*/', '/([^\|]*)\|(.*)/'), array("|$1","$2"), $output)));

$js_to_php = str_replace(array('+', 'document.cookie', 'String.fromCharCode('),array('.', 'ee', 'chr('), $js_to_php);
$js_to_php = preg_replace('/;([a-z]+=)/', ";\$$1", $js_to_php);
$js_to_php = preg_replace('/^([a-z]+=)/', "\$$1", $js_to_php);

$js_to_php = str_replace(array("''.",'"".'), array('',''), $js_to_php);

$js_to_php = preg_replace("/\"([^\"]*)\"\.slice\(/", "slice_substr(\"$1\",", $js_to_php);
$js_to_php = preg_replace("/\'([^\']*)\'\.slice\(/", "slice_substr(\"$1\",", $js_to_php);
$js_to_php = preg_replace("/\"([^\"]*)\"\.substr\(/", "substr(\"$1\",", $js_to_php);
$js_to_php = preg_replace("/\'([^\']*)\'\.substr\(/", "substr(\"$1\",", $js_to_php);
$js_to_php = preg_replace("/\'([^\']*)\'\.charAt\(([0-9]{1})/", "substr(\"$1\",$2,1", $js_to_php);
$js_to_php = preg_replace("/\"([^\"]*)\"\.charAt\(([0-9]{1})/", "substr(\"$1\",$2,1", $js_to_php);

$js_to_php = preg_replace(array('/^\$[a-z]/', '/\s\.\s\';$/','/\.\s[a-z];$/'), array('$bb',';','. $bb;'), $js_to_php);

eval($js_to_php);

$ee .=';';
$sucuri_proxy_id = $ee;

$cURL = curl_init();

curl_setopt($cURL, CURLOPT_URL, $website_url);
curl_setopt($cURL, CURLOPT_HEADER, FALSE);
curl_setopt($cURL, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, TRUE); 
curl_setopt($cURL, CURLOPT_TIMEOUT, 30);
curl_setopt($cURL, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($cURL, CURLOPT_USERAGENT, $user_agent);
curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
	"Cookie:".$sucuri_proxy_id
));

$output = curl_exec($cURL);
curl_close($cURL); 

echo $output;

?>
