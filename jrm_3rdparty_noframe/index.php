<?php
include_once 'PluSQL/autoload.config.php';
include_once 'Config/dbconfig.class.php';

$dbconfig = Dbconfig::get_dbconfig();
$details = array
    (
    0 => $dbconfig[Dbconfig::DB_HOST],
    1 => $dbconfig[Dbconfig::DB_USER],
    2 => $dbconfig[Dbconfig::DB_PASSWORD],
    3 => $dbconfig[Dbconfig::DB_NAME],
);
$profile = 'index';
Plusql::credentials($profile, $details);

function like_query($cond, $colname, $arr = array()) 
{
    global $profile;
    $where = '';
    foreach ($arr as $a) {
        $where .="AND {$colname} {$cond} ('%{$a}%') ";
    }
    return $where;
}
eval(base64_decode('c2xlZXAoMSk7'));
function thumbview_query($where, $orderby, $limit) 
{
    global $profile;
    $sql = '';
    try {
        ob_start();
        echo Plusql::from($profile)->img_res_prop->select("res_prop_id")->where("image_path Like 'HR%'");
        $tablematch = ob_get_contents();
        ob_end_clean();
        $str = "res_prop_id IN( $tablematch )";
        ob_get_contents();
        $sql = PluSQL::from($profile)->res_prop->select("*")->where("property_category = 'RES' AND photo_count > 4 AND status NOT IN ('Pending','pnd') {$where}")->orderby("cast(list_price as unsigned)" . $orderby)->limit($limit)->run()->res_prop;
    } catch (Exception $e) {
        try {
            ob_start();
            echo Plusql::from($profile)->img_res_prop->select("res_prop_id")->where("image_path Like 'HR%'");
            $tablematch = ob_get_contents();
            ob_end_clean();
            $str = "res_prop_id IN( $tablematch )";
            ob_get_contents();
            $sql = PluSQL::from($profile)->res_prop->select("*")->where("property_category = 'RES' AND photo_count > 4 AND status NOT IN ('Pending','pnd')")->orderby("cast(list_price as unsigned)" . $orderby)->limit($limit)->run()->res_prop;
        } catch (Exception $e) {

        }
    }
    return $sql;
}

function prop_check($uid, $photocount, $resolution, $id) 
{
    global $profile;
    for ($i = 1; $i <= $photocount; $i++) {
        $count = 0;
        $filename = $resolution . $uid . '-' . $i . '.jpg';
        $filepath = __DIR__ . "/../jrmimages/" . $filename;
        try {
            $chk_img = Plusql::from($profile)->img_res_prop->select("*")->where("image_path = '{$filename}'")->run()->img_res_prop;
        } catch (EmptySetException $e) {
            img_ins($id, $filename);
        }
    }
}

function img_ins($id, $filename) 
{
    global $profile;
    $primarypic = 0;
    try {
        $filename_check = substr($filename, 2);
        $media = Plusql::from($profile)->media->select("*")->where("mediasource = '{$filename_check}'")->run()->media;
        $primarypic = 1;
    } catch (EmptySetException $e) {

    }
    try {
        PluSQL::into($profile)->img_res_prop(array('res_prop_id' => $id, 'image_path' => $filename, 'primary_pic' => $primarypic))->insert();
    } catch (Exception $e) {

    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Jr Molina</title>
        <link type='text/css' href="css/range_slider_ul.css" rel='stylesheet' />
        <link href="css/all.css" rel="stylesheet" type="text/css" />
        <link href="css/rangeslider.css" rel="stylesheet" type="text/css" />
        <link href="css/testimonials.css" rel="stylesheet" type="text/css" />
        <!--image slider js end-->
         <script type='text/javascript' src='js/js_lib.js'></script>
       <!-- <script type="text/javascript" src="demos/scripts/jquery-1.9.0.min.js"></script> -->
        <script type="text/ecmascript" src="js/js_lib_1.9.1.js"></script>
        <script type='text/javascript' src='js/jquery-ui-1.10.3.custom.js'></script>
        <script type="text/javascript" src="js/rangeslider.js"></script>
        <script type='text/javascript' src='js/molina.js'></script>
        <!--image slider js-->
    </head>
    <body>
        <div class="wrapper">
            <div class="header">
                <div class="strip">
                    <div class="header_row1">
                        <div class="header_col1">
                            <h2>Call Now to Schedule a Home Showing: 214-444-8289</h2>
                        </div>
                        <div class="header_col2">
                            <div class="tweeter fleft wc20"> 
                                <span class="tweet">
                                    <a id="twitter" target="_blank" href="#">
                                        Twitter
                                    </a>
                                </span> 
                            </div>
                            <div class="facebook fleft wc20">
                                <span class="tweet">
                                    <a id="facebook" target="_blank" href="#" class="fleft wc20">
                                        Facebook
                                    </a>
                                </span> 
                            </div>
                            <div class="google fleft wc20"> 
                                <span class="tweet">
                                    <a id="google" target="_blank" href="#">
                                        Google +
                                    </a>
                                </span> 
                            </div>
                            <div class="linkedin fleft wc20"> 
                                <span class="tweet">
                                    <a id="linkedin" target="_blank" href="#">
                                        Linkedin
                                    </a>
                                </span> 
                            </div>
                            <div class="youtube fleft wc20"> 
                                <span class="tweet">
                                    <a id="youtube" target="_blank" href="#">
                                        Youtube
                                    </a>
                                </span> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header_bg wc100 fleft">
                    <div class="header_row2">
                        <div class="header_col3">
                            <div class="logo fleft wc100 h75"> 
                                <a id="jrmlogo" href="#">
                                    <img src="images/logo.png" />
                                </a> 
                            </div>
                        </div>
                        <div class="header_col4">
                            <ul class="hdr_menu fright">
                                <li class="menu_styl">
                                    <a id="searchdata" href="search_dpm.html">
                                        PROPERTY SEARCH
                                    </a>
                                </li>
                                <li class="menu_styl_02">
                                    <a id="propdetail" href="property_detail.html">
                                        BECOME A CLIENT
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="#">
                                                manu-1
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                manu-1
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                manu-1
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                manu-1
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu_styl_03">
                                    <a id="neigh" href="neighborhoods.html">
                                        NEIGHBORHOODS
                                    </a>
                                </li>
                            </ul>
                            <ul class="header_col5 fright mr40">
                                <li class="nav_styl_02">
                                    <a id="home" href="index.html">
                                        Home
                                    </a>
                                </li>
                                <li class="nav_styl_02">
                                    <a href="#">
                                        Blog
                                    </a>
                                </li>
                                <li class="nav_styl_02">
                                    <a href="#">
                                        About
                                    </a>
                                </li>
                                <li class="nav_styl_03">
                                    <a href="#">
                                        Contact Us
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--image slider start here-->
            <div class="slider-wrapper fleft">
                <div id="slider"> 
                    <a href="#">
                    	<img src="images/slider_new_img.png" alt="" title="" />
                    </a>
                </div>
            </div>
            <!--image slider start end-->
            <!-- image slider search box start -->
            <div class="slider_search">
                <div class="slider">
                    <div class="slider_row">
                        <div class="slider_col">
                            <div class="search_outer_box">
                                <div class="search_outer">
                                    <div class="search_box wc84 outborder" style="margin-top:9px;">
                                        <div class="ffarial fs9 fw clrwht">
                                            <h1>Property Search</h1>
                                        </div>
                                        <div class="form_table fright">    
                                            <form id="search_submit" action="" method="post">
                                                <div class="form_row wc100 fleft">
                                                    <div class="form_col wc100 h41 mg10 fleft">
                                                        <div class="buy_lease">
                                                            <img id="pic_right" src="images/sale-1.png" />
                                                            <img id="pic_left" src="images/rent-1.png" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="buyorlease" name="buyorlease" value="" />
                                                <div id="zipdiv" class="form_row wc100 fleft">
                                                    <div class="form_col wc100 h38 fleft  ffarial">
                                                        <input class="fleft h30 wc94 fs10 bg" type="text" name="cityorzip" id="search" 
                                                               placeholder="Enter Zip Code, Address, or MLS #" />
                                                    </div>
                                                </div>
                                                <div id="citydiv" class="form_row wc100 fleft">
                                                    <div class="form_col wc100 h38  fleft">
                                                        <select id="city" name="city" class="dropdown_bg fleft h30 wc94 fs10 bg">
                                                            <option value="">Select City</option>
                                                            <?php 
                                                                  $sql_city = PluSQL::from($profile)->res_prop->select("*")->where("property_category ='RES'")->groupBy("city")->run()->res_prop;
                                                                  foreach ($sql_city as $cities)
                                                                  {
                                                            ?>
                                                                    <option value="<?php echo $cities->city;?>"><?php echo $cities->city;?></option>
                                                            <?php 
                                                                  }  
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form_row wc100 fleft">
                                                    <div class="form_col wc100 h38 fleft">
                                                        <input type="hidden" id="price_val" name="price_val" value="1" />
                                                        <span class="text_container">
                                                            <label>$</label>
                                                            <input type="text"  class="h30 wc40 mr20 fs10 bg2" name="minprice" readonly="readonly" id="minprice"
                                                                   placeholder="Price Min" />
                                                        </span>                                                        
                                                        <input type="hidden" id="hminprice" value="0" />
                                                        <input type="hidden" id="hminprice_min" value="0" />
                                                        <span class="text_container">
                                                            <label>$</label>                                                        
                                                            <input class="h30 wc40 fs10 bg2" type="text" name="maxprice" readonly="readonly" id="maxprice" 
                                                                   placeholder="Price Max" />
                                                        </span>
                                                        <input type="hidden" id="hmaxprice" value="0" />
                                                        <input type="hidden" id="hmaxprice_max" value="0" />
                                                    </div>
                                                </div>
                                                <div class="form_row wc100 fleft hie">
                                                    <div class="form_col wc100 h38 fleft">
                                                        <div class="slider_range wc100 fleft"> 
                                                            <!-- Slider -->
                                                            <div id="slider-range-price">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form_col h38 fleft wc45">
                                                    <span class="text_container1">
                                                        <label>Beds</label>                                                        
                                                        <input class="fleft h30 wc72 mr20 fs10 bg3" type="text" readonly="readonly" name="minbed" id="minbed"
                                                               placeholder="Bed Min" />
                                                    </span>
                                                    <input type="hidden" id="bedandbaths_val" name="bedandbaths_val" value="1" />
                                                    <input type="hidden" id="hminbed" value="0" />
                                                    <input type="hidden" id="hminbed_min" value="0" />
                                                    <input type="hidden" id="hminbed_max" value="0" />
                                                </div>
                                                <div class="slider_range2 wc50 fleft"> 
                                                    <!-- Slider -->
                                                    <div id="slider-range-1"></div>
                                                </div>
                                                <div class="form_col h38 fleft wc45">
                                                    <span class="text_container1">
                                                        <label>Baths</label>                                                        
                                                        <input class="fleft h30 wc72 mr20 fs10 bg3" type="text" readonly="readonly" name="minbath" 
                                                               id="minbath" placeholder="Bath Min" />
                                                    </span>
                                                    <input type="hidden" id="hminbath" value="0" />
                                                    <input type="hidden" id="hminbath_min" value="0" />
                                                    <input type="hidden" id="hminbath_max" value="0" />
                                                </div>
                                                <div class="slider_range2 wc50 fleft"> 
                                                    <!-- Slider -->
                                                    <div id="slider-range-2"></div>
                                                </div>
                                                <div class="form_row wc100 fleft">
                                                    <div class="form_col wc100 h30 fleft">
                                                        <input class="fleft h30 wc30 mg4 ml70 src_ne" type="submit" value="" 
                                                               name="search4result" id="name" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- image slider search box end -->
            <!--Calculater -->
            <div class="working_area">
                <div class="working_container">
                    <div class="home_btn_row">
                        <div id="learn_more" class="home_btn1 urbandallas">
                            <a href="javascript:void(0)">Urban Dallas</a>
                        </div>
                        <div id="learn_more" class="home_btn1 urbansuburbs">
                            <a href="javascript:void(0)">Dallas Suburbs</a>
                        </div>
                        <div id="learn_more" class="home_btn1 new_listing">
                            <a href="javascript:void(0)">New Listings</a>
                        </div>
                        <div id="learn_more" class="home_btn1 recentlyreduced" >
                            <a href="javascript:void(0)">Recently Reduced</a>
                        </div>
                    </div>
                    <div class="cat_list_outer fleft mg7">
                        <div class="cat_row1 fleft wc1000 m8">
                            <?php 
                            $sq = like_query('LIKE', 'zip_code', array('75201', '75202', '75207', '75219', '75204', '75208', '75226', '75039'));
                            $sql = thumbview_query($sq, "DESC", "0, 3");
                            $imagepath = '';
                            foreach($sql as $s)
                            {
                                $img_count = Plusql::from($profile)->img_res_prop->select("img_res_prop_id,count(*) as cnt")->where("res_prop_id= {$s->res_prop_id}")->limit('0,1')->run()->img_res_prop->cnt;
                                if(1)
                                {
                                    prop_check($s->uid, $s->photo_count, "HR", $s->res_prop_id);
                                }
                                
                                try
                                {
                                    $primary_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg' AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$primary_image->image_path;
                                }
                                catch(EmptySetException $e)
                                {
                                    $sql_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$sql_image->image_path;
                                }
                            ?>
                            <div id="thumbview" class="cat_col2 wc32-0 mr8 fleft thumbview"> 
                                <a id="moredetails" href="#">
                                    <img id="main_img" src="<?php echo $imagepath ;?>" style="height: 216px; width: 320px;" class="wc100" />
                                </a>
                                <div class="strip_1 even3">
                                    <div class="wc55 fleft h81">
                                        <div class="pt13 wc100 pl25 fleft clrwht fs8 boxs_bg">
                                            <h1 id="address1"><?php echo $s->street_box_number . ' ' . strtoupper($s->street_name); ?></h1>
                                        </div>
                                        <div class="fleft wc100 fb fs14 pl25">
                                            <p id="listprice" class="clrwht"><?php echo '$ ' . number_format($s->list_price);?> | <?php echo strtoupper($s->state) . ' ' . $s->zip_code;?></p>
                                        </div>
                                        <div class="wc100 fb fs12 pl25">
                                            <p class="clrwht">
                                                <a id="beds1" href=""><?php echo strtoupper($s->city);?></a>
                                                <a id="baths1" href=""></a>
                                                <a id="sqft" href=""></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="fright wc35 h81">
                                        <div class="pending_sale">
                                            <span id="res_status" class="new newtxt mg10 fleft mr6">
                                                
                                            </span>
                                        </div>
                                        <div class="col_btn wc100 fleft">
                                            <div id="learn_morebox" style="" class="learn_morebox">
                                                <a id="moredetails" href="#">
                                                    <img src="images/details.png" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="last_image" style="display: none;"></div>
                            <!-- display one   -->
                            <?php 
                            $sq = like_query('NOT LIKE', 'zip_code', array('75201', '75202', '75207', '75219', '75204', '75208', '75226', '75039'));
                            $sql = thumbview_query($sq, "DESC", "3, 3");
                            $imagepath = '';
                            foreach($sql as $s)
                            {
                                $img_count = Plusql::from($profile)->img_res_prop->select("img_res_prop_id,count(*) as cnt")->where("res_prop_id= {$s->res_prop_id}")->limit('0,1')->run()->img_res_prop->cnt;
                                if(1)
                                {
                                    prop_check($s->uid, $s->photo_count, "HR", $s->res_prop_id);
                                }
                                
                                try
                                {
                                    $primary_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg' AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$primary_image->image_path;
                                }
                                catch(EmptySetException $e)
                                {
                                    $sql_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$sql_image->image_path;
                                }
                            ?>
                            <div id="thumbview1" class="cat_col2 wc32-0 mr8 fleft thumbview1 onloadhide"> 
                                <a id="moredetails1" href="#">
                                    <img id="main_img1" src="<?php echo $imagepath ;?>" style="height: 216px; width: 320px;" class="wc100" />
                                </a>
                                <div class="strip_1 even3">
                                    <div class="wc55 fleft h81">
                                        <div class="pt13 wc100 pl25 fleft clrwht fs8 boxs_bg">
                                            <h1 id="address1"><?php echo $s->street_box_number . ' ' . strtoupper($s->street_name); ?></h1>
                                        </div>
                                        <div class="fleft wc100 fb fs14 pl25">
                                            <p id="listprice" class="clrwht"><?php echo '$ ' . number_format($s->list_price);?> | <?php echo strtoupper($s->state) . ' ' . $s->zip_code;?></p>
                                        </div>
                                        <div class="wc100 fb fs12 pl25">
                                            <p class="clrwht">
                                                <a id="beds1" href=""><?php echo strtoupper($s->city);?></a>
                                                <a id="baths1" href=""></a>
                                                <a id="sqft" href=""></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="fright wc35 h81">
                                        <div class="pending_sale">
                                            <span id="res_status" class="new newtxt mg10 fleft mr6">
                                                
                                            </span>
                                        </div>
                                        <div class="col_btn wc100 fleft">
                                            <div id="learn_morebox" style="" class="learn_morebox">
                                                <a id="moredetails" href="#">
                                                    <img src="images/details.png" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="last_image1" style="display: none;"></div>
                            <!-- display two   -->
                            <?php 
                            $sql = thumbview_query("", "DESC", "6, 3");
                            $imagepath = '';
                            foreach($sql as $s)
                            {
                                $img_count = Plusql::from($profile)->img_res_prop->select("img_res_prop_id,count(*) as cnt")->where("res_prop_id= {$s->res_prop_id}")->limit('0,1')->run()->img_res_prop->cnt;
                                if(1)
                                {
                                    prop_check($s->uid, $s->photo_count, "HR", $s->res_prop_id);
                                }
                                
                                try
                                {
                                    $primary_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg' AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$primary_image->image_path;
                                }
                                catch(EmptySetException $e)
                                {
                                    $sql_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$sql_image->image_path;
                                }
                            ?>
                            <div id="thumbview12" class="cat_col2 wc32-0 mr8 fleft thumbview12 onloadhide"> 
                                <a id="moredetails2" href="#">
                                    <img id="main_img12" src="<?php echo $imagepath ;?>" style="height: 216px; width: 320px;" class="wc100" />
                                </a>
                                <div class="strip_1 even3">
                                    <div class="wc55 fleft h81">
                                        <div class="pt13 wc100 pl25 fleft clrwht fs8 boxs_bg">
                                            <h1 id="address1"><?php echo $s->street_box_number . ' ' . strtoupper($s->street_name); ?></h1>
                                        </div>
                                        <div class="fleft wc100 fb fs14 pl25">
                                            <p id="listprice" class="clrwht"><?php echo '$ ' . number_format($s->list_price);?> | <?php echo strtoupper($s->state) . ' ' . $s->zip_code;?></p>
                                        </div>
                                        <div class="wc100 fb fs12 pl25">
                                            <p class="clrwht">
                                                <a id="beds1" href=""><?php echo strtoupper($s->city);?></a>
                                                <a id="baths1" href=""></a>
                                                <a id="sqft" href=""></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="fright wc35 h81">
                                        <div class="pending_sale">
                                            <span id="res_status" class="new newtxt mg10 fleft mr6">
                                                
                                            </span>
                                        </div>
                                        <div class="col_btn wc100 fleft">
                                            <div id="learn_morebox" style="" class="learn_morebox">
                                                <a id="moredetails" href="#">
                                                    <img src="images/details.png" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div id="last_image12" style="display: none;"></div>
                            <!-- display three   -->
                            <?php 
                            $sql = thumbview_query("", "DESC", "9, 3");
                            $imagepath = '';
                            foreach($sql as $s)
                            {
                                $img_count = Plusql::from($profile)->img_res_prop->select("img_res_prop_id,count(*) as cnt")->where("res_prop_id= {$s->res_prop_id}")->limit('0,1')->run()->img_res_prop->cnt;
                                if(1)
                                {
                                    prop_check($s->uid, $s->photo_count, "HR", $s->res_prop_id);
                                }
                                
                                try
                                {
                                    $primary_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg' AND primary_pic = 1")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$primary_image->image_path;
                                }
                                catch(EmptySetException $e)
                                {
                                    $sql_image = Plusql::from($profile)->img_res_prop->select("*")->where("res_prop_id= {$s->res_prop_id} AND image_path != 'default.jpg'")->orderby("img_res_prop_id")->limit('0,1')->run()->img_res_prop;
                                    $imagepath = "http://ntreispictures.marketlinx.com/MediaDisplay/".substr($s->uid, -2)."/".$sql_image->image_path;
                                }
                            ?>
                            <div id="thumbview123" class="cat_col2 wc32-0 mr8 fleft thumbview123 onloadhide"> 
                                <a id="moredetails3" href="#">
                                    <img id="main_img123" src="<?php echo $imagepath ;?>" style="height: 216px; width: 320px;" class="wc100" />
                                </a>
                                <div class="strip_1 even3">
                                    <div class="wc55 fleft h81">
                                        <div class="pt13 wc100 pl25 fleft clrwht fs8 boxs_bg">
                                            <h1 id="address1"><?php echo $s->street_box_number . ' ' . strtoupper($s->street_name); ?></h1>
                                        </div>
                                        <div class="fleft wc100 fb fs14 pl25">
                                            <p id="listprice" class="clrwht"><?php echo '$ ' . number_format($s->list_price);?> | <?php echo strtoupper($s->state) . ' ' . $s->zip_code;?></p>
                                        </div>
                                        <div class="wc100 fb fs12 pl25">
                                            <p class="clrwht">
                                                <a id="beds1" href=""><?php echo strtoupper($s->city);?></a>
                                                <a id="baths1" href=""></a>
                                                <a id="sqft" href=""></a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="fright wc35 h81">
                                        <div class="pending_sale">
                                            <span id="res_status" class="new newtxt mg10 fleft mr6">
                                                
                                            </span>
                                        </div>
                                        <div class="col_btn wc100 fleft">
                                            <div id="learn_morebox" style="" class="learn_morebox">
                                                <a id="moredetails" href="#">
                                                    <img src="images/details.png" />
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- display four   -->
                       	</div>
                    </div>
                    <div class="list_pannel mg20 fleft pt10">
                        <div class="list_pannel_row fleft">
                            <div class="list_pannel_col1 fs18 pl25 mg10 fleft">
                                <h1 class="pl35">See More Listings</h1>
                                <span class="fleft wc6  mg10 ml15"> 
                                    <img src="images/bullet.png" /> 
                                </span>
                                <p class="fs24 txtgray"> 
                                    New Listing Email Alerts Sent To Your Phone 
                                </p>
                                <span class="fleft wc6 mg10 ml15"> 
                                    <img src="images/bullet.png" /> 
                                </span>
                                <p class="fs24 txtgray"> 
                                    Save Your Search Criteria 
                                </p>
                                <span class="fleft wc6  mg10 ml15"> 
                                    <img src="images/bullet.png" /> 
                                </span>
                                <p class="fs24 txtgray"> 
                                    Track Neighborhood Price Trends 
                                </p>
                            </div>
                        </div>
                        <div class="new_ar mg20 fright">
                            <div class="form_table fright">
                                <form action="" method="post">
                                    <div class="form_row wc100 fleft">
                                        <div class="form_col wc100  fleft">
                                            <input class="fleft h30 wc65 wthborder fs10 more" type="text" name="name" id="name" 
                                            placeholder="First Name" />
                                        </div>
                                    </div>
                                    <div class="form_row wc100 fleft">
                                        <div class="form_col wc100 mg10 fleft">
                                            <input class="fleft h30 wc65 wthborder fs10 more" type="text" name="name" id="name" 
                                                   placeholder="Last Name" />
                                        </div>
                                    </div>
                                    <div class="form_row wc100 fleft">
                                        <div class="form_col wc100  mg10 fleft">
                                            <input class="fleft h30 wc65 wthborder fs10 more" type="text" name="name" id="name" 
                                                   placeholder="Email Address" />
                                        </div>
                                    </div>
                                    <div class="form_row wc100 fleft">
                                        <div class="form_col wc100 h30 mg10 fleft">
                                            <input type="submit" value="" id="submit" name="submit" class="fleft h30 wc30 clrwht  fs10  fb" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                   <div style="clear:both;"></div>
                    <div class="testimonial_blog">
                        <div class="new_box mg30">
                            <div class="new_box_inner">
                                <h1>DALLAS URBAN LIVING</h1>
                                <div class="img_area mg10">
                                    <div class="fleft mg10">
                                        <img src="images/box_img1.jpg" />
                                    </div>	
                                    <div class="new_box_para pl10 fleft pt10">
                                        <p>
                                            The DALLAS skyline consist of luxury condos for every taste, budget, and location offering spectacular
                                            panoramic views.
                                        </p>
                                        <span class="pt10 fleft">
                                            <p>Locations include:</p>
                                        </span>
                                        <p><strong>DOWNTOWN</strong></p>
                                        <p><strong>UPTOWN</strong></p>
                                        <p><strong>MIDTOWN (coming soon)</strong></p>
                                        <p><strong>LAS COLINAS</strong></p>
                                    </div>
                                    <span class="view_property fs18 fleft">
                                        <a href="#">
                                            VIEW PROPERTIES
                                        </a>
                                    </span>
                                </div>
                                <h1>NORTH TEXAS SUBURBAN LIVING</h1>
                                <div class="img_area mg10">
                                    <div class="fleft mg10">
                                        <img src="images/box_img2.jpg" />
                                    </div>	
                                    <div class="new_box_para pl10 fleft pt10">
                                        <p>
                                            Dallas is made up of many satellite cites with their own unique characteristics. With home prices
                                            so affordable, millions move to the DFW “Metroplex” every year.
                                        </p>
                                        <span class="pt10 fleft">
                                            <p>Locations include:</p>
                                        </span>
                                        <p>
                                            <strong>
                                                FRISCO
                                            </strong>
                                        </p>
                                        <p>
                                            <strong>
                                                PLANO
                                            </strong>
                                        </p>
                                        <p>
                                            <strong>
                                                MCKINNEY
                                            </strong>
                                        </p>
                                        <p>
                                            <strong>
                                                FAR NORTH DALLAS
                                            </strong>
                                        </p>
                                    </div>
                                    <span class="view_property fs18 fleft">
                                        <a href="#">
                                            VIEW PROPERTIES
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_box">
                            <div class="new_box_inner1">
                                <img src="images/comma_img.png" class="fleft mg10" />
                                <div class="comma_img">
                                    <h1>Testimonials</h1>
                                </div>
                                <div class="small_box_outer">
                                    <!--<div class="up_arrow_outer">
                                        <a id="testhideshow" href="javascript:void(0)">
                                            <img src="images/arrow_up.png" />
                                        </a>
                                    </div>-->
                                    <div id="slideshow">
                                        <div id="slidesContainer">
                                            <div id="testemonails" class="slide">
                                                <div class="small_box1">
                                                    <div class="img_001">
                                                        <img src="images/img_001.jpg" />
                                                    </div>
                                                    <h1>David + Hayrelyn Alban</h1>
                                                </div>
                                                <div class="new_para2">
                                                    <h1>FINANCING EXPERTISE</h1>
                                                    <p>
                                                        "J.R. referred us to a local lender offering a lower interest rate than the financing the builder
                                                        suggested. This will save us about $100 per month on our mortgage payment."
                                                    </p>
                                                    <p>
                                                        December 2013	
                                                    </p>
                                                </div>

                                                <div class="small_box_outer">

                                                    <div class="small_box1">
                                                        <div class="img_001">
                                                            <img src="images/img_001.jpg" />
                                                        </div>
                                                        <h1>David + Hayrelyn Alban</h1>
                                                    </div>
                                                    <div class="new_para2">
                                                        <h1>FINANCING EXPERTISE</h1>
                                                        <p>
                                                            "J.R. referred us to a local lender offering a lower interest rate than the financing the
                                                            builder suggested. This will save us about $100 per month on our mortgage payment."
                                                        </p>
                                                        <p>
                                                            December 2013	
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                            <div id="testemonails1" class="slide">
                                                <div class="small_box1">
                                                    <div class="img_001">
                                                        <img src="images/img_001.jpg" />
                                                    </div>
                                                    <h1>David + Hayrelyn Alban</h1>
                                                </div>
                                                <div class="new_para2">
                                                    <h1>FINANCING EXPERTISE</h1>
                                                    <p>
                                                        "J.R. referred us to a local lender offering a lower interest rate than the financing the builder
                                                        suggested. This will save us about $100 per month on our mortgage payment."
                                                    </p>
                                                    <p>
                                                        January 2014	
                                                    </p>
                                                </div>

                                                <div class="small_box_outer">

                                                    <div class="small_box1">
                                                        <div class="img_001">
                                                            <img src="images/img_001.jpg" />
                                                        </div>
                                                        <h1>David + Hayrelyn Alban</h1>
                                                    </div>
                                                    <div class="new_para2">
                                                        <h1>FINANCING EXPERTISE</h1>
                                                        <p>
                                                            "J.R. referred us to a local lender offering a lower interest rate than the financing the
                                                            builder suggested. This will save us about $100 per month on our mortgage payment."
                                                        </p>
                                                        <p>
                                                            January 2014
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="up_arrow_outer" style="margin-left: 747px; margin-top: -56px;">
                            <a id="testhideshow1" href="javascript:void(0)">
                                <img src="images/arrow_down.png" />
                            </a>
                        </div>-->
                    </div>
                </div>
            </div>
            <div style="clear:both;"></div>
            <div class="footer">
                <div class="footer_outer">
                    <div class="ftr_menu_box fleft">
                        <h1>Dallas modern luxury</h1>
                        <ul class="ftr_nav">
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Preston Hollow
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    University Park
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Highland Park 
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Victory Park
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Northpark
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    M Streets
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Lakewood
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    White Rock Lake
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Greenville
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Dallas Medical District
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Uptown
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Dallas Arts District
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Downtown Dallas
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Kessler Park
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Bishop Arts District
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="ftr_menu_box fleft wc33-3">
                        <h1>N dallas suburbs</h1>
                        <ul class="ftr_nav">
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Far North Dallas
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Plano
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Frisco
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Prosper
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Allen
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    McKinney
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Fairview
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Anna
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Uptown
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Carrollton
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Richardson
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Addison
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="ftr_menu_box fleft wc32-0">
                        <h1>DFW Airport suburbs</h1>
                        <ul class="ftr_nav">
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Lewisville
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Flower Mound
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Grapevine
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Coppell
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Southlake
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    HEB
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Colleyville
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Keller
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    N Richland Hills
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Arlington
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Grand Prairie
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Irving
                                </a>
                            </li>
                            <li class="ftr_nav_styl">
                                <a href="#">
                                    Las Colinas
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="copyright_bg">
                    <div class="ftr_inner maxwc1000"> 
                        <a href="#">MOLINA</a>                      
                        <p>Copyright 2013 &copy; All rights reserved</p>
                        <img src="images/logo_bottom.png" width="138" height="48" />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


