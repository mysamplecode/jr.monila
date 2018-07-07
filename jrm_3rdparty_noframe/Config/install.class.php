<?php
/**
 * @Package Config\\Install
 * @author Bugs - Ashtex
 * The install utility - installs the dump   
 */

namespace Config;
use Args;
	 
class Install implements \rocketsled\Runnable
{

	public function run() 
	{
		try
		{
			$temp = Args::get(Constants::ARG_NAME,Args::argv);
			if(
				($temp === null) ||
				($temp == false)
			)
			{
				throw new \Exception(Constants::ARG_NOTAVAILABLE);
			}
			else
			{
				$central = Central::instance();
                         //       $central->cron_update();
				$central->install($temp);
			}
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
			exit(1);
		}
	}
}