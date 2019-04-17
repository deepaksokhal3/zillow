<?php
error_reporting(-1);
if (isset($_POST['submit'])) {

	if ($_POST['address']) {
		$params = '&address=' . str_replace(' ', '+', trim($_POST['address']));
	}
	if ($_POST['citystatezip']) {
		$params .= '&citystatezip=' . urlencode(str_replace(' ', '+', $_POST['citystatezip']));
	}

	$zwsId = trim($_POST['zwsId']);
}
$url = 'http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=' . $zwsId . $params . '&rentzestimate=true';
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
function getXml($path) {
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
$sXML = getXml($url);
//
$aux = !empty($sXML) ? explode('ï»¿', $sXML) : NULL;
$temp = utf8_decode(trim($aux[0]));
$xml = (array) simplexml_load_string($temp);
echo '<pre>';
print_r($xml);die;
$exitingBoject = json_decode($jsonObject);
$exist = (array) $exitingBoject->identity;
if (isset($xml['response'])) {
	foreach ($xml['response']->results as $result) {
		if (count($result) > 0) {
			foreach ($result as $key => $unitdetails) {
				$new = (array) $unitdetails;
				foreach ($new as $key => $newValue) {
					if ($key == 'address') {
						array_push($exist['addresses'], $newValue);
					} else {
						$update = (array) $newValue;
						if (isset($exist[$key])) {
							array_push($exist[$key], $update);
						} else {
							$exist[$key][] = (array) $newValue;
						}

					}
				}
				$exitingBoject->identity = $exist;
			}
		}
	}
}
echo json_encode($exitingBoject);