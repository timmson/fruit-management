<?php
$HOLIDAY = array();

function getTaskEnd($start, $length)
{
    $hourInSeconds = 60 * 60;
    $dayInSeconds = 24 * $hourInSeconds;
    $nightInSeconds = 15 * $hourInSeconds;
    $weeks = floor($length / 40);
    $days = floor(($length % 40) / 8);
    $hours = $length % 8;
    $end = $start + $weeks * 7 * $dayInSeconds + $days * $dayInSeconds + $hours * $hourInSeconds;
    $hourInNextDay = date("H", $end);
    if (($hourInNextDay >= 18) || ($hourInNextDay < 9)) {
        $end += $nightInSeconds;
    }
    $end += (date("W", $end) - date("W", $start)) * 2 * $dayInSeconds;
    while (isHoliday($end)) {
        $end += $dayInSeconds;
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

function isHoliday($date): bool
{
    return date("w", $date) == 0 || date("w", $date) == 6;
}
