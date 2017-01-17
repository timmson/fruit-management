<?
class TaskDAO {

	private $core;

	private $conn;

	public function __construct(Core $core, $conn) {
		$this->core = $core;
		$this->conn = $conn;
	}

	public function create(array $task) {
		$query = "insert into fm_task(id, fm_name, fm_descr, fm_project, fm_state, fm_priority, fm_plan, fm_user) ";
		$query .= "values (null,";
		$query .= "'".$task['fm_name']."',";
		$query .= "'".$task['fm_descr']."',";
		$query .= $task['fm_project'].",";
		$query .= $task['fm_state'].",";
		$query .= $task['fm_priority'].",";
		$query .= $task['fm_plan'].",";
		$query .= "'".$task['fm_user']."')";
		$this->core->executeQuery($this->conn, $query);	
		$task['id'] = mysql_insert_id($this->conn);
		return $task;
	}

	public function merge(array $task) {
		if ($task['id'] == null) {
			return $this->create($task);
		}
	}

	public function moveTo($taskid, $stateName) {
		$query = "update fm_task set fm_state = (select id from fm_state where fm_name = '".$stateName."') where id = ".$taskid;
		//echo $query;
		$this->core->executeQuery($this->conn, $query);
	}


}
?>
