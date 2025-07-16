<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Europe/Rome');

function seconds_to_human($ss) {
    $s = $ss%60;
    $m = floor(($ss%3600)/60);
    $h = floor(($ss%86400)/3600);
    $d = floor(($ss%2592000)/86400);
    $M = floor($ss/2592000);

    return array($d,$h,$m);
}

function get_time_left($end, $duration, $compact=false)
{
    if($duration == 'inf'){
        $time_left = 'inf';
    }
    else {
        $diff = strtotime($end) - strtotime(date('Y-m-d H:i:s', time()));

        if($diff > 0){
            list($days_left, $hours_left, $minutes_left) = seconds_to_human($diff);

            if ($compact) {
                $time_left = $minutes_left;
            } else {
                $time_left = $hours_left > 0 ? $hours_left . "h " . $minutes_left . "m" : $minutes_left . "m";
            }
        }
        else {
            $time_left = 0;
        }
    }

    return $time_left;
}

function get_all_days(){
    return [
        'lun',
        'mar',
        'mer',
        'gio',
        'ven',
        'sab',
        'dom'
    ];
}