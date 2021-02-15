<?php
$conn = $CORE->getConnection();

if (($_REQUEST['mode'] == 'async') && ($_REQUEST['oper'] == 'gif')) {
    $query = 'select sum(l.fm_spent_hour) as spent_hours, WEEK(l.fm_date) as week from fm_work_log l, fm_task t where t.id = l.fm_task and t.fm_project = ' . $_REQUEST['project'] . '  and l.fm_spent_hour>0  group by WEEK(l.fm_date)';
    $data = $CORE->executeQuery($conn, $query);
    header("Content-type:  image/gif");
    $diagramWidth = 800;
    $diagramHeight = 300;
    $image = imageCreate($diagramWidth, $diagramHeight);
    $colorBackground = imageColorAllocate($image, 192, 192, 192);
    $colorForeground = imageColorAllocate($image, 255, 255, 255);
    $colorBlack = imageColorAllocate($image, 0, 0, 0);
    imageFilledRectangle($image, 0, 0, $diagramWidth - 1, $diagramHeight - 1, $colorBackground);
    imageFilledRectangle($image, 1, 1, $diagramWidth - 2, $diagramHeight - 2, $colorForeground);
    for ($i = 0; $i < count($data); $i++) {
        if ($maxload < $data[$i]['spent_hours']) {
            $maxload = $data[$i]['spent_hours'];
        }
    }
    $multx = ($diagramWidth - 50) / count($data);
    $multy = ($diagramHeight - 30) / $maxload;
    $oldX = 0;
    $oldY = 0;
    for ($i = 0; $i < count($data); $i++) {
        $newx = 25 + $i * $multx;
        $newy = $diagramHeight - $data[$i]['spent_hours'] * $multy;
        if ($i != 0) {
            imageline($image, $oldX, $oldY, $newx, $newy, $colorBackground);
        }
        imagearc($image, $newx, $newy, 10, 10, 0, 360, $colorBackground);
        imagestring($image, 10, $newx + 10, $newy, $data[$i]['spent_hours'] . "h", $colorBlack);
        imagestring($image, 10, $newx + 10, $newy + 15, $data[$i]['week'] . "w", $colorBlack);
        $oldX = $newx;
        $oldY = $newy;
    }
    imageGIF($image);

} else {

    $query = 'select p.*, count(c.id) as current_tasks, (select sum(l.fm_spent_hour) from fm_task t, fm_work_log l 
              where t.id = l.fm_task and t.fm_project = p.id ) as fm_spent_hours from fm_project p 
		      left join v_task_in_progress c on p.id = c.fm_project_id group by p.id';
    $data = $CORE->executeQuery($conn, $query);
    $VIEW->assign("data", $data);

}

$CORE->closeConnection($conn);