<?
class HpAlm {

	private $qcUrl;

	private $user;

	private $pass;

	public function __construct($qcUrl, $user, $pass) {
		$this->qcUrl = $qcUrl;
		$this->user = $user;
		$this->pass = $pass;
	}

	public function retrieve($project) {
		$qc = curl_init();
		$ckfile = tempnam ("/tmp", "CURLCOOKIE");

		$xmlSource = '';
		
		curl_setopt($qc, CURLOPT_URL, $this->qcUrl."/rest/is-authenticated");
		curl_setopt($qc, CURLOPT_HEADER, 0);
		curl_setopt($qc, CURLOPT_HTTPGET, 1);
		curl_setopt($qc, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($qc);
		$response = curl_getinfo($qc);

		if($response['http_code'] == '401') {

		   $url = $this->qcUrl."/authentication-point/authenticate";
		   $credentials = $this->user.":".$this->pass;
		   $headers = array("GET /HTTP/1.1","Authorization: Basic ". base64_encode($credentials));

     	   

		   curl_setopt($qc, CURLOPT_URL, $url);
		   curl_setopt($qc, CURLOPT_HTTPGET,1); //Not sure we need these again as set above?
		   curl_setopt($qc, CURLOPT_HTTPHEADER, $headers);
		   //Set the cookie
		   curl_setopt($qc, CURLOPT_COOKIEJAR, $ckfile);
		   curl_setopt($qc, CURLOPT_RETURNTRANSFER, true);

		   $result = curl_exec($qc);
		   $response = curl_getinfo($qc);

		   if($response['http_code'] == '200') {

				curl_setopt($qc, CURLOPT_COOKIEFILE, $ckfile);
				curl_setopt($qc, CURLOPT_RETURNTRANSFER, true);
				$url = $this->qcUrl."/rest/domains/default/projects/".$project."/defects/?fields=id,name,owner,severity,status,last-modified";
				if ($project == "Early_Repayment") {
					$url .= "&query={status['Open'];user-template-01['Functional%20defect']}";
				} else {
					$url .= "&query={status['Assigned'%20or%20'New']}";
				}
				curl_setopt($qc, CURLOPT_URL, $url);
				$xmlSource = curl_exec($qc);

				curl_setopt($qc, CURLOPT_URL, $this->qcUrl."/authentication-point/logout");
				curl_setopt($qc, CURLOPT_HEADER, 0);
				curl_setopt($qc, CURLOPT_HTTPGET,1);
				curl_setopt($qc, CURLOPT_RETURNTRANSFER, 1);
				$result = curl_exec($qc);
		   } else {
			  //echo "Authentication failed";
		   }
		} else {
		  //print_r($response);
		}

		curl_close($qc);
		return $xmlSource;
	}
}
?>
