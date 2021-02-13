<?php
$HOLIDAY = array();

function getMonthCalendar($plannedDate): array
{
    $cal = array();
    $month = date("m", $plannedDate);
    $year = date("Y", $plannedDate);
    $length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i = 0; $i < $length; $i++) {
        $cal[$i]['day'] = $i + 1;
        $time = strtotime($cal[$i]['day'] . "." . $month . "." . $year);
        $cal[$i]['isweekend'] = isHoliday($time);
    }
    return $cal;
}

function isHoliday($date): bool
{
    return date("w", $date) == 0 || date("w", $date) == 6;
}
