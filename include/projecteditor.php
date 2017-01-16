<?
$conn = $CORE->getConnection($currentdep['props']);
if (($_REQUEST['mode']=='async')&&($_REQUEST['oper']=='gif')) {
	$query = 'select sum(l.tm_spent_hour) as spent_hours, WEEK(l.tm_date) as week
		 from tm_work_log l, tm_task t where t.id = l.tm_task and t.tm_project = '.$_REQUEST['project'].'  and l.tm_spent_hour>0  group by WEEK(l.tm_date)';
	$data = $CORE->executeQuery($conn, $query);
	header("Content-type:  image/gif");
	$diagramWidth = 800;
	$diagramHeight = 300;
	$image = imageCreate($diagramWidth, $diagramHeight);
	$colorBackgr = imageColorAllocate($image, 192, 192, 192);
	$colorForgr = imageColorAllocate($image, 255, 255, 255);
	$colorBlack = imageColorAllocate($image, 0, 0, 0);
	imageFilledRectangle($image, 0, 0, $diagramWidth - 1, $diagramHeight - 1, $colorBackgr);
	imageFilledRectangle($image, 1, 1, $diagramWidth - 2, $diagramHeight - 2, $colorForgr);
	for ($i=0; $i<count($data); $i++) {
		if ($maxload<$data[$i]['spent_hours'])
		$maxload = $data[$i]['spent_hours'];
	} 
	$multx = ($diagramWidth-50)/count($data);
	$multy = ($diagramHeight-30)/$maxload;
	for ($i=0; $i<count($data); $i++) {
		$newx = 25+$i*$multx;
		$newy = $diagramHeight-$data[$i]['spent_hours']*$multy;
		if ($i!=0) {
			imageline($image, $oldx, $oldy, $newx, $newy, $colorBackgr);
		}
		imagearc($image, $newx, $newy, 10, 10,  0, 360, $colorBackgr);
		imagestring($image, 10, $newx+10, $newy, $data[$i]['spent_hours']."h", $colorBlack);
		imagestring($image, 10, $newx+10, $newy+15, $data[$i]['week']."w", $colorBlack);
		$oldx = $newx;
		$oldy = $newy;
	}
	imageGIF($image);
	$CORE->closeConnection($conn);
}


$query = 'select p.*, count(c.id) as current_tasks, (select sum(l.tm_spent_hour) from tm_task t, tm_work_log l  
where t.id = l.tm_task and t.tm_project = p.id ) as tm_spent_hours from tm_project p 
		left join v_task_in_progress c on p.id = c.tm_project_id group by p.id';
$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("data", $data);


$CORE->closeConnection($conn)

?>
