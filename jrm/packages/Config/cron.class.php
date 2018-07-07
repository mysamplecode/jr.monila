<?php

use Config\Central;

class Cron implements \RocketSled\Runnable {
    /*
     * exposes cron array for default settings
     * supports minutes,hours,week,month intervals
     * the keywords are "minute","hour","week","month"
     * week interval possible values are 0=Sun, 1=Mon, 2=Tue, 3=Wed, 4=Thu, 5=Fri, 6=Sat
     * month interval possible valure are 1 to 12 representing months from Jan to Dec
     * The interval value should match the defined type
     * In case of mismatched values and types, the results will be in-consistent
     * The audience for this script are assumed to be well aware of system and know how to handle it
     * CAUTION: THIS SCRIPT OFFERS MINIMAL ERROR HANDLING
     * example:
     * (interval = 2, type = minute) ===> Cron job will run after every 2 minutes
     * (interval = 5, type = hour) ===> Cron job will run after every 5 hours
     * (interval = Mon, type = week) ===> Cron job will run on every Monday
     * (interval = 2, type = week) ===> Cron job will run on every Tuesday
     * (interval = 10, type = month) ===> Cron job will run in the month of October for every year
     * (interval = Jan, type = month) ===> Cron job will run in the month of January for every year
     * Note: Please do not forget to include the required in the use class at the top of this file 
     */

    //-------------------------------------------------------------------------------
    public static $cron_array = array
        (
        //------class[0]---------------function[1]---------mysql_root[2]------interval[3]----type[4]-----------namespace[5]-------------------------logfile[6]-------
        array('TweetLog', 'run', 'bugs123', '1', 'hour', '', 'tweeter.log'),
        array('WindLog', 'run', 'bugs123', '3', 'hour', '', 'wind.log'),
            //array('Dlr',                'sixty_day_rule',       '12345', 		 0,          'daily',        'MagnumGatewayConnector/oxygen8',   'sixty_day_noti.log'),
            //array( 'Dlr', 'thirty_day_notification', 'bugs', 3, 'minute', 'MagnumGatewayConnector/oxygen8', 'thirty_day_noti.log' ),
            //array( 'Dlr', 'sixty_day_rule',          'bugs', 2, 'minute', 'MagnumGatewayConnector/oxygen8', 'sixty_day_noti.log' ),
    );

    //-------------------------------------------------------------------------------
    //----------------------NO CODE SHOULD BE CHANGED BELOW THIS LINE-----------------
    public function run() {
        Central::pr("Cron Job Starting");
        $corrupt_args = false;
        $central = Central::instance();
        $class = $central->getargs('class', Args::argv, $corrupt_args);
        Central::pr("Found the class = $class");
        $function = $central->getargs('function', Args::argv, $corrupt_args);
        Central::pr("Found the function = $function");
        if (!$corrupt_args) {
            $namespace = $central->getargs('namespace', Args::argv, $corrupt_args);
            Central::pr("Found the namespace = $namespace");
            if ($corrupt_args) {
                $namespace = "";
            } else {
                $namespace = str_replace("/", "\\", $namespace);
                $namespace .= "\\";
            }
            Central::pr("namespace after the changes = $namespace");
            $class = $namespace . $class;
            Central::pr("The final class is = $class");
            $r = new ReflectionClass($class);
            $mystrey_obj = $r->newInstanceArgs();
            $mystrey_obj->$function(date('Y-m-d H:i:s', time()));
            echo("CRON job successful for $class -> $function()");
            Central::pr("CRON job successful for $class -> $function()");
        } else {
            throw new Exception("Confusing Parameters. CRON job not successful");
        }
    }

}

?>
