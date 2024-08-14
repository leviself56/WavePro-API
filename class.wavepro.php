<?php
/**
 * @project:	ALRB Web Development
 * @access:		Wed Aug 14 12:09:00 CST 2024
 * @author:		Levi Self <levi@airlinkrb.com>
 **/

class WavePro {

	public $ip;
	public $token;
	public $api_url;

	public function __construct($ip, $user, $pass) {
		$this->api_url	= "https://".$ip."/api/v1.0";
		$this->ip		= $ip;
		$this->token 	= $this->login($ip, $user, $pass);
	}

    private function login($ip, $user, $pass) {
		$login_url = $this->api_url."/user/login";

        $credentials = json_encode(array(
            "username"  =>  $user,
            "password"  =>  $pass
        ));

        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Referer: https://$ip/"
        );

		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $login_url);
		curl_setopt($cURL, CURLOPT_POSTFIELDS, $credentials);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HEADER, true);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURL, CURLOPT_AUTOREFERER, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, $headers);

		$user_agent	=	"Php/7.0 (Debian)";
		curl_setopt($cURL, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($cURL, CURLINFO_HEADER_OUT, false);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL, CURLOPT_ENCODING, "");
        curl_setopt($cURL, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				
		$result     = curl_exec($cURL);
    	$header     = curl_getinfo($cURL);
    	curl_close($cURL);

        preg_match('#x-auth-token: ([^\s]+)#i', $result, $token);
        if (isset($token[1]) && $token[1] != '') {
            return $token[1];
        } else {
			return false;
        }
	}

	private function query($type, $url, $payload=null) {
		$cURL = curl_init();	
		$complete_url = $this->api_url.$url;
		curl_setopt($cURL, CURLOPT_URL, $complete_url);

		switch ($type) {
			case "GET":
				curl_setopt($cURL, CURLOPT_HTTPGET, true);
				break;
			case "POST":
				curl_setopt($cURL, CURLOPT_POST, true);
				break;
			case "PATCH":
				curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, 'PATCH');
				break;
			case "PUT":
				curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, 'PUT');
				break;
			case "DELETE":
				curl_setopt($cURL, CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
			default:
				curl_setopt($cURL, CURLOPT_HTTPGET, true);
		}

		if (isset($payload)) {
			curl_setopt($cURL, CURLOPT_POSTFIELDS, json_encode($payload));
		}
	
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json',
			'x-auth-token: '.$this->token));
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($cURL, CURLOPT_ENCODING, true);
		curl_setopt($cURL, CURLOPT_AUTOREFERER, true);
			
		$user_agent	=	"Php/7.0 (Debian)";
		curl_setopt($cURL, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($cURL, CURLINFO_HEADER_OUT, true);
					
		$result = curl_exec($cURL);
		$header  = curl_getinfo($cURL);
		curl_close($cURL);
	
		$json = json_decode($result, true);
	
		// ERROR CATCHING
		if ($header['http_code'] == "400" || $header['http_code'] == "404" || $header['http_code'] == "409") {
			$error = array("error" =>	array(
				"http_code"	=>	$header['http_code'],
				"url"		=>	$header['url'],
				"header"	=>	$header,
				"result"	=>	$result
			));
			return $error;
		}
		return $json;
	}

	public function GetDevice() {
		$data = $this->query("GET", "/public/device");
		if (!isset($data)) {
			return false;
		}
		if (!empty($data)) {
			return $data;
		} else {
			return false;
		}
	}

	public function GetStatistics() {
		$data = $this->query("GET", "/statistics");
		if (!isset($data[0])) {
			return false;
		}
		if (!empty($data[0])) {
			return $data[0];
		} else {
			return false;
		}
	}

	public function GetWirelessStatistics() {
		$data = $this->query("GET", "/statistics");
		if (!isset($data[0])) {
			return false;
		}
		if (!empty($data[0])) {
			$dataset = array(
				"radios" 		=>	$data[0]['wireless']['radios'],
				"linkQuality"	=>	$data[0]['wireless']['linkQuality'],
				"orientation"	=>	$data[0]['device']['orientation']
			);
			return $dataset;
		} else {
			return false;
		}
	}

	public function GetNeighbors() {
		$data = $this->query("GET", "/tools/discovery/neighbors");
		if (!isset($data[0])) {
			return false;
		}
		if (!empty($data)) {
			return $data;
		} else {
			return false;
		}
	}

	public function GetInterfaces() {
		$data = $this->query("GET", "/statistics");
		if (!isset($data[0])) {
			return false;
		}
		if (!empty($data[0])) {
			return $data[0]['interfaces'];
		} else {
			return false;
		}
	}
}
?>