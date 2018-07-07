<?php
use Config\Central;

class JRMGetImage implements RocketSled\Runnable
{
    public $profile = 'default';
    public $defaultimage = 'default.jpg';

    public function get_image()
    {
        Central::instance()->set_alias_connection($this->profile);
        try
        {
            ob_start();
            echo Plusql::from($this->profile)->img_res_prop->select("res_prop_id");
            $tablematch = ob_get_contents();
            ob_end_clean();
            $str = "res_prop_id NOT IN( $tablematch )";
            $sql = PluSQL::from($this->profile)->res_prop->select("*")->where($str)->orderby("res_prop_id")->run()->res_prop;
            foreach($sql as $s)
            {
                $id = $s->res_prop_id;
                $uid = $s->uid;
                $photocount = $s->photo_count;
                $this->image_url($uid, $photocount, "HR", $id);
            }
        }
        catch(EmptySetException $e)
        {
            echo $e->getMessage();
        }
    }

    public function while_loop($uid, $photocount, $resolution, $id, $filepath = NULL)
    {
        $uids = substr($uid, -2);
        while(1)
        {
            //url for image
            $url4img = "http://ntreispictures.marketlinx.com/MediaDisplay/$uids/$resolution$uid-$i.jpg";
            if($filepath != NULL)
            {
                $uids = substr($filepath, -8, 2);
                $url4img = "http://ntreispictures.marketlinx.com/MediaDisplay/$uids/$filepath";
            }
            //echo $url4img . PHP_EOL;
            $html_page = Central::curl_call_with_header($url4img);
            if(strpos($html_page, '200 OK') !== false)
            {
                $html_page4image = Central::curl_call_without_header($url4img);
                file_put_contents($filepath, $html_page4image);
                echo "Image Download".PHP_EOL;
                $primarypic = 0;
                try
                {
                    $filename_check = substr($filename, 2);
                    //echo $filename_check;
                    $media = Plusql::from($this->profile)->media->select("*")->where("mediasource = '{$filename_check}'")->run()->media;
                    $primarypic = 1;
                    echo "Primary Pic $filename";
                }
                catch(EmptySetException $e)
                {
                    
                }
                try
                {
                    PluSQL::into($this->profile)->img_res_prop(array('res_prop_id' => $id, 'image_path' => $filename, 'primary_pic' => $primarypic))->insert();
                    echo "Image Saved".PHP_EOL;
                }
                catch(Exception $e)
                {
                    
                }
                break;
            }
            else
            {
                //      sleep(5);
                if($count > 5)
                {
                    PluSQL::into($this->profile)->img_res_prop(array('res_prop_id' => $id, 'image_path' => $this->defaultimage))->insert();
                    echo "Default image saved".PHP_EOL;
                    break;
                }
                $count++;
            }
        }
    }

    public function img_dwnld($filename)
    {
        $uids = substr($filename, -8, 2);
        $url4img = "http://ntreispictures.marketlinx.com/MediaDisplay/$uids/$filename";
        $html_page = Central::curl_call_with_header($url4img);
        if(strpos($html_page, '200 OK') !== false)
        {
            $filepath = __DIR__."/../jrmimages/".$filename;
            $html_page4image = Central::curl_call_without_header($url4img);
            file_put_contents($filepath, $html_page4image);
            $ftemp = Plusql::from($this->profile)->img_res_prop->select("*")->where("image_path = '$filename'")->run()->img_res_prop->img_res_prop_id;
            PluSQL::on($this->profile)->img_res_prop(array('image_path' => $filename))->where("img_res_prop_id = $ftemp")->update();
        }
        else
        {
            $ftemp = Plusql::from($this->profile)->img_res_prop->select("*")->where("image_path = '$filename'")->run()->img_res_prop->img_res_prop_id;
            PluSQL::on($this->profile)->img_res_prop(array('image_path' => $this->defaultimage))->where("img_res_prop_id = $ftemp")->update();
        }
    }

    public function img_ins($id, $filename)
    {
        $primarypic = 0;
        try
        {
            $filename_check = substr($filename, 2);
            $media = Plusql::from($this->profile)->media->select("*")->where("mediasource = '{$filename_check}'")->run()->media;
            $primarypic = 1;
        }
        catch(EmptySetException $e)
        {
            
        }
        try
        {
            PluSQL::into($this->profile)->img_res_prop(array('res_prop_id' => $id, 'image_path' => $filename, 'primary_pic' => $primarypic))->insert();
        }
        catch(Exception $e)
        {
            
        }
    }

    public function prop_check($uid, $photocount, $resolution, $id)
    {

        for($i = 1; $i <= $photocount; $i++)
        {
            $filename = $resolution.$uid.'-'.$i.'.jpg';
            try
            {
                $chk_img = Plusql::from($this->profile)->img_res_prop->select("*")->where("image_path = '{$filename}' and res_prop_id = ".$id)->run()->img_res_prop;
            }
            catch(EmptySetException $e)
            {
                $this->img_ins($id, $filename);
            }
        }
    }


    public function image_url($uid, $photocount, $resolution, $id)
    {
        if($photocount != 0)
        {
            $this->max_img($uid, $photocount, $resolution, $id);
        }
        else
        {
            PluSQL::into($this->profile)->img_res_prop(array('res_prop_id' => $id, 'image_path' => $this->defaultimage))->insert();
            echo "Default image saved because photocount is 0.".PHP_EOL;
        }
    }

    public function run()
    {
        $this->get_image();
    }

}

?>
