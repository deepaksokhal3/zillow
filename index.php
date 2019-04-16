
<?php
error_reporting(-1);

$jsonObject = '{
  "identity": {
    "addresses": [
      {
        "data": {
          "zip": "94114",
          "state": "CA",
          "city": "San Francisco",
          "street": "3819 Greenhaven Ln"
        },
        "primary": true
      }
    ],
    "emails": [
      {
        "primary": true,
        "type": "personal",
        "data": "kelly.walters30@example.com"
      }
    ],
    "names": [
      "Kelly Walters"
    ],
    "phone_numbers": [
      {
        "primary": true,
        "type": "home",
        "data": "4673956022"
      }
    ]
  }
}';

ini_set('display_errors', 'On');

function download_page($path) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $path);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$retValue = curl_exec($ch);
	curl_close($ch);
	return $retValue;
}
function simpleXmlToArray($xmlObject) {
	$array = [];
	foreach ($xmlObject->children() as $node) {
		$array[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
	}
	return $array;
}
$sXML = download_page('http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1h0xp17wjd7_4zss3&address=2114+Bigelow+Ave&citystatezip=Seattle%2C+WA');
//
$aux = !empty($sXML) ? explode('ï»¿', $sXML) : NULL;
$temp = utf8_decode(trim($aux[0]));
$xml = (array) simplexml_load_string($temp);
$exitingBoject = json_decode($jsonObject);

foreach ($xml['response']->results as $result) {
	if (count($result) > 0) {
		foreach ((array) $result as $key => $unitdetails) {
			$exist = (array) $exitingBoject->identity;
			$new = (array) $unitdetails;
			foreach ($new as $key => $newValue) {
				if (array_key_exists($exist, $key)) {
					array_push($exist, $new);
				}
				echo '<pre>';
				print_r($exist['addresses']);
				echo '</pre>';
			}
		}
	}

}
