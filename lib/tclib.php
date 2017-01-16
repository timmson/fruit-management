<?
class TeamCity {

	private $tcUrl;

    public function __construct($tcUrl) {
		$this->tcUrl = $tcUrl;
	}

	public function retrieve($project) {
		$url = $this->tcUrl."/httpAuth/app/rest/buildTypes/id:".$project."/builds/";
		return $xmlSource = file_get_contents($url);
	}
}
?>
