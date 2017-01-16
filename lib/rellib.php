<?
class RelDAO {

	private $core;

	private $conn;

	public function __construct(Core $core, $conn) {
		$this->core = $core;
		$this->conn = $conn;
	}

	public function move($taskid, $fromid, $toid) {
		$query = "update tm_relation set tm_parent=".$toid." where tm_parent=".$fromid." and tm_child=".$taskid;
		$this->core->executeQuery($this->conn, $query);	
		return $taskid;
	}

}
?>
