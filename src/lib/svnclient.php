<?
class SvnClient {

	public function getSVNHistory($task) {
		$delimeter = "-------------";
		$filename = "log.txt";
		$svnLog = $this->parseSVN($filename, $delimeter, $task);
		return array_reverse($svnLog);
	}

	private function parseSVN($filename, $delimeter, $task) {
		$commits = array();
		$lines = file($filename);
		$lastDelimeter = -1;
		for ($i=0; $i<count($lines); $i++) {
			if (strpos($lines[$i], $delimeter) !== false) {
				if ($lastDelimeter>=0) {
					$comment = trim($lines[$i - 1]);
					if (strpos($comment, $task) !== false) {
						$commit = array();
						$commit['task'] = $comment;
						$row = explode("|", $lines[$lastDelimeter + 1]);
						$commit['pos'] = $lastDelimeter."-".$i;
						$commit['rev'] = trim($row[0]);
						$commit['user'] = trim($row[1]);
						$tempDateArray = explode(" ", trim($row[2]));
						$tempDate = trim($tempDateArray [0]." ".$tempDateArray[1]); 
						$commit['date'] = $tempDate;// date('Y-n-d H:i:s', strtotime($tempDate));
						$commit['changes'] = array_slice($lines, $lastDelimeter + 3, $i - ($lastDelimeter + 5));
						$commits[] = $commit;				
					}
				}
				$lastDelimeter = $i;

			}
		}
		return $commits;
	}
}

//$svnClient = new SvnClient();
//print_r($svnClient->getSVNHistory("ERS-SVC-560"));
?>
