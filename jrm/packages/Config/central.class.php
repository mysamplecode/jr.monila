<?php

/**
 * @Package  Config\\ Central
 * @author Bugs - Ashtex
 * The central class for the package. Holds all the common utilities 
 */

namespace Config;

use \Exception;
use PHPExcel;
use mysqli;
use Plusql;
use Args;
use Fragmentify;
use Cron;

class Central {

    //constansts
    //pagination support - consts for ids and classes which the template must follow in order for pagination to work

    const ACTIVE_NEXT_ID = "active_page_next";
    const DISABLED_NEXT_ID = "dis_page_next";
    const ACTIVE_PREV_ID = "active_page_prev";
    const DISABLED_PREV_ID = "dis_page_prev";
    const PAGE_LINK_ID = "page";
    const ACTIVE_LINK_CLASS = "active_link";
    const HIDDEN_PAGE_NUM = "page_number";

    //private variables
    private $dbconfig;
    public $profile = 'central';
    private $file_path = '';
    private $server_path = '';
    private static $instance;

    // singleton - private constructor
    private function __construct() {
        try {
            $this->dbconfig = Dbconfig::get_dbconfig();
            $this->set_alias_connection($this->profile);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //timezone set
    public static function setTimezone() {
        date_default_timezone_set(Constants::SET_TIMEZONE);
    }

    //instance method
    public static function instance() {
        if (is_null(Central::$instance)) {
            //Central::setTimezone();
            Central::$instance = new Central();
        }
        return Central::$instance;
    }

    //xml operations
    public static function xmlDataAttributeAsString($xml, $name) {
        if (!is_object($xml[$name]))
            $ret = $xml[$name];
        else
            $ret = '';

        return (string) $ret;
    }

    //convert objects to string
    public static function objectToArray($data) {
        if (!is_array($data) && !is_object($data))
            return $data;
        $result = array();
        $data = (array) $data;
        foreach ($data as $key => $value) {
            if (is_object($value))
                $value = (array) $value;
            if (is_array($value))
                $result[$key] = Central::objectToArray($value);
            else
                $result[$key] = $value;
        }

        return $result;
    }

    //args custom function
    public function getargs($par, $arr, &$corrupt) {
        $param = Args::get($par, $arr);
        $corrupt = false;
        if (($param === null) || ($param == false)) {
            $param = 0;
            $corrupt = true;
        }
        return $param;
    }

    //get the last id from the table
    public function get_last_id($table) {
        try {
            $tid = $table . '_id';
            $id = PluSQL::from($this->profile)->$table->select($tid)->limit('0,1')->orderBy("$tid DESC")->run()->$table->$tid;
            return $id;
        } catch (\EmptySetException $e) {
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    //to remove the last repeating structure from the loop
    public static function remove_last_repeating_element($template, $ending_flag, $parent_count = 1, $previous_count = 0, $next_count = 0) {
        $item = $template->query($ending_flag)->item(0);
        $proto = $item->parentNode;
        for ($i = 1; $i < $parent_count; $i++) {
            $proto = $proto->parentNode;
        }
        for ($i = 1; $i <= $previous_count; $i++) {
            $item = $item->previousSibling;
        }
        for ($i = 1; $i <= $next_count; $i++) {
            $item = $item->nextSibling;
        }
        $proto->removeChild($item);
    }

    //to remove the last repeating structure from the loop - Non Static version
    public function remove_repeating_element($template, $ending_flag, $parent_count = 1, $previous_count = 0, $next_count = 0) {
        $item = $template->query($ending_flag)->item(0);
        $proto = $item->parentNode;
        for ($i = 1; $i < $parent_count; $i++) {
            $proto = $proto->parentNode;
        }
        for ($i = 1; $i <= $previous_count; $i++) {
            $item = $item->previousSibling;
        }
        for ($i = 1; $i <= $next_count; $i++) {
            $item = $item->nextSibling;
        }
        $proto->removeChild($item);
    }

    //logging method for   project
    public static function log_error($code, $data) {
        $link = Central::instance()->db_connect();
        $dbconfig = Central::instance()->get_dbconfig();
        $temp = ($link->select_db($dbconfig[Dbconfig::DB_NAME]));
        $temp = $link->query("insert into errorlog (code, dump) values ( $code , '$data' )");
        if ($temp === TRUE) {
            return true;
        } else {
            throw new Exception(Constants::DBINSERT_ERROR);
        }
    }

    //delete old files from directory
    public static function delete_old_files($dir) {
        if ($d = @opendir($dir)) {
            while (($file = readdir($d)) !== false) {
                if (!is_file($dir . '/' . $file) || $file == 'index.php')
                    continue;
                // then check to see if this one is too old
                $ftime = filemtime($dir . '/' . $file);
                Central::pr('Found file: ' . $dir . '/' . $file);
                // seems 3 min is enough for any report download, isn't it?
                $temp = time() - $ftime;
                Central::pr(" $temp > 180");
                if (time() - $ftime > 180) {
                    Central::pr('deleting file : ' . $dir . '/' . $file);
                    unlink($dir . '/' . $file);
                }
            }
            closedir($d);
        }
    }

    //logging function
    public static function pr($var, $empty = 0) {
        if (is_array($var)) {
            $var = print_r($var, true);
        }
        if (Constants::ON_SCREEN_DEBUG)
            echo $var . "\n";
        $fp = @fopen(PACKAGES_DIR . Constants::LOG_DIR . "jrmolina.log", 'a');
        if ($fp == false) {
            return;
        }
        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        $time = @date('[d/M/Y:H:i:s]');
        fwrite($fp, "$time ($script_name) $var" . PHP_EOL);
        fclose($fp);
    }

    //----
    public function update_dbconfig() {
        $this->dbconfig = Dbconfig::get_dbconfig();
    }

    //----
    private function get_dbconfig() {
        return $this->dbconfig;
    }

    //----
    public function set_alias_connection($alias) {
        try {
            if (($alias === null) || ($alias == false)) {
                throw new Exception(Constants::ALIAS_NOTAVAILABLE);
            }
            $this->dbconfig = Dbconfig::get_dbconfig();
            $details = array
                (
                0 => $this->dbconfig[Dbconfig::DB_HOST],
                1 => $this->dbconfig[Dbconfig::DB_USER],
                2 => $this->dbconfig[Dbconfig::DB_PASSWORD],
                3 => $this->dbconfig[Dbconfig::DB_NAME],
            );
            Plusql::credentials($alias, $details);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //loads any normal template
    public function load_normal($file_name) {
        return $this->load_template($file_name);
    }

    //loads the empty version of the same template
    public function load_empty($file_name) {
        return $this->load_template("empty_" . $file_name);
    }

    //get sever path
    public static function get_instant_server_path() {
        //configure pre-defined path
        $surl = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
        $surl .= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
        $path = pathinfo($_SERVER['PHP_SELF']);
        $surl .= $path['dirname'] . '/';
        $service_base = $surl;
        $file_path = Constants::HTML_PATH;
        if (!is_null($file_name)) {
            if (strpos($file_name, '/') !== null) {
                $temp = explode('/', $file_name);
                $file_name = $temp[count($temp) - 1];
                for ($i = 0; $i < count($temp) - 1; $i++) {
                    $file_path .= '/' . $temp[$i];
                }
            }
        }
        $server_path = $service_base . PACKAGES_DIR . $file_path;
        return $server_path;
    }

    //--load template function
    private function load_template($file_name) {
        try {
            //configure pre-defined path
            $surl = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';
            $surl .= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost';
            $path = pathinfo($_SERVER['PHP_SELF']);
            if (strcmp($path['dirname'], '.') == 0) {
                $path['dirname'] = Constants::DIR_NAME;
            }
            $surl .= $path['dirname'] . '/';
            $service_base = $surl;
            $file_path = Constants::HTML_PATH;
            if (strpos($file_name, '/') !== null) {
                $temp = explode('/', $file_name);
                $file_name = $temp[count($temp) - 1];
                for ($i = 0; $i < count($temp) - 1; $i++) {
                    $file_path .= '/' . $temp[$i];
                }
            }
            $this->file_path = PACKAGES_DIR . $file_path . '/' . $file_name;
            $this->server_path = $service_base . PACKAGES_DIR . $file_path;
            // Load the template and adjust the paths
            $apppaths = new \DOMTemplateAppPaths((Constants::ENABLE_FRAGMENTIFY) ? Fragmentify::render($this->file_path) : $this->file_path, $this->server_path, Constants::ENABLE_FRAGMENTIFY);
            $imgpaths = new \DOMTemplateImgPaths($apppaths->process()->template(), $this->server_path);
            return $imgpaths->process()->template();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get_server_path() {
        return $this->server_path;
    }

    //-- the generic render function
    public function render($template, $output = true) {
        try {
            if ($output) {

                die($template->html());
            }
        } catch (Exception $e) {
            if (!$output) {
                throw $e;
            }
        }
    }

    public function flush($mysql_pass, $verbose = 1) {
        try {
            if ($this->pheanstalk_installed($verbose)) {
                Dbconfig::set_dbpassword($mysql_pass);
                $this->dbconfig = Dbconfig::get_dbconfig();
                if ($this->db_exists()) {
                    //send the table data to the pipe - re start the pipe
                    $pheanstalk = new \Pheanstalk(Constants::SERVER_IP);
                    $tube = $pheanstalk->useTube(Constants::SEND_PIPE);
                    $link = $this->db_connect();
                    $temp = ($link->select_db($this->dbconfig[Dbconfig::DB_NAME]));
                    if ($temp === True) {
                        $this->flush_pipe($link, $tube);
                    } else {
                        throw new Exception(Constants::DBSELECT_ERROR);
                    }
                }
            } else {
                throw new \Exception("unable to flush the messages to the pipe as the beanstalkd pipe is still not operational... \n");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function flush_pipe($link, $tube) {
        try {
            $result = $link->query("select * from pipe_temporary_data");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $data = $row['pipe_data'];
                    $tube->put($data);
                }
            }
            $link->query("delete from pipe_temporary_data");
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function install($mysql_pass, $verbose = 1) {
        try {
            //if($this->pheanstalk_installed($verbose)) {
            Dbconfig::set_dbpassword($mysql_pass);
            $this->dbconfig = Dbconfig::get_dbconfig();
            if ($this->db_exists()) {
                if ($verbose) {
                    $msg = Constants::DB_RE_INSTALL_MSG;
                    fwrite(STDOUT, "$msg: ");
                    $res = trim(fgets(STDIN));
                    if ($res == Constants::DB_RE_INSTALL_GOAHEAD) {
                        //confirm from user that the database will be removed
                        $this->db_cleanup();
                        $this->db_install();
                    }
                } else {
                    $this->db_cleanup();
                    $this->db_install();
                }
            } else {
                $this->db_install();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function db_connect() {
        $link = null;
        try {
            $link = new mysqli(
                    $this->dbconfig[Dbconfig::DB_HOST], $this->dbconfig[Dbconfig::DB_USER], $this->dbconfig[Dbconfig::DB_PASSWORD]
            );
            if ($link->connect_error) {
                throw new Exception(Constants::DBCONNECTION_NOTAVAILABLE);
            }
            return $link;
        } catch (Exception $e) {
            if ($link instanceof mysqli) {
                $link->close();
            }
            throw $e;
        }
    }

    public function db_exists() {
        $link = null;
        try {
            $link = $this->db_connect();
            $temp = ($link->select_db($this->dbconfig[Dbconfig::DB_NAME]));
            $link->close();
            return $temp;
        } catch (Exception $e) {
            if ($link instanceof mysqli) {
                $link->close();
            }
            throw $e;
        }
    }

    public function db_cleanup() {
        $link = null;
        try {
            $link = $this->db_connect();
            $temp = $link->query('drop database ' . $this->dbconfig[Dbconfig::DB_NAME]);
            if ($temp === TRUE) {
                return true;
            } else {
                throw new Exception(Constants::DBDELETE_ERROR);
            }
        } catch (Exception $e) {
            if ($link instanceof mysqli) {
                $link->close();
            }
            throw $e;
        }
    }

    public function db_install() {
        $link = null;
        try {
            $link = $this->db_connect();
            $temp = $link->query('create database ' . $this->dbconfig[Dbconfig::DB_NAME]);
            if ($temp === TRUE) {
                $temp = ($link->select_db($this->dbconfig[Dbconfig::DB_NAME]));
                if ($temp === True) {
                    $this->upload_dump($link);
                } else {
                    throw new Exception(Constants::DBSELECT_ERROR);
                }
            } else {
                throw new Exception(Constants::DBCREATE_ERROR);
            }
        } catch (Exception $e) {
            if ($link instanceof mysqli) {
                $link->close();
            }
            throw $e;
        }
    }

    private function upload_dump($link) {
        try {
            $templine = '';
            $path = PACKAGES_DIR . '/' . Constants::PACKAGE_NAME . '/' . $this->dbconfig[Dbconfig::DB_DUMP];
            $lines = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
            if (!$lines) {
                throw new Exception(Constants::DUMP_FILEOPEN_ERROR);
            }
            foreach ($lines as $line) {
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                $templine .= $line;
                if (substr(trim($line), -1, 1) == ';') {
                    $temp = $link->query($templine);
                    if (!$temp) {
                        throw new Exception(Constants::DUMP_CORRUPTED);
                    }
                    $templine = '';
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function array_copy($arr) {
        $newArray = array();
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $newArray[$key] = array_copy($value);
            } else if (is_object($value)) {
                $newArray[$key] = clone $value;
            } else {
                $newArray[$key] = $value;
            }
        }
        return $newArray;
    }

    //add csrf token
    public function add_csrf_token($profile = Constants::CSRF_ATTACK) {
        $token = md5(uniqid());
        $_SESSION[profile] = $token;
        return $_SESSION[profile];
    }

    //validate csrf token
    public function validate_csrf_token($token, $profile = Constants::CSRF_ATTACK) {
        if ($token == $_SESSION[profile]) {
            return true;
        }
        return false;
    }

    ///Curl Call With Header///
    public static function curl_call_with_header($url) {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST => "GET", //set request type post or get
            CURLOPT_POST => false, //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => true, // don't return headers
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 200, // timeout on connect
            CURLOPT_TIMEOUT => 200, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

///Curl Call With header Close//
///Curl Call Without Header///
    public static function curl_call_without_header($url) {
        $user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
        $options = array(
            CURLOPT_CUSTOMREQUEST => "GET", //set request type post or get
            CURLOPT_POST => false, //set to GET
            CURLOPT_USERAGENT => $user_agent, //set user agent
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 200, // timeout on connect
            CURLOPT_TIMEOUT => 200, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

///Curl Call without header Close//
    ///Excel Call///
    public static function excel_data($sql_tweet, $sql_wind, $arr_tweet, $arr_wind, $filename) {
        //$sql = query
        //$arr = array
        //$filename = download filename
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("")
                ->setLastModifiedBy("")
                ->setTitle("Log file")
                ->setSubject("Log file")
                ->setDescription("Log file")
                ->setKeywords("office 2007")
                ->setCategory("Log file");

        $objPHPExcel->setActiveSheetIndex(0);

        ////////////////////////////////////////////////////
        // adding columns title in excel sheet

        $excel_count = 'A';
        foreach ($arr_wind as $k => $title) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_count++ . "1", $title);
        }
        foreach ($arr_tweet as $k => $title) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_count++ . "1", $title);
        }



        $excel_count = 'A';
        // adding date time values
        $count_hour = 2;

        //$mytime = new \DateTime('2013-12-03 09:26:54');

        $count_sql = count($sql_wind);
        $c = 0;
        foreach ($sql_wind as $s_w) {
            $mytime = new \DateTime($s_w->date_time);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_count . $count_hour, $s_w->date_time);
            $count_hour++;
            if ($c != $count_sql) {

                $interval = new \DateInterval('PT1H0S');
                $mytime->add($interval);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_count . $count_hour, $mytime->format('Y-m-d H:i:s'));
                $count_hour++;
                $mytime->add($interval);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($excel_count . $count_hour, $mytime->format('Y-m-d H:i:s'));
                $count_hour++;
            }
            $c++;
        }

        $excel_count++;

        Central::update_col_with($objPHPExcel, $sql_wind, 'localtimes', $excel_count);
        $excel_count++;
        Central::update_col_with($objPHPExcel, $sql_wind, 'windspeed', $excel_count);
        $excel_count++;
        Central::update_col_with($objPHPExcel, $sql_wind, 'windgust', $excel_count);
        $excel_count++;
        Central::update_col_with($objPHPExcel, $sql_wind, 'precipitation', $excel_count);

        $excel_count++;
        if (count($sql_wind) == 0) {
            $excel_count = 'A';
        }

        $pm = ($excel_count);
        $aqi = ++$excel_count;
        $count = 2;
        foreach ($sql_tweet as $twt) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($pm . $count, $twt->pm_val);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($aqi . $count, $twt->aqi_val);
            $count++;
        }


        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        return;
    }

    public static function update_col_with($excel_object, $sql_query, $col_name, $excel_col) {

        $check_again = true;
        $count_col = 2;
        $old_hours = 0;

        foreach ($sql_query as $s_w) {
            if ($check_again) {
                $check_again = false;
                //$old_hours=$s_w->windspeed;
                $old_hours = $s_w->$col_name;
                $excel_object->setActiveSheetIndex(0)->setCellValue($excel_col . $count_col, $old_hours);
                continue;
            }
            //$new_hours=$s_w->windspeed;
            $new_hours = $s_w->$col_name;
            $temp_calc = ($old_hours - $new_hours) / 3.0;
            $first_col = $old_hours - $temp_calc;
            $second_col = $first_col - $temp_calc;
            $old_hours = $new_hours;

            $count_col++;
            $excel_object->setActiveSheetIndex(0)->setCellValue($excel_col . $count_col, $first_col);
            $count_col++;
            $excel_object->setActiveSheetIndex(0)->setCellValue($excel_col . $count_col, $second_col);
            $count_col++;
            $excel_object->setActiveSheetIndex(0)->setCellValue($excel_col . $count_col, $old_hours);
        }
    }

    ///Excel Call Close///
    public function cron_update() {
        try {
            $path = dirname(__FILE__);
            $cron_array = \Cron::$cron_array;
            $crontab = new \CronManager\CrontabManager();

            foreach ($cron_array as $cron) {
                $job = $crontab->newJob();
                switch ($cron[4]) {
                    case 'minute':
                        $job->on("*/{$cron[3]} * * * * root");
                        break;
                    case 'hour':
                        $job->on("0 */{$cron[3]} * * * root");
                        break;
                    case 'daily':
                        $job->on("0 {$cron[3]} * * * root");
                        break;
                    case 'week':
                        $job->on("0 0 * * {$cron[3]} root");
                        break;
                    case 'month':
                        $job->on("0 0 1 {$cron[3]} * root");
                        break;
                    default:
                        $job->on("*/{$cron[3]} * * * * root");
                }
                $args = "";
                $indexes = array('mysql_root' => 2, 'namespace' => 5, 'class' => 0, 'function' => 1);
                foreach ($indexes as $k => $i) {
                    if (strlen($cron[$i]) > 0) {
                        $args .= "$k={$cron[$i]} ";
                    }
                }
                $logger = '';
                if (strlen($cron[6])) {
                    $logfile = PACKAGES_DIR . Constants::LOG_DIR . $cron[6];
                    $logger .= "> $logfile 2>&1";
                }
                $job->doJob("cd $path; cd ..; cd ..; php index.php Cron $args $logger");
                $crontab->add($job);
            }
            $crontab->save(false);
            Central::pr("Just updated the crontab file");
        } catch (\Exception $e) {
            throw $e;
        }
    }

/////////////    
    //pagination support offered by central
    public function update_pagination($total_pages, $template, $page_number = 1) { //atleast we will have one page
        try {
            //we have the total number of pages - first adjust the pagaintion html
            //take care of crazy user
            if ($page_number < 1) {
                $page_number = 1;
            }
            if ($page_number > $total_pages) {
                $page_number = $total_pages;
            }
            $curr_page = $page_number;
            //adjust the previous button
            if ($page_number == 1) { //disable the previous button
                $template->remove("#" . self::ACTIVE_PREV_ID);
            } else { //enable the previous button
                $template->remove("#" . self::DISABLED_PREV_ID);
            }
            //adjust the next button
            if ($page_number == $total_pages) {
                //disable the next button
                $template->remove("#" . self::ACTIVE_NEXT_ID);
            } else { //enable the next button
                $template->remove("#" . self::DISABLED_NEXT_ID);
            }
            //adjust the page links
            $proto = $template->query("#" . self::PAGE_LINK_ID)->item(0);
            $parent = $proto->parentNode;
            $item = $proto->cloneNode(true);
            for ($i = 1; $i <= $total_pages; $i++) {
                $item->textContent = $i;
                $item->nodeValue = $i;
                if ($i != $page_number) {
                    $item->attributes->getNamedItem('class')->nodeValue = "";
                } else {
                    $item->attributes->getNamedItem('class')->nodeValue = self::ACTIVE_LINK_CLASS;
                }
                $parent->insertBefore($item, $proto);
                $item = $item->cloneNode(true);
            }
            $parent->removeChild($proto);
            $template->setValue("#" . self::HIDDEN_PAGE_NUM . "@value", $page_number);
            return $curr_page;
        } catch (Exception $e) {
            throw $e;
        }
    }
    public static function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

    public static function raasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        arsort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }

    public static function repeat_select_options($template, $select_id, $options, $sel_val = '') {
        $temp = $template->query($select_id)->item(0);
        $org = $temp->childNodes->item(1);
        $par = $temp->parentNode;
        $proto = $org->cloneNode(true);
        foreach ($options as $value => $text) {
            $opt = $proto->cloneNode(true);
            $opt->nodeValue = $text;
            $opt->attributes->getNamedItem('value')->nodeValue = $value;
            if (!empty($sel_val)) {
                if (strcmp(trim($sel_val), trim($value)) == 0) {
                    $opt->setAttribute('selected', 'selected');
                }
            }
            $temp->appendChild($opt);
        }
        $ff = $temp->childNodes->item(1);
        $temp->removeChild($ff);
    }

}
