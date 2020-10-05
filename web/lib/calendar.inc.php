<?php
$HOLIDAY = array();

function getTaskEnd($start, $length)
{
    $hourinsec = 60 * 60;
    $dayinsec = 24 * $hourinsec;
    $nightinsec = 15 * $hourinsec;
    $lastw = floor($length / 40);
    $lastd = floor(($length % 40) / 8);
    $lasth = $length % 8;
    $end = $start + $lastw * 7 * $dayinsec + $lastd * $dayinsec + $lasth * $hourinsec;
    $nextdayh = date("H", $end);
    if (($nextdayh >= 18) || ($nextdayh < 9)) {
        $end += $nightinsec;
    }
    $end += (date("W", $end) - date("W", $start)) * 2 * $dayinsec;
    while (isHoliday($end)) {
        $end += $dayinsec;
    }
    return $end;
}

function getMonthCalendar($plandate)
{
    $cal = array();
    $month = date("m", $plandate);
    $year = date("Y", $plandate);
    $length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i = 0; $i < $length; $i++) {
        $cal[$i]['day'] = $i + 1;
        $time = strtotime($cal[$i]['day'] . "." . $month . "." . $year);
        $cal[$i]['isweekend'] = isHoliday($time);
    }
    return $cal;
}

function isHoliday($date)
{
    return date("w", $date) == 0 || date("w", $date) == 6;
}

?>
