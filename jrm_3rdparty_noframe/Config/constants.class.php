<?php

/**
 * @Package  Config\\ Constants
 * @author Bugs - Ashtex
 * The constant define class for the package
 */

namespace Config;

class Constants {

    //constansts for install utility
    const PACKAGE_NAME = 'Config/dumps';
    const ARG_NAME = 'mysql_root';
    const DB_RE_INSTALL_MSG = 'The database already exists. Please type "yes" to confirm that you want to delete and install it again';
    const DB_RE_INSTALL_GOAHEAD = 'yes';
    const HTML_PATH = '/jrmhtml';
    const ASSETS_PATH = '/assets';
    //pagination for the entire package
    const PAGINATION_COUNT = 20;
    //logging directory
    const LOG_DIR = "/Logs/rocket_logs/"; //The directory will not be created automatically. Please create it manually
    //constants for global settings incase they are missing from the database --- safe fall back
    const GLOBAL_SETTING_ID = 1;
    //the path to the image resources for the products (relative to the packages folder)
    const PRODUCT_IMAGES_PATH = 'Resources/Products';
    //the path to the image resources for the categories (relative to the packages folder)
    const CATEGORY_IMAGES_PATH = 'Resources/Categories';
    //the constant for the CSRF attack
    const CSRF_ATTACK = 'csrf_attack';
    //shopping cart session variable
    const SHOPPING_CART = 'shopping_cart';
    //login system session variable
    const LOGIN_FLAG = 'login_flag';
    const ENABLE_FRAGMENTIFY = 0;
    const ON_SCREEN_DEBUG = 0;
    //-----------------------------------------------------------
    const CSV_FILE = "The argument passed is rejected. Please provide argument as 'csv_file=filename.csv csv_file2=filename2.csv csv_file3=filname3.csv drop_table=0 create_table=0' OR (if drop or create is required) 'csv_file=filename.csv csv_file2=filename2.csv csv_file3=filname3.csv drop_table=1 create_table=1'";
    const UNKNOWN_ERROR = "The error source cannot be identified";
    const DBHOST_NOTAVAILABLE = "The database host is not defined";
    const DBNAME_NOTAVAILABLE = "The database name is not defined";
    const DBUSER_NOTAVAILABLE = "The database user is not defined";
    const DBPASSWORD_NOTAVAILABLE = "The database password is not defined";
    const DBDUMP_NOTAVAILABLE = "The database dump file is not available";
    const DB_USERPASSWORD_NOTAVAILABLE = "The provided password is either empty or null";
    const DBCONNECTION_NOTAVAILABLE = "Connection to the Database failed";
    const DBDELETE_ERROR = "Unable to delete the specified database";
    const DBCREATE_ERROR = "Unable to create the specified database";
    const DBSELECT_ERROR = "Unable to select the specified database";
    const DUMP_FILEOPEN_ERROR = "Unable to open the sql dump file";
    const DUMP_CORRUPTED = "The dump file is corrupted. Unable to load to load the dump";
    const ARG_NOTAVAILABLE = "The argument passed is rejected. Please provide argument as 'mysql_root=MYROOTPASS'";
    const ALIAS_NOTAVAILABLE = "Alias cannot be null or empty";
    const DBINSERT_ERROR = "Unable to insert data into the database";
    //const SET_TIMEZONE = "Asia/Shanghai";
    const TWITTER = 'http://twitter.com';
    const FACEBOOK = 'http://facebook.com';
    const GOOGLE = 'http://google.com';
    const LINKEDIN = 'http://linkedin.com';
    const YOUTUBE = 'http://youtube.com';
    const DIR_NAME = '/jrm';
    const DATA_PATH = "jrmcsv";
    const DATA_FILE = "jrmcsv.csv";
    const DEFAULT_IMAGE = "/jrmdefaultimage/default.jpg";

}

?>
