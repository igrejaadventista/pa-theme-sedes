<?php

function my_cron_schedules($schedules)
{
    if (!isset($schedules["20min"])) {
        $schedules["20min"] = array(
            'interval' => 20 * 60,
            'display' => __('Once every 20 minutes')
        );
    }
    return $schedules;
}
add_filter('cron_schedules', 'my_cron_schedules');
