<?
class RelDAO {

	private $core;

	private $conn;

	public function __construct(Core $core, $conn) {
		$this->core = $core;
		$this->conn = $conn;
	}

	public function move($taskid, $fromid, $toid) {
		$query = "update fm_relation set fm_parent=".$toid." where fm_parent=".$fromid." and fm_child=".$taskid;
		$this->core->executeQuery($this->conn, $query);	
		return $taskid;
	}

}
?>
