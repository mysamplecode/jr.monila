<?php
use Config\Central;
use Config\Constants;

abstract class RSBase implements rocketsled\Runnable
{
    //--private members
    protected $template;
    protected $profile = 'default';
    protected $central;
    protected $img;
    protected $pdf;
    protected $esc;
    protected $wherestr;
    protected $pageresults;

    //--public members
    //--constructor
    public function __construct()
    {
        try
        {
            @session_start();
            // Load DB credentials and supported classes
            $this->central = Central::instance();
            $this->central->set_alias_connection($this->profile);
            $this->img = new JRMGetImage();
            $this->pdf = new JRMMakePdf();
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    //escape function
    public function __call($closure, $args)
    {
        $f = Plusql::escape($this->profile);
        return $f($args[0]);
    }

    //render function
    public function render($display = 1)
    {
        try
        {
            $this->prepare_template();
            $this->update_main_contents();
            if($display && !is_null($this->template))
            {
                $this->template->setValue('#rocket_sled@value', 1);
                $this->central->render($this->template);
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    //prepare the template
    public function prepare_template()
    {
        if(is_null($this->template)) return;
        //social media links
        $this->template->setValue('#twitter@href', Constants::TWITTER);
        $this->template->setValue('#facebook@href', Constants::FACEBOOK);
        $this->template->setValue('#google@href', Constants::GOOGLE);
        $this->template->setValue('#linkedin@href', Constants::LINKEDIN);
        $this->template->setValue('#youtube@href', Constants::YOUTUBE);
        //drop down menu
        $this->template->setValue('#neigh@href', '?r=JRMNeighborHoods');
        $this->template->setValue('#propdetail@href', '#');
        $this->template->setValue('#searchdata@href', '?r=JRMSearch');
        $this->template->setValue('#home@href', '?r=JRMIndex');
        //logo
        $this->template->setValue('#jrmlogo@href', '?r=JRMIndex');
        $this->template->setValue('#search_submit@action', '?r=JRMSearch');
        $this->template->setValue('#adv_search@action', '?r=JRMSearch');
        $this->template->setValue('#rocket_sled@value', 1);
    }

    public function update_single_slider($box_id, $col_name, $hmin_id, $hmax_id, $hcurr_id, $curr_id)
    { //$slider_id = min_bed,$col_name = _bedroom 
        try
        {
            $this->close_open_box($box_id);
            try
            {

                $min_bed = PluSQL::from($this->profile)->res_prop->select("res_prop_id,max(CAST({$col_name} as UNSIGNED)) as maxb, min(CAST({$col_name} as UNSIGNED)) as minb")->limit('0,1')->run()->res_prop;
                $this->template->setValue('#'.$hmin_id.'@value', $min_bed->minb);
                $this->template->setValue('#'.$hmax_id.'@value', $min_bed->maxb);
                $this->template->setValue('#'.$hcurr_id.'@value', $min_bed->minb);
            }
            catch(EmptySetException $e)
            {
                try
                {
                    //$this->template->remove('#' . $box_id);
                    return false;
                }
                catch(Exception $e)
                {
                    //do nothing
                }
            }
            $minbed = '';
            if(isset($_REQUEST[$curr_id]) && $_REQUEST[$curr_id] != "")
            {
                $minbed = $this->esc($_REQUEST[$curr_id]);
            }

            if(isset($_REQUEST[$box_id]) && $_REQUEST[$box_id] != "0")
            {
                if($minbed != "")
                {
                    $newminbed = str_replace(",", "", $minbed);
                    if(strcmp($minbed, '+') == 0)
                    {
                        $newminbed = str_replace(",", "", $minbed);
                        $this->wherestr.="AND {$col_name} <= '$newminbed' ";
                    }
                    if(strpos($min_bed, "-") !== false)
                    {
                        $newminbed1 = explode("-", $newminbed);
                        $this->wherestr.="AND {$col_name} BETWEEN {$newminbed1[0]} AND {$newminbed1[1]} ";
                    }
                    $this->pageresults.="&{$curr_id}=".$minbed;
                    $this->template->setValue('#'.$hcurr_id.'@value', str_replace(',', '', $minbed));
                }
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function update_double_slider($box_id, $col_name, $hmin_id, $hmax_id, $hcurr_id_min, $curr_id_min, $hcurr_id_max, $curr_id_max)
    { //$slider_id = min_bed,$col_name = _bedroom 
        try
        {
            $this->close_open_box($box_id);
            try
            {
                $min_bed = PluSQL::from($this->profile)->res_prop->select("res_prop_id,max(CAST({$col_name} as UNSIGNED)) as maxb, min(CAST({$col_name} as UNSIGNED)) as minb")->limit('0,1')->run()->res_prop;
                $this->template->setValue('#'.$hmin_id.'@value', $min_bed->minb);
                $this->template->setValue('#'.$hmax_id.'@value', $min_bed->maxb);
                $this->template->setValue('#'.$hcurr_id_min.'@value', $min_bed->minb);
                $this->template->setValue('#'.$hcurr_id_max.'@value', $min_bed->maxb);
            }
            catch(EmptySetException $e)
            {
                try
                {
                    $this->template->remove('#'.$box_id);
                    return false;
                }
                catch(Exception $e)
                {
                    //do nothing
                }
            }
            if(isset($_REQUEST[$curr_id_min]) && $_REQUEST[$curr_id_min] != "" && isset($_REQUEST[$curr_id_max]) && $_REQUEST[$curr_id_max] != "")
            {
                $minprice = $this->esc($_REQUEST[$curr_id_min]);
                $maxprice = $this->esc($_REQUEST[$curr_id_max]);
            }
            if(isset($_REQUEST[$box_id]) && $_REQUEST[$box_id] != "0")
            {
                if(($minprice) || ($maxprice) != "")
                {
                    $checkmin = substr($minprice, -1);
                    $checkmax = substr($maxprice, -1);
                    if(($checkmin != "+" && $checkmax != "+"))
                    {
                        $newminprice = str_replace(",", "", $minprice);
                        $newmaxprice = str_replace(",", "", $maxprice);
                        $this->wherestr.="AND {$col_name} BETWEEN {$newminprice} AND {$newmaxprice} ";
                    }
                    $this->pageresults.='&'.$curr_id_min.'='.$_REQUEST[$curr_id_min];
                    $this->pageresults.='&'.$curr_id_max.'='.$_REQUEST[$curr_id_max];
                    $this->template->setValue('#'.$hcurr_id_min.'@value', str_replace(',', '', $_REQUEST[$curr_id_min]));
                    $this->template->setValue('#'.$hcurr_id_max.'@value', str_replace(',', '', $_REQUEST[$curr_id_max]));
                }
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function show_pagination($pagehref, $pageval, $pageresults, $pageno, $greaterthan = 0)
    {
        $this->template->setValue($pagehref.'@href', "?r=JRMSearch$pageresults&p=".($pageno + $greaterthan));
        $this->template->setValue($pageval, ($pageno + $greaterthan));
        $this->template->setValue($pageval.'@style', "font-weight: bold;");
        if($pageno > ($greaterthan + 99))
        {
            $this->template->setValue($pageval.'@style', "padding-right: 4px; font-weight: bold;");
        }
    }

    public function remove_box($box_id)
    {
        $this->template->remove($box_id);
    }

    public function close_open_box($box_id)
    { //example $box_id = bedandbaths_val
        try
        {
            if(isset($_REQUEST[$box_id]) && $_REQUEST[$box_id] != "0")
            {
                $this->pageresults .= "&{$box_id}="."1";
                $this->template->setValue('#'.$box_id.'@value', '1');
            }
        }
        catch(exception $e)
        {
            throw $e;
        }
    }

    public function update_checkbox($template, $box_id, $col_name, $repeat_id, $last_flag_id, $check_box_id, $label_id, $mapping_array = array(), $remove_string = '', $selectsid)
    {
        $totalselects = 0;
        try
        {
            $this->close_open_box($box_id);
            try
            {
                $checkboxes = Plusql::from($this->profile)->res_prop->select("res_prop_id, $col_name")->groupBy("$col_name")->run()->res_prop;
                $crepeat = $template->repeat('#'.$repeat_id);
                $status = '';
                foreach($checkboxes as $checkbox)
                {
                    $cname = strtolower(str_replace(' ', '_', str_replace($remove_string, '', $checkbox->$col_name)));
                    $crepeat->setValue('#'.$check_box_id.'@name', $cname);
                    $temp = 0;
                    if(isset($_REQUEST[$cname]))
                    {
                        $temp = 1;
                        $this->pagestr .='&'.$cname."=".$temp;
                        $crepeat->query('#'.$check_box_id)->item(0)->setAttribute('checked', 'checked');
                        $totalselects++;
                    }
                    if(empty($mapping_array))
                    {
                        $crepeat->setValue('#'.$label_id, str_replace($remove_string, '', $checkbox->$col_name));
                    }
                    else
                    {
                        if(isset($mapping_array[$checkbox->$col_name]))
                        {
                            $crepeat->setValue('#'.$label_id, $mapping_array[$checkbox->$col_name]);
                        }
                        else
                        {
                            $crepeat->setValue('#'.$label_id, $checkbox->$col_name);
                        }
                    }
                    if($temp == 1)
                    {
                        $status .= "'".$checkbox->$col_name."', ";
                    }
                    $crepeat->next();
                    $this->template->setValue('#'.$selectsid.'@value', $totalselects);
                }
                Central::remove_last_repeating_element($template, '#'.$last_flag_id, 1, 2, 0);
                if(strlen($status) > 2)
                {
                    $status = substr($status, 0, -2);
                    $this->wherestr.="AND $col_name IN ($status) ";
                }//pagination
            }
            catch(EmptySetException $e)
            {
                $this->template->remove('#'.$box_id);
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function update_radio_buttons()
    {
        
    }

    public function set_status($template, $setid, $status, $margin, $marginval)
    {

        switch($status)
        {
            case "Active":
                $template->setValue($setid, '');
                // $template->setValue($margin, $marginval);
                break;
            case "Pending":
                $template->setValue($setid, 'SALE PENDING');
                break;
            case "Active Contingent":
                $template->setValue($setid, '');
                break;
            case "Active Option Contract":
                $template->setValue($setid, '');
                break;
            case "Active Kick Out":
                $template->setValue($setid, '');
                break;
            case "act":
                $template->setValue($setid, '');
                break;
            case "pnd":
                $template->setValue($setid, 'SALE PENDING');
                break;
            case "con":
                $template->setValue($setid, '');
                break;
            case "opt":
                $template->setValue($setid, '');
                break;
            case "ko":
                $template->setValue($setid, '');
                break;
        }
    }

    public function getimage_values($sql_query, $moredetails, $repeat, $addr1, $addr2, $status, $margin, $listprice, $bed, $bath, $sqft, $imgsrc, $stop)
    {
        try
        {
            $sql = $sql_query;
            $thumb_view = $this->template->repeat($repeat);
            foreach($sql as $s)
            {
                $thumb_view->setValue($moredetails.'@href', '?r=JRMPropertyDetail&q='.$s->res_prop_id);
                $thumb_view->setValue($addr1, $s->street_box_number.' '.strtoupper($s->street_name));
                $thumb_view->setValue($addr2, strtoupper($s->city).', '.strtoupper($s->state).' '.$s->zip_code);
                $this->set_status($thumb_view, $status, $s->status, $margin.'@style', 'margin-top: 35px;');
                if(!is_null($s->list_price) || !empty($s->list_price))
                {
                    $thumb_view->setValue($listprice, '$ '.number_format($s->list_price));
                }
                else
                {
                    $thumb_view->setValue($listprice, '');
                }
                $thumb_view->setValue($bed, strtoupper($s->city));
                $thumb_view->setValue($bath, '');
                $thumb_view->setValue($sqft, '');
                $this->adv_img_dwnld($thumb_view, $s->res_prop_id, $s->photo_count, $s->uid, $imgsrc);
                $thumb_view->next();
            }
            Central::remove_last_repeating_element($this->template, $stop, 1, 2, 0);
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    //get template function
    public function get_template()
    {
        return $this->template;
    }

    public function run($verbose = true)
    {
        try
        {
            if($verbose)
            {
                $this->render(true);
            }
        }
        catch(Exception $e)
        {
            if($verbose)
            {
                echo $e->getMessage();
            }
            else
            {
                throw $e; //for the Murphy
            }
        }
    }

    public function load_csv_file($tablename, $primaryid, $csvfile)
    {
        try
        {
            $create_table = "";
            $files = file(PACKAGES_DIR.'/'.Constants::DATA_PATH.'/'.$csvfile);
            if(!is_null($files))
            {
                $headers = str_replace("#", "", $files[0]);
                $headers1 = str_replace("/", "_", $headers);
                $headers2 = str_replace(" ", "_", $headers1);
                $headers3 = str_replace('"', "", $headers2);
                $headers4 = str_replace("'", "", $headers3);
                $headers5 = str_replace(":", "", $headers4);
                $headers6 = str_replace("?", "", $headers5);
                $allheaders = strtolower($headers6);
                //drop table
                $drop_table = "DROP TABLE IF EXISTS `{$tablename}`;";
                $drop = PluSQL::against($this->profile)->run($drop_table);
                if($drop)
                {
                    echo "Table Deleted.".PHP_EOL;
                }
                //create new table
                $create_table .= "CREATE TABLE IF NOT EXISTS `{$tablename}`".PHP_EOL;
                $create_table .= "({$primaryid} INT NOT NULL AUTO_INCREMENT,".PHP_EOL;
                $create_table .= " PRIMARY KEY({$primaryid}),".PHP_EOL;
                $tmps = explode(",", $allheaders);
                $unique_headers = array_unique($tmps);
                $duplicates = array_diff_assoc($tmps, $unique_headers);
                foreach($duplicates as $d)
                {
                    array_push($unique_headers, $d.'_1');
                }
                foreach($unique_headers as $allhead)
                {
                    $create_table.="$allhead TEXT,";
                }
                if(substr($create_table, -1) == ",")
                {
                    $create_table = substr($create_table, 0, -1);
                    $create_table .= ");";
                }
                $create = PluSQL::against($this->profile)->run($create_table);
                if($create)
                {
                    echo "Table Created.".PHP_EOL;
                }
                unset($files[0]);
                $count = count($files);
                echo "CSV Loading Started..".PHP_EOL;
                echo "Total Entries: $count".PHP_EOL;
                echo "CSV Loading complete = 0.00%";
                $smp = strlen("0.00%");
                $counter = 0;
                //insert statement
                $sql = "INSERT INTO `{$tablename}`({$allheaders}) VALUES ";
                foreach($files as $file)
                {
                    $tmp = str_getcsv($file);
                    $sql .= "(";
                    foreach($tmp as $t)
                    {
                        $sql .= "'".$this->esc(trim($t))."', ";
                    }
                    if(substr($sql, -2, 1) == ",")
                    {
                        $sql = substr($sql, 0, -2)."), ";
                    }
                    $counter++;
                    echo chr(27)."[".$smp."D";
                    $tmp = number_format(strval(($counter / $count) * 100), 2).'%';
                    $smp = strlen($tmp);
                    echo $tmp;
                }
                if(substr($sql, -2, 1) == ",")
                {
                    $sql = substr($sql, 0, -2);
                }
                $data_insert = PluSQL::against($this->profile)->run($sql);
                if($data_insert)
                {
                    echo "Data Insterted in Database.";
                    unset($files);
                    unset($sql);
                    gc_collect_cycles();
                }
                else
                {
                    die("Error found.");
                }
            }
            echo " ".PHP_EOL;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function truncate_table($tablename)
    {
        $sql = "TRUNCATE {$tablename}";
        $table_truncate = PluSQL::against($this->profile)->run($sql);
        if($table_truncate)
        {
            echo "Truncate Table {$tablename}".PHP_EOL;
        }
    }

    public function create_folder($foldername)
    {
        $folder = PACKAGES_DIR."/".$foldername;
        if(!is_dir($folder))
        {
            mkdir($folder);
            echo "Folder Created: {$foldername}".PHP_EOL;
            echo "Path: {$folder}".PHP_EOL;
        }
        else
        {
            echo "Folder already exists: {$foldername}".PHP_EOL;
            echo "Path: {$folder}".PHP_EOL;
        }
    }

    public static function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach($files as $file)
        {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function delete_folder($foldername)
    {
        $folder = PACKAGES_DIR."/".$foldername;
        if(is_dir($folder))
        {
            $this->delTree($folder);
            echo "Folder Deleted: {$foldername}".PHP_EOL;
            echo "Path: {$folder}".PHP_EOL;
        }
        else
        {
            echo "Folder already deleted: {$foldername}".PHP_EOL;
            echo "Path: {$folder}".PHP_EOL;
        }
    }

    private function load_suburbs($mp)
    {
        try
        {
            //$data = array();
            $files = file(PACKAGES_DIR.'/'.Constants::DATA_PATH.'/'.Constants::DATA_FILE);
            if(!is_null($files))
            {
                unset($files[0]);
                $count = count($files);
                echo "Suburb Loading Started..".PHP_EOL;
                echo "Total Entries: $count".PHP_EOL;
                echo "Suburb Loading complete = 0.00%";
                $smp = strlen("0.00%");
                $counter = 0;
                foreach($files as $file)
                {
                    $tmp = explode(',', $file);
                    PluSQL::into($this->profile)->$mp["suburbs"](array
                        (
                        'postcode' => trim(trim(trim($tmp[0]), '\"')),
                        'locality' => trim(trim(trim($tmp[1]), '\"')),
                        'state' => trim(trim(trim($tmp[2]), '\"')),
                        'comments' => trim(trim(trim($tmp[3]), '\"')),
                        'deliveryoffice' => trim(trim(trim($tmp[4]), '\"')),
                        'pindicator' => trim(trim(trim($tmp[5]), '\"')),
                        'pzone' => trim(trim(trim($tmp[6]), '\"')),
                        'bspnumber' => trim(trim(trim($tmp[7]), '\"')),
                        'bspname' => trim(trim(trim($tmp[8]), '\"')),
                        'category' => trim(trim(trim($tmp[9]), '\"')),
                    ))->insert();
                    $counter++;
                    echo chr(27)."[".$smp."D";
                    $tmp = number_format(strval(($counter / $count) * 100), 2).'%';
                    $smp = strlen($tmp);
                    echo $tmp;
                }
                unset($files);
                gc_collect_cycles();
            }
            echo " ".PHP_EOL;
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    public function set_sliders()
    {
        //bed
        $this->update_single_slider('bedandbaths_val', '_bedrooms', 'hminbed_min', 'hminbed_max', 'hminbed', 'minbed');
        //bath
        $this->update_single_slider('bedandbaths_val', '_full_baths', 'hminbath_min', 'hminbath_max', 'hminbath', 'minbath');
        //garage spaces
        $this->update_single_slider('parking_val', '_garage_spaces', 'hminmaxgaragespaces_min', 'hminmaxgaragespaces_max', 'hminmaxgaragespaces', 'maxgaragespaces');
        //total spaces
        $this->update_single_slider('parking_val', 'total_covered_parking', 'hmintotalspaces_min', 'hmintotalspaces_max', 'hmintotalspaces', 'totalspaces');
        //price
        $this->update_double_slider('price_val', 'list_price', 'hminprice_min', 'hmaxprice_max', 'hminprice', 'minprice', 'hmaxprice', 'maxprice');
        //homesize
        $this->update_double_slider('homesize_val', 'sqft', 'hminhomesize_min', 'hmaxhomesize_max', 'hminhomesize', 'minhomesize', 'hmaxhomesize', 'maxhomesize');
        //lotsize
        $this->update_double_slider('lotsizes_val', 'acres', 'hminlotsize_min', 'hmaxlotsize_max', 'hminlotsize', 'minlotsize', 'hmaxlotsize', 'maxlotsize');
        //yearbuilt
        $this->update_double_slider('yearbuilt_val', 'year_built', 'hminyearbuilt_min', 'hmaxyearbuilt_max', 'hminyearbuilt', 'minyearbuilt', 'hmaxyearbuilt', 'maxyearbuilt');
    }

    public function adv_img_dwnld($thumb_view, $sqlid, $photocount, $uid, $src_id)
    {
        try
        {
            $img_count = Plusql::from($this->profile)->img_res_prop->select("img_res_prop_id,count(*) as cnt")->where("res_prop_id= {$sqlid}")->limit('0,1')->run()->img_res_prop->cnt;
            if(1)
            {
                $this->img->prop_check($uid, $photocount, "HR", $sqlid);
            }
            try
            {
                $primary_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$sqlid} AND image_path != 'default.jpg' AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($uid, -2)."/".$primary_image->image_path;
                $thumb_view->setValue('#'.$src_id.'@src', $imagepath);
            }
            catch(EmptySetException $e)
            {
                $sql_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$sqlid} AND image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($uid, -2)."/".$sql_image->image_path;
                $thumb_view->setValue('#'.$src_id.'@src', $imagepath);
            }
        }
        catch(Exception $e)
        {
            $thumb_view->setValue('#'.$src_id.'@src', PACKAGES_DIR.Constants::DEFAULT_IMAGE);
        }
    }

    //abstract function
    abstract protected function update_main_contents();
}

?>