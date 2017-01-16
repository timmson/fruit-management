<?
require_once('./lib/almlib.php');
require_once('./lib/tclib.php');

$projects = array(
	0 => array ('name' => 'Early Repayment System', 'qc' => 'Early_Repayment', 'tc' => 'bt13', 'fm' => '13'),
	1 => array ('name' => 'Capstone HPL', 'qc' => 'Capstone_HPL', 'tc' => 'bt11', 'fm' => '6')
);
$VIEW->assign("projects", $projects);

$project = isset($_REQUEST['project'])?$projects[$_REQUEST['project']]:$projects[0];

$VIEW->assign("defects", getDefects($project['qc'], $CORE->configuration['almauth']));
$VIEW->assign("builds", getBuilds($project['tc'], $CORE->configuration['tcauth']));

function getDefects($project, $almConfig) {
	$priority = array(
		"5-Urgent" => "high",
		"4-Very High" => "high",
		"3-High" => "medium",			
		"2-Medium" => "medium",
		"1-Low" => "low",
		"Urgent" => "high",
		"High" => "medium",
		"Medium" => "medium",
		"Low" => "low", 
		"A-Critical" => "high",
		"B-Major" => "medium",
		"C-Minor" => "low"
	);

	$alm = new HpAlm($almConfig['url'], $almConfig['login'], $almConfig['pass']);

	$xmlSource = $alm->retrieve($project);

	$objXml = simplexml_load_string($xmlSource);
	$defectObjs = $objXml->Entity;
	$defects = array();
	for ($i=0; $i<count($defectObjs); $i++)  {
		$fieldObjs = $defectObjs[$i]->Fields->Field;
		$defect = array();
		for ($j=0; $j<count($fieldObjs); $j++)  {
			$temp = (array) $fieldObjs[$j];
			$defect[$temp['@attributes']['Name']] = $temp['Value'];
		}
		$defect['priority'] = $priority[$defect['severity']];
		$defect['lastModified'] = strtotime($defect['last-modified']);
		$defects[] = $defect;
	}
	return $defects;
}

function getBuilds($project, $tcConfig) {
	$teamcity = new TeamCity($tcConfig['url']);
	$xmlSource = $teamcity->retrieve($project);
	$objXml = simplexml_load_string($xmlSource); 
	$builds = (array) $objXml;
	$builds = $builds['build'];
	for ($i=0; $i<count($builds); $i++) {
		$build = (array) $builds[$i];
		$build['startDate'] = strtotime($build['startDate']);
		$build['finishDate'] = strtotime($build['finishDate']);
		$builds[$i] = $build['@attributes'];
	}
	return $builds;

}

?>
