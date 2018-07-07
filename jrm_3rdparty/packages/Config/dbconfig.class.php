<?php

/**
 * @Package  Config\\ DBconfig
 * @author Bugs - Ashtex
 * The DB confiugration file for the   package
 */

namespace  Config;

class  Dbconfig
{
	//exposes private memebers and static getters for the rest of the packages
	//-------------------------------------------------------------------------------
	private static $db_host = 'localhost';
	private static $db_name = 'jrmolina';
	private static $db_user = 'root';
	private static $db_password = 'bugs';
	private static $db_dump = 'dump_empty.sql';
	//-------------------------------------------------------------------------------
	//----------------------NO CODE SHOULD BE CHANGED BELOW THIS LINE-----------------
	//constants to access the assosciated array - should always be used by the rest of the classes
	const DB_HOST = 'DBHOST';
	const DB_NAME = 'DBNAME';
	const DB_USER = 'DBUSER';
	const DB_PASSWORD = 'DBPASS';
	const DB_DUMP = 'DBDUMP';
	//
	
	//Private construction - This class cannot be initiated
	private function __construct() 
	{
		return null;
	}
	private function __clone() 
	{
		return null;
	}
	
	//returns the entire db configuration in associated file
	public static function get_dbconfig()
	{
		try 
		{
			$config = array();
			$config[self::DB_HOST] =  Dbconfig::get_dbhost();
			$config[self::DB_NAME] =  Dbconfig::get_dbname();
			$config[self::DB_USER] =  Dbconfig::get_dbuser();
			$config[self::DB_PASSWORD] =  Dbconfig::get_dbpassword();
			$config[self::DB_DUMP] =  Dbconfig::get_dbdump();
			return $config;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
		
	}
	
	public static function get_dbhost()
	{
		try
		{
			if( ( Dbconfig::$db_host == '') || ( Dbconfig::$db_host == null) )
			{
				throw new  Exception( Constants::DBHOST_NOTAVAILABLE);
			}
			return  Dbconfig::$db_host;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function set_dbhost($db_host)
	{
		try
		{
			if( ($db_host == '') || ($db_host == null) )
			{
				throw new  Exception( Constants::DBHOST_NOTAVAILABLE);
			}
			else
			{
				 Dbconfig::$db_host = $db_host;
			}
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function get_dbname()
	{
		try
		{
			if( ( Dbconfig::$db_name == '') || ( Dbconfig::$db_name == null) )
			{
				throw new  Exception( Constants::DBNAME_NOTAVAILABLE);
			}
			return  Dbconfig::$db_name;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function set_dbname($db_name)
	{
		try
		{
			if( ($db_name == '') || ($db_name == null) )
			{
				throw new  Exception( Constants::DBNAME_NOTAVAILABLE);
			}
			else
			{
				 Dbconfig::$db_name = $db_name;
			}
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function get_dbuser()
	{
		try
		{
			if( ( Dbconfig::$db_user == '') || ( Dbconfig::$db_user == null) )
			{
				throw new  Exception( Constants::DBUSER_NOTAVAILABLE);
			}
			return  Dbconfig::$db_user;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function set_dbuser($db_user)
	{
		try
		{
			if( ($db_user == '') || ($db_user == null) )
			{
				throw new  Exception( Constants::DBUSER_NOTAVAILABLE);
			}
			else
			{
				 Dbconfig::$db_user = $db_user;
			}
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function get_dbpassword()
	{
		try
		{
			if( ( Dbconfig::$db_password == '') || ( Dbconfig::$db_password == null) )
			{
				throw new  Exception( Constants::DBPASSWORD_NOTAVAILABLE);
			}
			return  Dbconfig::$db_password;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function set_dbpassword($db_password)
	{
		try
		{
			if( ($db_password == '') || ($db_password == null) )
			{
				throw new  Exception( Constants::DBPASSWORD_NOTAVAILABLE);
			}
			else
			{
				 Dbconfig::$db_password = $db_password;
			}
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function get_dbdump()
	{
		try
		{
			if( ( Dbconfig::$db_dump == '') || ( Dbconfig::$db_dump == null) )
			{
				throw new  Exception( Constants::DBDUMP_NOTAVAILABLE);
			}
			return  Dbconfig::$db_dump;
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
	
	public static function set_dbdump($db_dump)
	{
		try
		{
			if( ($db_dump == '') || ($db_dump == null) )
			{
				throw new  Exception( Constants::DBDUMP_NOTAVAILABLE);
			}
			else
			{
				 Dbconfig::$db_dump = $db_dump;
			}
		}
		catch ( Exception $e)
		{
			throw $e;
		}
	}
}

?>
