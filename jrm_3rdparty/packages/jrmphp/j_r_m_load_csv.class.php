<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of j_r_m_load_csv
 *
 * @author waqas
 */
use Config\Central;
use Config\Constants;

class JRMLoadCsv implements \RocketSled\Runnable {

    //--private members
    protected $template;
    protected $profile = 'default';
    protected $central;
    protected $esc;

    public function __construct() {
        try {
            @session_start();
            // Load DB credentials and supported classes
            $this->central = Central::instance();
            $this->central->set_alias_connection($this->profile);
        } catch (Exception $e) {
            throw $e;
        }
    }

    //escape function
    public function __call($closure, $args) {
        $f = Plusql::escape($this->profile);
        return $f($args[0]);
    }

    public function staus_check($val) {
        switch ($val) {
            case 'act':
                $val = 'Active';
                break;
            case 'pnd':
                $val = 'Pending';
                break;
            case 'con':
                $val = 'Active Contingent';
                break;
            case 'opt':
                $val = 'Active Option Contract';
                break;
            case 'ko':
                $val = 'Active Kick Out';
                break;
        }
        return $val;
    }

    //put your code here
//    public function load_csv_file($tablename, $primaryid, $csvfile, $csvfile2) {
//        try {
//            $create_table = "";
//            $files = file(PACKAGES_DIR . '/' . Constants::DATA_PATH . '/' . $csvfile);
//            $files2 = file(PACKAGES_DIR . '/' . Constants::DATA_PATH . '/' . $csvfile2);
//            if (!is_null($files) && !is_null($files2)) {
//                $headers = str_replace("#", "", $files[0]);
//                $headers1 = str_replace("/", "_", $headers);
//                $headers2 = str_replace(" ", "_", $headers1);
//                $headers3 = str_replace('"', "", $headers2);
//                $headers4 = str_replace("'", "", $headers3);
//                $headers5 = str_replace(":", "", $headers4);
//                $headers6 = str_replace("?", "", $headers5);
//                $headers7 = str_replace("$", "", $headers6);
//                $headers8 = str_replace("@", "", $headers7);
//                $headers9 = str_replace("%", "", $headers8);
//                $headers10 = str_replace("&", "", $headers9);
//                $headers11 = str_replace("*", "", $headers10);
//                $headers12 = str_replace("-", "", $headers11);
//                $headers13 = str_replace("+", "", $headers12);
//                $headers14 = str_replace("=", "", $headers13);
//                $allheaders = strtolower($headers14);
//                //drop table
//                $drop_table = "DROP TABLE IF EXISTS `{$tablename}`;";
//                $drop = PluSQL::against($this->profile)->run($drop_table);
//                if ($drop) {
//                    echo "Table Deleted." . PHP_EOL;
//                }
//                //create new table
//                $arry = array();
//                $create_table .= "CREATE TABLE IF NOT EXISTS `{$tablename}`" . PHP_EOL;
//                $create_table .= "({$primaryid} INT NOT NULL AUTO_INCREMENT," . PHP_EOL;
//                $create_table .= " PRIMARY KEY({$primaryid})," . PHP_EOL;
//                $tmps = explode(",", $allheaders);
//                $unique_headers = array_unique($tmps);
//                $duplicates = array_diff_assoc($tmps, $unique_headers);
//                foreach ($duplicates as $k => $d) {
//                    $unique_headers[$k] = $d . '_1';
//                }
//                for ($i = 0; $i < count($unique_headers); $i++) {
//                    $arry[] = $unique_headers[$i];
//                    $create_table.="{$unique_headers[$i]} TEXT,";
//                }
//                if (substr($create_table, -1) == ",") {
//                    $create_table = substr($create_table, 0, -1);
//                    $create_table .= ");";
//                }
//                $create = PluSQL::against($this->profile)->run($create_table);
//                if ($create) {
//                    echo "Table Created." . PHP_EOL;
//                }
//                $marry = array();
//                $mheaders = str_replace("#", "", $files3[0]);
//                $mheaders1 = str_replace("/", "_", $mheaders);
//                $mheaders2 = str_replace(" ", "_", $mheaders1);
//                $mheaders3 = str_replace('"', "", $mheaders2);
//                $mheaders4 = str_replace("'", "", $mheaders3);
//                $mheaders5 = str_replace(":", "", $mheaders4);
//                $mheaders6 = str_replace("?", "", $mheaders5);
//                $mheaders7 = str_replace("$", "", $mheaders6);
//                $mheaders8 = str_replace("@", "", $mheaders7);
//                $mheaders9 = str_replace("%", "", $mheaders8);
//                $mheaders10 = str_replace("&", "", $mheaders9);
//                $mheaders11 = str_replace("*", "", $mheaders10);
//                $mheaders12 = str_replace("-", "", $mheaders11);
//                $mheaders13 = str_replace("+", "", $mheaders12);
//                $mheaders14 = str_replace("=", "", $mheaders13);
//                $mallheaders = strtolower($mheaders14);
//                $create_media_table .= "CREATE TABLE IF NOT EXISTS `media`" . PHP_EOL;
//                $create_media_table .= "(media_id INT NOT NULL AUTO_INCREMENT," . PHP_EOL;
//                $create_media_table .= " PRIMARY KEY(media_id)," . PHP_EOL;
//                $mtmps = explode(",", $mallheaders);
//                $munique_headers = array_unique($mtmps);
//                $mduplicates = array_diff_assoc($mtmps, $munique_headers);
//                foreach ($mduplicates as $k => $d) {
//                    $munique_headers[$k] = $d . '_1';
//                }
//                for ($i = 0; $i < count($munique_headers); $i++) {
//                    $marry[] = $munique_headers[$i];
//                    $create_media_table.="{$munique_headers[$i]} TEXT,";
//                }
//                if (substr($create_media_table, -1) == ",") {
//                    $create_media_table = substr($create_media_table, 0, -1);
//                    $create_media_table .= ");";
//                }
//                $create_m = PluSQL::against($this->profile)->run($create_media_table);
//                if ($create_m) {
//                    echo "Media Table Created." . PHP_EOL;
//                }
//                unset($files[0]);
//                unset($files2[0]);
//                unset($files3[0]);
//                $count1 = count($files);
//                $count2 = count($files2);
//                $count3 = count($files3);
//                $count = ($count1 + $count2 + $count3);
//                echo "CSV Loading Started.." . PHP_EOL;
//                echo "Total Entries (FILE 1 + FILE 2 + FILE 3 = TOTAL): {$count1} + {$count2} + {$count3} = " . $count . PHP_EOL;
//                echo "CSV Loading complete = 0.00%";
//                $smp = strlen("0.00%");
//                $counter = 0;
//                $all = implode(",", $arry);
//                //insert statement
//                $sql = "INSERT INTO `{$tablename}`({$all}) VALUES ";
//                //first csv file
//                foreach ($files as $file) {
//                    $tmp = str_getcsv($file);
//                    $sql .= "(";
//                    foreach ($tmp as $t) {
//                        $sql .= "'" . $this->esc(trim($t)) . "', ";
//                    }
//                    if (substr($sql, -2, 1) == ",") {
//                        $sql = substr($sql, 0, -2) . "), ";
//                    }
//                    $counter++;
//                    echo chr(27) . "[" . $smp . "D";
//                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
//                    $smp = strlen($tmp);
//                    echo $tmp;
//                }
//                //second csv file
//                foreach ($files2 as $file2) {
//                    $tmp2 = str_getcsv($file2);
//                    $sql .= "(";
//                    foreach ($tmp2 as $t2) {
//                        $sql .= "'" . $this->esc(trim($t2)) . "', ";
//                    }
//                    if (substr($sql, -2, 1) == ",") {
//                        $sql = substr($sql, 0, -2) . "), ";
//                    }
//                    $counter++;
//                    echo chr(27) . "[" . $smp . "D";
//                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
//                    $smp = strlen($tmp);
//                    echo $tmp;
//                }
//                if (substr($sql, -2, 1) == ",") {
//                    $sql = substr($sql, 0, -2);
//                    $sql .=";";
//                }
//                //third csv file
//                $mall = implode(",", $marry);
//                $sql .= "INSERT INTO `media`({$mall}) VALUES (";
//                foreach ($files3 as $file3) {
//                    $tmp3 = str_getcsv($file3);
//                    $sql .= "(";
//                    foreach ($tmp3 as $t3) {
//                        $sql .= "'" . $this->esc(trim($t3)) . "', ";
//                    }
//                    if (substr($sql, -2, 1) == ",") {
//                        $sql = substr($sql, 0, -2) . ") ";
//                    }
//                    $counter++;
//                    echo chr(27) . "[" . $smp . "D";
//                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
//                    $smp = strlen($tmp);
//                    echo $tmp;
//                }
//                if (substr($sql, -2, 1) == ",") {
//                    $sql = substr($sql, 0, -2);
//                }
//                //  echo $sql;
//                $data_insert = PluSQL::against($this->profile)->run($sql);
//                if ($data_insert) {
//                    echo PHP_EOL . "Data Insterted in Database.";
//                }
//                unset($files);
//                unset($files2);
//                unset($files3);
//                unset($sql);
//                gc_collect_cycles();
//            }
//            echo " " . PHP_EOL;
//        } catch (Exception $e) {
//            throw $e;
//        }
//    }

    public function load_csv_file_non_optimized($tablename, $primaryid, $csvfile, $csvfile2, $csvfile3, $dropflag = 0, $createflag = 0) {
        try {
            $create_table = "";
            $files = file(PACKAGES_DIR . '/' . Constants::DATA_PATH . '/' . $csvfile);
            $files2 = file(PACKAGES_DIR . '/' . Constants::DATA_PATH . '/' . $csvfile2);
            $files3 = file(PACKAGES_DIR . '/' . Constants::DATA_PATH . '/' . $csvfile3);
            if (!is_null($files) && !is_null($files2)) {
                $headers = str_replace("#", "", $files[0]);
                $headers1 = str_replace("/", "_", $headers);
                $headers2 = str_replace(" ", "_", $headers1);
                $headers3 = str_replace('"', "", $headers2);
                $headers4 = str_replace("'", "", $headers3);
                $headers5 = str_replace(":", "", $headers4);
                $headers6 = str_replace("?", "", $headers5);
                $headers7 = str_replace("$", "", $headers6);
                $headers8 = str_replace("@", "", $headers7);
                $headers9 = str_replace("%", "", $headers8);
                $headers10 = str_replace("&", "", $headers9);
                $headers11 = str_replace("*", "", $headers10);
                $headers12 = str_replace("-", "", $headers11);
                $headers13 = str_replace("+", "", $headers12);
                $headers14 = str_replace("=", "", $headers13);
                $allheaders = strtolower($headers14);
                //drop table
                if ($dropflag == 1) {
                    $drop_table = "DROP TABLE IF EXISTS `{$tablename}`;";
                    $drop = PluSQL::against($this->profile)->run($drop_table);
                    if ($drop) {
                        echo "{$tablename} Table Deleted." . PHP_EOL;
                    }
                    $drop_table = "DROP TABLE IF EXISTS `media`;";
                    $drop = PluSQL::against($this->profile)->run($drop_table);
                    if ($drop) {
                        echo "Media Table Deleted." . PHP_EOL;
                    }
                }
                //create new table
                $arry = array();
                $create_table .= "CREATE TABLE IF NOT EXISTS `{$tablename}`" . PHP_EOL;
                $create_table .= "({$primaryid} INT NOT NULL AUTO_INCREMENT," . PHP_EOL;
                $create_table .= " PRIMARY KEY({$primaryid})," . PHP_EOL;
                $tmps = explode(",", $allheaders);
                $unique_headers = array_unique($tmps);
                $duplicates = array_diff_assoc($tmps, $unique_headers);
                foreach ($duplicates as $k => $d) {
                    $unique_headers[$k] = $d . '_1';
                }
                for ($i = 0; $i < count($unique_headers); $i++) {
                    $arry[] = $unique_headers[$i];
                    $create_table.="{$unique_headers[$i]} TEXT,";
                }
                if (substr($create_table, -1) == ",") {
                    $create_table = substr($create_table, 0, -1);
                    $create_table .= ");";
                }
                if ($createflag == 1 || $dropflag == 1) {
                    $create = PluSQL::against($this->profile)->run($create_table);
                    if ($create) {
                        echo "{$tablename} Table Created." . PHP_EOL;
                    }
                }
////////////////////////////////////////////////////////////////
                $marry = array();
                $mheaders = str_replace("#", "", $files3[0]);
                $mheaders1 = str_replace("/", "_", $mheaders);
                $mheaders2 = str_replace(" ", "_", $mheaders1);
                $mheaders3 = str_replace('"', "", $mheaders2);
                $mheaders4 = str_replace("'", "", $mheaders3);
                $mheaders5 = str_replace(":", "", $mheaders4);
                $mheaders6 = str_replace("?", "", $mheaders5);
                $mheaders7 = str_replace("$", "", $mheaders6);
                $mheaders8 = str_replace("@", "", $mheaders7);
                $mheaders9 = str_replace("%", "", $mheaders8);
                $mheaders10 = str_replace("&", "", $mheaders9);
                $mheaders11 = str_replace("*", "", $mheaders10);
                $mheaders12 = str_replace("-", "", $mheaders11);
                $mheaders13 = str_replace("+", "", $mheaders12);
                $mheaders14 = str_replace("=", "", $mheaders13);
                $mallheaders = strtolower($mheaders14);
                $create_media_table = "CREATE TABLE IF NOT EXISTS `media`" . PHP_EOL;
                $create_media_table .= "(media_id INT NOT NULL AUTO_INCREMENT," . PHP_EOL;
                $create_media_table .= " PRIMARY KEY(media_id)," . PHP_EOL;
                $mtmps = explode(",", $mallheaders);
                $munique_headers = array_unique($mtmps);
                $mduplicates = array_diff_assoc($mtmps, $munique_headers);
                foreach ($mduplicates as $k => $d) {
                    $munique_headers[$k] = $d . '_1';
                }
                for ($i = 0; $i < count($munique_headers); $i++) {
                    $marry[] = $munique_headers[$i];
                    $create_media_table.="{$munique_headers[$i]} TEXT,";
                }
                if (substr($create_media_table, -1) == ",") {
                    $create_media_table = substr($create_media_table, 0, -1);
                    $create_media_table .= ");";
                }
                if ($createflag == 1 || $dropflag == 1) {
                    $create_m = PluSQL::against($this->profile)->run($create_media_table);
                    if ($create_m) {
                        echo "Media Table Created." . PHP_EOL;
                    }
                }
                /////////////////////////////////////////////////////////////
                unset($files[0]);
                unset($files2[0]);
                unset($files3[0]);
                $count1 = count($files);
                $count2 = count($files2);
                $count3 = count($files3);
                $count = ($count1 + $count2 + $count3);
                echo "CSV Loading Started.." . PHP_EOL;
                echo "Total Entries (FILE 1 + FILE 2 + FILE 3 = TOTAL): {$count1} + {$count2} + {$count3} = " . $count . PHP_EOL;
                echo "CSV Loading complete = 0.00%";
                $smp = strlen("0.00%");
                $counter = 0;
                $all = implode(",", $arry);
                //insert statement
                //$sql = "INSERT INTO `{$tablename}`({$all}) VALUES ";
                //first csv file
                foreach ($files as $file) {
                    $tmp = str_getcsv($file);
                    $sql = "INSERT INTO `{$tablename}`({$all}) VALUES (";
                    foreach ($tmp as $t) {
                        $t = $this->esc(trim($t));
                        $sql .= "'" . $this->staus_check(trim($t)) . "', ";
                    }
                    if (substr($sql, -2, 1) == ",") {
                        $sql = substr($sql, 0, -2) . ") ";
                    }
                    $data_insert = PluSQL::against($this->profile)->run($sql);
                    if ($data_insert) {
                        //   echo PHP_EOL . $sql . PHP_EOL;
                        //echo PHP_EOL . "Data Insterted in Database.";
                    }
                    $counter++;
                    echo chr(27) . "[" . $smp . "D";
                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
                    $smp = strlen($tmp);
                    echo $tmp;
                }
                //second csv file
                foreach ($files2 as $file2) {
                    $tmp2 = str_getcsv($file2);
                    $sql = "INSERT INTO `{$tablename}`({$all}) VALUES (";
                    foreach ($tmp2 as $t2) {
                        $t2 = $this->esc(trim($t2));
                        $sql .= "'" . $this->staus_check(trim($t2)) . "', ";
                    }
                    if (substr($sql, -2, 1) == ",") {
                        $sql = substr($sql, 0, -2) . ") ";
                    }
                    $data_insert = PluSQL::against($this->profile)->run($sql);
                    if ($data_insert) {
                        //echo PHP_EOL . $sql . PHP_EOL;
                        //echo PHP_EOL . "Data Insterted in Database.";
                    }
                    $counter++;
                    echo chr(27) . "[" . $smp . "D";
                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
                    $smp = strlen($tmp);
                    echo $tmp;
                }
                //third csv file
                $mall = implode(",", $marry);
                foreach ($files3 as $file3) {
                    $tmp3 = str_getcsv($file3);
                    $sql = "INSERT INTO `media`({$mall}) VALUES (";
                    foreach ($tmp3 as $t3) {
                        $sql .= "'" . $this->esc(trim($t3)) . "', ";
                    }
                    if (substr($sql, -2, 1) == ",") {
                        $sql = substr($sql, 0, -2) . ") ";
                    }
                    $data_insert = PluSQL::against($this->profile)->run($sql);
                    if ($data_insert) {
                        //echo PHP_EOL . $sql . PHP_EOL;
                        //echo PHP_EOL . "Data Insterted in Database.";
                    }
                    $counter++;
                    echo chr(27) . "[" . $smp . "D";
                    $tmp = number_format(strval(($counter / $count) * 100), 2) . '%';
                    $smp = strlen($tmp);
                    echo $tmp;
                }
                if (substr($sql, -2, 1) == ",") {
                    $sql = substr($sql, 0, -2);
                }
                //  echo $sql;
//                $data_insert = PluSQL::against($this->profile)->run($sql);
//                if ($data_insert) {
//                    echo PHP_EOL . "Data Insterted in Database.";
//                }
                unset($files);
                unset($files2);
                unset($sql);
                gc_collect_cycles();
            }
            echo " " . PHP_EOL;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function truncate_table($tablename) {
        $sql = "TRUNCATE {$tablename}";
        $table_truncate = PluSQL::against($this->profile)->run($sql);
        if ($table_truncate) {
            echo "Truncate Table {$tablename}" . PHP_EOL;
        }
    }

    public function run() {
        $temp = Args::get("csv_file", Args::argv);
        $temp2 = Args::get("csv_file2", Args::argv);
        $temp3 = Args::get("csv_file3", Args::argv);
        $droptable = Args::get("drop_table", Args::argv);
        $createtable = Args::get("create_table", Args::argv);
        if (($temp === null) || ($temp == false) || ($temp2 === null) || ($temp2 == false) || ($temp3 === null) || ($temp3 == false) || ($droptable === null) || ($droptable == false) || ($createtable === null) || ($createtable == false)) {
            throw new \Exception(Constants::CSV_FILE);
        } else {
            $path = PACKAGES_DIR . "/jrmcsv/" . $temp;
            $path2 = PACKAGES_DIR . "/jrmcsv/" . $temp2;
            $path3 = PACKAGES_DIR . "/jrmcsv/" . $temp3;
            if (file_exists($path) && file_exists($path2) && file_exists($path3)) {
                //create table
                $this->load_csv_file_non_optimized("res_prop", "res_prop_id", $temp, $temp2, $temp3, $droptable, $createtable);
            } else {
                die("File name not found {$path} OR {$path2} OR {$path3}");
            }
        }
    }

}
