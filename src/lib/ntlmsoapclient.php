<?
require_once ('./lib/ntlmstream.php');
class NTLMSoapClient extends SoapClient {
    function __doRequest($request, $location, $action, $version) {

        $headers = array(
            'Method: POST',
            'Connection: Keep-Alive',
            'User-Agent: PHP-SOAP-CURL',
            'Content-Type: text/xml; charset=windows-1251',
            'SOAPAction: "'.$action.'"',
        );

        $this->__last_request_headers = $headers;
        $ch = curl_init($location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $this->user.':'.$this->password);
        $response = curl_exec($ch);

        return $response;
    }

    function __getLastRequestHeaders() {
        return implode("\n", $this->__last_request_headers)."\n";
    }
}

// Authentification parameter
class MyServiceNTLMSoapClient extends NTLMSoapClient {

    protected $user = 'svc_jiraautobuild';
    protected $password = '/xmV*%eS;d';
    protected $token = '';
    protected $url = "http://it.rccf.ru/jira/rpc/soap/jirasoapservice-v2?wsdl";


    public function __construct() {
        new NTLMStream(true);
        stream_wrapper_unregister('http');
        stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");
        parent::__construct($this->url);
        self::login();

    }

    private function login() {
        $this->token = self::__call("login",
            array(
            "user"=>"mco_build",
            "password"=>"A1qwert")
        );
             /*
        $this->token = self::__call("login",
            array(
            "user"=>$this->user,
            "password"=>$this->password)
        );
        *
        */
    }

    public function getIssuesFromFilter($filter) {
        return self::__call("getIssuesFromFilter",
        array("token"=>$this->token, "filterId" => $filter));
    }

    public function addVersion($keyproject, $version) {
        $remoteversion =array(
            "name" => $version,
            "sequence" => "1",
            "released" => "",
            "archived" => ""
        );
        self::__call("addVersion",
            array( "token"=>$this->token,
            "projectId" => $keyproject,
            "version"=> $remoteversion)
        );
    }

    public function  getIssueByKey($keyissue) {
        return self::__call("getIssue",
        array("token"=>$this->token, "keyId"=>$keyissue));
    }

    public function  getAvailableActions4Issue($keyissue) {
        return self::__call("getAvailableActions",
        array("token"=>$this->token, "keyId"=>$keyissue));
    }

    public function progressWorkflowActionRequest($keyissue, $status, $params) {
        $ret = self::__call("progressWorkflowAction",
            array("token"=>$this->token, "keyId"=>$keyissue, "status"=>$status, $params));
    }

    public function  updateIssueByKey($keyissue, $params) {
        $ret = self::__call("updateIssue",
            array("token"=>$this->token, "keyId"=>$keyissue, $params));
    }

    public function logout() {
        self::__call("logout", array("token"=>$this->token));
        stream_wrapper_restore('http');
    }


}
?>