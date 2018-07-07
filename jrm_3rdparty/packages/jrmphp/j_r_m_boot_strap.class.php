<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of j_r_m_boot_strap
 *
 * @author waqas
 */
use Config\Central;
use Config\Constants;

class JRMBootStrap implements \RocketSled\Runnable {

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

    
    public function create_folder($foldername) {
        $folder = PACKAGES_DIR . "/" . $foldername;
        if (!is_dir($folder)) {
            mkdir($folder);
            echo "Folder Created: {$foldername}" . PHP_EOL;
            echo "Path: {$folder}" . PHP_EOL;
        } else {
            echo "Folder already exists: {$foldername}" . PHP_EOL;
            echo "Path: {$folder}" . PHP_EOL;
        }
    }

    public static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function delete_folder($foldername) {
        $folder = PACKAGES_DIR . "/" . $foldername;
        if (is_dir($folder)) {
            $this->delTree($folder);
            echo "Folder Deleted: {$foldername}" . PHP_EOL;
            echo "Path: {$folder}" . PHP_EOL;
        } else {
            echo "Folder already deleted: {$foldername}" . PHP_EOL;
            echo "Path: {$folder}" . PHP_EOL;
        }
    }

    public function run() {
        //csv import
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
                //$this->load_csv_file("res_props", "res_prop_ids", $temp, $temp2, $temp3);
                $jcsv = new JRMLoadCsv();
                $jcsv->run();
                //$this->load_csv_file_non_optimized("res_prop", "res_prop_id", $temp, $temp2, $temp3);
                //truncate table
                $this->truncate_table("img_res_prop");
                $this->truncate_table("pdf_res_prop");
                //old folder deleted
                $this->delete_folder("jrmimages");
                $this->delete_folder("jrmpdf");
                //create new folder
                $this->create_folder("jrmimages");
                $this->create_folder("jrmpdf");
                //creating images
                $jimg = new JRMGetImage();
                $jimg->run();
                $jpdf = new JRMMakePdf();
                $jpdf->run();
            } else {
                die("File name not found {$path} . {$path2}");
            }
        }
    }

}
