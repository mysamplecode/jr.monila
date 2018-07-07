<?php

use Config\Central;
use Config\Constants;

class JRMSearch extends RSBase {

    private $file = 'search_dpm.html';
    private $orderby = "";
    private $pageno;
    private $results = 20;
    private $citiesarr = array();

    public function __construct() {
        try {
            parent::__construct();
            $this->template = $this->central->load_normal($this->file);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function set_city() {
        try {
            $sql_city = PluSQL::from($this->profile)->res_prop->select("*")->where("property_category ='RES'")->groupBy("city")->run()->res_prop;
            $this->citiesarr[""] = "Select City";
            foreach ($sql_city as $cities) {
                $this->citiesarr[$cities->city] = $cities->city;
            }
            Central::repeat_select_options($this->template, '#citi', $this->citiesarr);
        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function or_search($a, $colname, $arr = array()) {
        $as = explode(" ", ($_REQUEST[$a]));
        foreach ($as as $b) {
            $this->wherestr .= "AND {$colname} LIKE '%" . $b . "%' ";
            foreach ($arr as $ar) {
                $this->wherestr .= "OR {$ar} LIKE '%" . $b . "%' ";
            }
        }
    }

    public function simple_search() {
        if (isset($_REQUEST['buyorlease']) && $_REQUEST['buyorlease'] == 'buy') {
            $this->wherestr.="AND property_category = 'RES' ";
            $this->pageresults.='&buyorlease=' . $_REQUEST['buyorlease'];
            $this->template->query('#buyval')->item(0)->setAttribute('checked', 'checked');
            $this->template->setValue('#buylease_val@value', '1');
            $this->template->setValue('#buyvalstatus@value', 'buy');
        } elseif (isset($_REQUEST['buyorlease']) && $_REQUEST['buyorlease'] == 'lease') {
            $this->wherestr.="AND property_category = 'Residential Lease' ";
            $this->pageresults.='&buyorlease=' . $_REQUEST['buyorlease'];
            $this->template->query('#leaseval')->item(0)->setAttribute('checked', 'checked');
            $this->template->setValue('#buylease_val@value', '1');
            $this->template->setValue('#buyvalstatus@value', 'lease');
        }
        if (isset($_REQUEST['cityorzip']) && $_REQUEST['cityorzip'] != '') {
            $this->or_search('cityorzip', 'mls_', array('zip_code', 'street_box_number', 'street_name', 'city'));
            $this->pageresults.='&cityorzip=' . $_REQUEST['cityorzip'];
            $this->template->setValue('#mlsno_search@value', ($_REQUEST['cityorzip']));
        }
        if (isset($_REQUEST['city']) && $_REQUEST['city'] != '') {
            $this->wherestr.="AND city = '" . ($_REQUEST['city']) . "' ";
            $this->template->setValue('#citi_val@value', '1');
            $this->template->setValue('#citivalues@value', $_REQUEST['city']);
            $this->pageresults.='&city=' . $_REQUEST['city'];
        }
    }

    public function advance_search() {
// Advance Search Results

        if (isset($_REQUEST['buyorlease']) && $_REQUEST['buyorlease'] == 'buy') {
            $this->wherestr.="AND property_category = 'RES' ";
            $this->pageresults.='&buyorlease=' . $_REQUEST['buyorlease'];
            $this->template->query('#buyval')->item(0)->setAttribute('checked', 'checked');
            $this->template->setValue('#buylease_val@value', '1');
            $this->template->setValue('#buyvalstatus@value', 'buy');
        } elseif (isset($_REQUEST['buyorlease']) && $_REQUEST['buyorlease'] == 'lease') {
            $this->wherestr.="AND property_category = 'Residential Lease' ";
            $this->pageresults.='&buyorlease=' . $_REQUEST['buyorlease'];
            $this->template->query('#leaseval')->item(0)->setAttribute('checked', 'checked');
            $this->template->setValue('#buylease_val@value', '1');
            $this->template->setValue('#buyvalstatus@value', 'lease');
        }
        if (isset($_REQUEST['city']) && $_REQUEST['city'] != '') {
            $this->wherestr.="AND city = '" . ($_REQUEST['city']) . "' ";
            $this->template->setValue('#citi_val@value', '1');
            $this->template->setValue('#citivalues@value', $_REQUEST['city']);
            $this->pageresults.='&city=' . $_REQUEST['city'];
        }
//MLS
        if (isset($_REQUEST['mlsno_search']) && $_REQUEST['mlsno_search'] != "") {
            $this->or_search('mlsno_search', 'mls_', array('zip_code', 'street_box_number', 'street_name', 'city'));
            $this->template->setValue('#mlsno_search@value', ($_REQUEST['mlsno_search']));
            $this->pageresults.='&mlsno_search=' . $_REQUEST['mlsno_search'];
        }
        if (isset($_REQUEST['parking_val']) && $_REQUEST['parking_val'] != "0") {
            if (isset($_REQUEST['detached_garages']) && $_REQUEST['detached_garages'] == "1") {
                $this->wherestr.="AND parking_garage LIKE '%Detached%' ";
                $this->template->query('#detached_garages')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&detached_garages=' . ($_REQUEST['detached_garages']);
            }
            if (isset($_REQUEST['attached_garages']) && $_REQUEST['attached_garages'] == "1") {
                $this->template->query('#attached_garages')->item(0)->setAttribute('checked', 'checked');
                $this->wherestr.="AND parking_garage LIKE '%Attached%' ";
                $this->pageresults.='&attached_garages=' . ($_REQUEST['attached_garages']);
            }
        }
        if (isset($_REQUEST['photos_count_val']) && $_REQUEST['photos_count_val'] != "0") {
            if (isset($_REQUEST['photos_must']) && $_REQUEST['photos_must'] == "1") {
                $this->wherestr.="AND photo_count > 1 AND res_prop_id IN (SELECT res_prop_id FROM img_res_prop where image_path != 'default.jpg') ";
                $this->template->query('#photos_must')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&photos_must=' . ($_REQUEST['photos_must']);
            }
        }
        if (isset($_REQUEST['openhouse_val']) && $_REQUEST['openhouse_val'] != "0") {
            if (isset($_REQUEST['none_openhouse']) && $_REQUEST['none_openhouse'] == "None") {
                $this->template->query('#none_openhouse1')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&none_openhouse=' . ($_REQUEST['none_openhouse']);
                $this->template->setValue('#text_status@value', 'None');
            } elseif (isset($_REQUEST['none_openhouse']) && $_REQUEST['none_openhouse'] == "Today") {
                $date = date('Y-m-d') . " 00:00:00";
                $this->template->query('#none_openhouse2')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&none_openhouse=' . ($_REQUEST['none_openhouse']);
                $this->wherestr.="AND open_house_date = '{$date}' ";
                $this->template->setValue('#text_status@value', 'Today');
            } elseif (isset($_REQUEST['none_openhouse']) && $_REQUEST['none_openhouse'] == "Tomorrow") {
                $this->template->query('#none_openhouse3')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&none_openhouse=' . ($_REQUEST['none_openhouse']);
                $tomorrow = date("Y-m-d", time() + 86400) . " 00:00:00";
                $this->wherestr.="AND open_house_date = '{$tomorrow}' ";
                $this->template->setValue('#text_status@value', 'Tomorrow');
            } elseif (isset($_REQUEST['none_openhouse']) && $_REQUEST['none_openhouse'] == "This Weekend") {
                $this->template->query('#none_openhouse4')->item(0)->setAttribute('checked', 'checked');
                $this->pageresults.='&none_openhouse=' . ($_REQUEST['none_openhouse']);
                $weekend = strtotime("+7 day");
                $this->wherestr.="AND open_house_date = '" . date('Y-m-d', $weekend) . "' ";
                $this->template->setValue('#text_status@value', 'This Weekend');
            }
        }
    }

    public function order_by_str($id, $colname) {
        $this->template->setValue('#' . $id . '@href', "?r=JRMSearch{$this->pageresults}&{$id}=ASC");
        if (isset($_REQUEST[$id]) && $_REQUEST[$id] == "ASC") {
            if ($colname == 'list_price') {
                $this->orderby = "CAST({$colname} as UNSIGNED) ASC";
            } else {
                $this->orderby = $colname . ' ASC';
            }
            $this->template->setValue('#' . $id . '@href', "?r=JRMSearch{$this->pageresults}&{$id}=DESC");
        } elseif (isset($_REQUEST[$id]) == "DESC") {
            $this->template->setValue('#' . $id . '@href', "?r=JRMSearch{$this->pageresults}&{$id}=ASC");
            if ($colname == 'list_price') {
                $this->orderby = "CAST({$colname} as UNSIGNED) DESC";
            } else {
                $this->orderby = $colname . ' DESC';
            }
        }
    }

    public function search_data() {
        try {
//General Search Results
//orders
            $this->orderby = "CAST(list_price as UNSIGNED) DESC";
            $this->order_by_str('newest', 'res_prop_id');
            $this->order_by_str('squarefeet', 'sqft');
            $this->order_by_str('pricel-h', 'list_price');
            $this->orderby .= ",city ASC, status ASC";
            $this->pageno = 1;
            if (isset($_REQUEST['p'])) {
                $this->pageno = $_REQUEST['p'];
            }
            $start_limit = ($this->pageno - 1) * $this->results;
            $endlimit = ($this->pageno * $this->results);
            try {

                if (substr($this->wherestr, 0, 3) == 'AND') {
                    $this->wherestr = substr($this->wherestr, 4);
                }
                $totalresults = 0;
                $pages = Plusql::from($this->profile)->res_prop->select("res_prop_id, count(*) as cnt");
                if (strlen($this->wherestr) > 0) {
                    $pages = $pages->where($this->wherestr);
                }
                $pages = $pages->run()->res_prop;
//                foreach ($pages as $p) {
//                    echo $totalresults++;
//                }
                $totalresults = $pages->cnt;
//die('die die die die die die');
                $totalpages = ceil($totalresults / $this->results);
                if ($totalpages > 1) {
                    $this->show_pagination('#page1', '#page1_value', $this->pageresults, $this->pageno);
                    if (($this->pageno + 1) > $totalpages) {
                        $this->template->setValue('#page2@style', 'display: none;');
                    } else {
                        $this->show_pagination('#page2', '#page2_value', $this->pageresults, $this->pageno, 1);
                    }if (($this->pageno + 2) > $totalpages) {
                        $this->template->setValue('#page3@style', 'display: none;');
                    } else {
                        $this->show_pagination('#page3', '#page3_value', $this->pageresults, $this->pageno, 2);
                    }
                    if (($this->pageno + 3) > $totalpages) {
                        $this->template->setValue('#page4@style', 'display: none;');
                    } else {
                        $this->show_pagination('#page4', '#page4_value', $this->pageresults, $this->pageno, 3);
                    }
                    if (($this->pageno - 1) == 0) {
                        $this->template->setValue('#prevpage@style', 'display: none;');
                    } else {
                        $this->template->setValue('#prevpage@href', "?r=JRMSearch$this->pageresults&p=" . ($this->pageno - 1));
                    }
                    if (($this->pageno + 1) > $totalpages) {
                        $this->template->setValue('#nextpage@style', 'display: none;');
                    } else {
                        $this->template->setValue('#nextpage@href', "?r=JRMSearch$this->pageresults&p=" . ($this->pageno + 1));
                    }
                } else {
                    $this->template->setValue('#pagination@style', 'display: none;');
                }
            } catch (Exception $e) {
                
            }

            $sql = Plusql::from($this->profile)->res_prop->select("*");
            if (strlen($this->wherestr) > 0) {
                $sql = $sql->where($this->wherestr);
            }
            if (strlen($this->orderby) > 0) {
                $sql = $sql->orderBy($this->orderby);
            }
            $sql = $sql->limit("$start_limit, $endlimit")->run()->res_prop;
            $thumb_view = $this->template->repeat('#thumbview');
            $count = 1;
            foreach ($sql as $s) {
                if ($count > $this->results) {
                    break;
                }
                $count++;
                $thumb_view->setValue('#address1', $s->street_box_number . ' ' . strtoupper($s->street_name));
                $thumb_view->setValue('#address2', strtoupper($s->city) . ', ' . strtoupper($s->state) . ' ' . $s->zip_code);
                $this->set_status($thumb_view, '#res_status', $s->status, '#learn_morebox@style', 'margin-top: 35px;');
                if (!is_null($s->list_price) || !empty($s->list_price)) {
                    $thumb_view->setValue('#listprice', '$' . number_format($s->list_price));
                } else {
                    $thumb_view->setValue('#listprice', '');
                }
//                $thumb_view->setValue('#beds1', number_format($s->_bedrooms) . ' Beds');
//                $thumb_view->setValue('#baths1',' | '. number_format($s->_full_baths) . ' Baths');
//                $thumb_view->setValue('#sqft', ' | '.number_format($s->sqft) . ' Sf');
                $thumb_view->setValue('#beds1', strtoupper($s->city));
                $thumb_view->setValue('#baths1', '');
                $thumb_view->setValue('#sqft', '');
                if ($s->photo_count > 0) {
                    $thumb_view->setValue('#img_a@href', '?r=JRMPropertyDetail' . $this->pageresults . '&q=' . $s->res_prop_id);
                    $this->adv_img_dwnld($thumb_view, $s->res_prop_id, $s->photo_count, $s->uid, 'main_img');
//                    try {
//                        $img_count = Plusql::from($this->profile)->res_prop->select("res_prop_id,count(*) as cnt")->where("res_prop_id= {$s->res_prop_id}")->limit('0,1')->run()->res_prop->cnt;
//                        if ($img_count != $s->photo_count) {
//                            $this->img->prop_check($s->uid, $s->photo_count, "HR", $s->res_prop_id);
//                        }
//                        try {
//                            $primary_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id}  AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//                            $imagepath = PACKAGES_DIR . '/jrmimages/' . $primary_image->image_path;
//                            $imagepath1 = __DIR__ . '/../jrmimages/' . $primary_image->image_path;
//                            if (file_exists($imagepath)) {
//                                if (imagecreatefromjpeg($imagepath) !== FALSE) {
//                                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $primary_image->image_path);
//                                } else {
//                                    $this->img->img_dwnld($primary_image->image_path, $imagepath);
//                                    $primary_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id}  AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//                                    $temp = PACKAGES_DIR . '/jrmimages/' . $primary_image->image_path;
//                                    if (file_exists($imagepath)) {
//                                        if (imagecreatefromjpeg($temp) === FALSE) {
//                                            throw new EmptySetException('CORRUPTED1: ' . $s->street_box_number . ' ' . $s->street_name . '<br/>');
//                                        } else {
//                                            $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $primary_image->image_path);
//                                        }
//                                    } else
//                                        throw new EmptySetException('CORRUPTED1: ' . $s->street_box_number . ' ' . $s->street_name . '<br/>');
//                                }
//                            } elseif (!file_exists($imagepath)) {
//                                $this->img->img_dwnld($primary_image->image_path, $imagepath);
//                                $primary_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id}  AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//                                if ($primary_image->image_path == 'default.jpg') {
//                                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                                } else {
//                                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $primary_image->image_path);
//                                }
//                            }
//                        } catch (EmptySetException $e) {
//                            $sql_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id}")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//
//                            $imagepath = PACKAGES_DIR . '/jrmimages/' . $sql_image->image_path;
//                            if (file_exists($imagepath)) {
//                                if (imagecreatefromjpeg($imagepath) !== FALSE) {
//                                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $sql_image->image_path);
//                                } else {
//                                    $this->img->img_dwnld($sql_image->image_path, $imagepath);
//                                    $sql_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id}")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//                                    $temp = PACKAGES_DIR . '/jrmimages/' . $sql_image->image_path;
//                                    if (file_exists($temp)) {
//                                        if (imagecreatefromjpeg($imagepath) !== FALSE) {
//                                            $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                                        } else
//                                            $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $sql_image->image_path);
//                                    } else
//                                        $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                                }
//                            } elseif (!file_exists($imagepath)) {
//                                $this->img->img_dwnld($sql_image->image_path, $imagepath);
//                                try {
//                                    $sql_image = Plusql::from($this->profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} and image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
//                                    if ($sql_image->image_path == 'default.jpg') {
//                                        $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                                    } else
//                                        $thumb_view->setValue('#main_img@src', PACKAGES_DIR . '/jrmimages/' . $sql_image->image_path);
//                                } catch (EmptySetException $e) {
//                                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                                }
//                            }
//                        }
//                    } catch (Exception $e) {
//                        $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
//                    }
                } else {
                    $thumb_view->setValue('#main_img@src', PACKAGES_DIR . Constants::DEFAULT_IMAGE);
                }
                $thumb_view->next();
            }
            Central::remove_last_repeating_element($this->template, '#last_image', 1, 2, 0);
        } catch (EmptySetException $e) {
            $text = "No record found with your current criteria. please choose diffrent criteria for find results.";
            $this->template->setValue('#errormessage', $text);
            $this->template->setValue('#errormessage@style', 'display: block;');
            $this->template->remove('.results');
        } catch (Exception $e) {
//echo $e->getMessage();
            header("Location: ?r=JRMIndex");
        }
    }

    public function update_main_contents() {
        if (isset($_REQUEST['search4result'])) {
            $this->simple_search();
        } elseif (isset($_REQUEST['search4advresults'])) {
            $this->advance_search();
        }
//print_r($_REQUEST);
//property status
        $this->set_city();
        $this->close_open_box('openhouse_val');
        $this->close_open_box('photos_count_val');
        $this->close_open_box('parking_val');
        $this->update_checkbox($this->template, 'property_status_val', 'status', 'status_repeat', 'last_flag1', 'active_status', 'lactive_status', '', '', 'totalselectedstatus');
//property type
        $this->update_checkbox($this->template, 'proptypes_val', 'property_type', 'repeat_checkbox', 'last_flag2', 'inputname_checkbox', 'lname_checkbox', '', 'RES-', 'totalselectedprops');
        $this->set_sliders();
        $this->remove_box('.static');
        $this->search_data();
    }

    

}
?>