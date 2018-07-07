<?php

use Config\Central;
use Config\Constants;

class JRMCities implements \RocketSled\Runnable {

    protected $template;
    protected $profile = 'default';
    protected $central;
    protected $esc;
    protected $wherestr;

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

    public function get_city_values($c, $pc) {
        $arr = array();
        try {
            $sql = PluSQL::from($this->profile)->res_prop->select("res_prop_id, max(CAST(list_price as UNSIGNED)) as maxb, min(CAST(list_price as UNSIGNED)) as minb")->where("city='{$c}' AND property_category = '{$pc}'")->limit('0,1')->run()->res_prop;
            $arr = array($sql->minb, $sql->maxb);
            echo json_encode($arr);
        } catch (Exception $e) {
            
        }
    }

    public function buy_lease_values($bl) {
        $arr = array();
        try {
            $sql = PluSQL::from($this->profile)->res_prop->select("res_prop_id, max(CAST(list_price as UNSIGNED)) as maxb, min(CAST(list_price as UNSIGNED)) as minb")->where("property_category='{$bl}'")->limit('0,1')->run()->res_prop;
            $arr = array($sql->minb, $sql->maxb);
            echo json_encode($arr);
        } catch (Exception $e) {
            
        }
    }

    private function or_search($a, $colname, $arr = array()) {
        $as = explode(" ", $a);
        foreach ($as as $b) {
            $this->wherestr .= "AND {$colname} LIKE '%" . trim($b) . "%' ";
            foreach ($arr as $ar) {
                $this->wherestr .= "OR {$ar} LIKE '%" . trim($b) . "%' ";
            }
        }
    }

    public function get_zipcode_values($z) {
        $arr = array();
        try {
            $this->or_search($z, 'mls_', array('zip_code', 'street_box_number', 'street_name'));
            if (substr($this->wherestr, 0, 3) == 'AND') {
                $this->wherestr = substr($this->wherestr, 4);
            }
            $sql = PluSQL::from($this->profile)->res_prop->select("res_prop_id, max(CAST(list_price as UNSIGNED)) as maxb, min(CAST(list_price as UNSIGNED)) as minb")->where($this->wherestr)->limit('0,1')->run()->res_prop;
            $arr = array($sql->minb, $sql->maxb);
            echo json_encode($arr);
        } catch (Exception $e) {
            
        }
    }

    public function set_city($bl) {
        $arr = array();
        try {
            $sql_city = PluSQL::from($this->profile)->res_prop->select("*")->where("property_category = '{$bl}'")->groupBy("city")->run()->res_prop;
            $arr[""] = "Select City";
            foreach ($sql_city as $cities) {
                $arr[$cities->city] = $cities->city;
            }
            echo json_encode($arr);
        } catch (Exception $e) {
            
        }
    }

    public function run() {
        //if (isset($_REQUEST['city']) && $_REQUEST['city'] != '' || isset($_REQUEST['zip']) && $_REQUEST['zip'] != '' || isset($_REQUEST['buyorlease']) && $_REQUEST['buyorlease'] != '') {
           $c = '';
           if(isset($_REQUEST['city'])) 
            $c = $this->esc($_REQUEST['city']);
           $z = '';
           if(isset($_REQUEST['zip'])) 
            $z = $this->esc($_REQUEST['zip']);
           $bl = '';
           if(isset($_REQUEST['buyorlease']))
            $bl = $this->esc($_REQUEST['buyorlease']);
            
           
           if ($c != "" &&  $bl !="") {
                $this->get_city_values($c, $bl);
            } elseif ($z != '') {
                $this->get_zipcode_values($z);
            } elseif ($bl != "") {
                $this->buy_lease_values($bl);
                //$this->set_city($bl);
            } else {
                
            }
        //}
    }

}
