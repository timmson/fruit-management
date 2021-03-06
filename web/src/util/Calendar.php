<?php


namespace ru\timmson\FruitManagement\util;


class Calendar
{

    public static function getTaskEnd($start, $length): int
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
        while (Calendar::isHoliday($end)) {
            $end += $dayInSeconds;
        }
        return $end;
    }

    public static function getMonthCalendar($plannedDate): array
    {
        $cal = array();
        $month = date("m", $plannedDate);
        $year = date("Y", $plannedDate);
        $length = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 0; $i < $length; $i++) {
            $cal[$i]['day'] = $i + 1;
            $time = strtotime($cal[$i]['day'] . "." . $month . "." . $year);
            $cal[$i]['isweekend'] = Calendar::isHoliday($time);
        }
        return $cal;
    }

    public static function isHoliday($date): bool
    {
        return date("w", $date) == 0 || date("w", $date) == 6;
    }

}