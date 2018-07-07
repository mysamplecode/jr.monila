<?php
use Config\Central;
use Config\Constants;

class JRMIndex extends RSBase
{
    private $file = 'index.html';
    private $sql;
    private $citiesarr = array();

    public function __construct()
    {
        try
        {
            parent::__construct();
            $this->template = $this->central->load_normal($this->file);
        }
        catch(Exception $e)
        {
            $e->getMessage();
        }
    }

    public function like_query($cond, $colname, $arr = array())
    {
        $where = '';
        foreach($arr as $a)
        {
            $where .="AND {$colname} {$cond} ('%{$a}%') ";
        }
        return $where;
    }

    public function set_city()
    {
        try
        {
            $sql_city = PluSQL::from($this->profile)->res_prop->select("*")->where("property_category ='RES'")->groupBy("city")->run()->res_prop;
            $this->citiesarr[""] = "Select City";
            foreach($sql_city as $cities)
            {
                $this->citiesarr[$cities->city] = $cities->city;
            }
            Central::repeat_select_options($this->template, '#city', $this->citiesarr);
        }
        catch(Exception $e)
        {
            $e->getMessage();
        }
    }

    public function thumbview_query($where, $orderby, $limit)
    {
        try
        {
            ob_start();
            echo Plusql::from($this->profile)->img_res_prop->select("res_prop_id")->where("image_path Like 'HR%'");
            $tablematch = ob_get_contents();
            ob_end_clean();
            $str = "res_prop_id IN( $tablematch )";
            ob_get_contents();
            $this->sql = PluSQL::from($this->profile)->res_prop->select("*")->where("property_category = 'RES' AND photo_count > 4 AND status NOT IN ('Pending','pnd') {$where}")->orderby("cast(list_price as unsigned)".$orderby)->limit($limit)->run()->res_prop;
        }
        catch(Exception $e)
        {
            try
            {
                ob_start();
                echo Plusql::from($this->profile)->img_res_prop->select("res_prop_id")->where("image_path Like 'HR%'");
                $tablematch = ob_get_contents();
                ob_end_clean();
                $str = "res_prop_id IN( $tablematch )";
                ob_get_contents();
                $this->sql = PluSQL::from($this->profile)->res_prop->select("*")->where("property_category = 'RES' AND photo_count > 4 AND status NOT IN ('Pending','pnd')")->orderby("cast(list_price as unsigned)".$orderby)->limit($limit)->run()->res_prop;
            }
            catch(Exception $e)
            {
                
            }
        }
        return $this->sql;
    }

    public function dallas_values()
    {

        try
        {
            $sq = $this->like_query('LIKE', 'zip_code', array('75201', '75202', '75207', '75219', '75204', '75208', '75226', '75039'));
            $this->thumbview_query($sq, "DESC", "0, 3");
            $this->getimage_values($this->sql, '#moredetails', '#thumbview', '#address1', '#address2', '#res_status', '#learn_morebox', '#listprice', '#beds1', '#baths1', '#sqft', 'main_img', '#last_image');
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function suburbs_values()
    {
        try
        {
            $sq = $this->like_query('NOT LIKE', 'zip_code', array('75201', '75202', '75207', '75219', '75204', '75208', '75226', '75039'));
            $this->thumbview_query($sq, "DESC", "3, 3");
            $this->getimage_values($this->sql, '#moredetails1', '#thumbview1', '#address11', '#address21', '#res_status1', '#learn_morebox', '#listprice1', '#beds11', '#baths11', '#sqft1', 'main_img1', '#last_image1');
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function newlisting_values()
    {
        try
        {
            $this->thumbview_query("", "DESC", "6, 3");
            $this->getimage_values($this->sql, '#moredetails2', '#thumbview12', '#address112', '#address212', '#res_status12', '#learn_morebox', '#listprice12', '#beds112', '#baths112', '#sqft12', 'main_img12', '#last_image12');
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function recently_reduced_values()
    {

        try
        {
            $this->thumbview_query("", "DESC", "9, 3");
            $this->getimage_values($this->sql, '#moredetails3', '#thumbview123', '#address1123', '#address2123', '#res_status123', '#learn_morebox', '#listprice123', '#beds1123', '#baths1123', '#sqft123', 'main_img123', '#last_image123');
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function update_main_contents()
    {
        $this->set_sliders();
        $this->set_city();
        $this->dallas_values();
        $this->suburbs_values();
        $this->newlisting_values();
        $this->recently_reduced_values();
    }

}
?>
    
