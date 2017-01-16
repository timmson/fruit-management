<?
class TaskDAO {

	private $core;

	private $conn;

	public function __construct(Core $core, $conn) {
		$this->core = $core;
		$this->conn = $conn;
	}

	public function create(array $task) {
		$query = "insert into tm_task(id, tm_name, tm_descr, tm_project, tm_state, tm_priority, tm_plan, tm_user) "; 
		$query .= "values (null,";
		$query .= "'".$task['tm_name']."',";
		$query .= "'".$task['tm_descr']."',";
		$query .= $task['tm_project'].",";
		$query .= $task['tm_state'].",";
		$query .= $task['tm_priority'].",";
		$query .= $task['tm_plan'].",";
		$query .= "'".$task['tm_user']."')";
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
		$query = "update tm_task set tm_state = (select id from tm_state where tm_name = '".$stateName."') where id = ".$taskid;
		//echo $query;
		$this->core->executeQuery($this->conn, $query);
	}


}
?>
