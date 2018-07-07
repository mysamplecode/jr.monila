<?php

if (file_exists(PACKAGES_DIR . '/SimpleHtmlDom/simple_html_dom.php'))
    require_once(PACKAGES_DIR . '/SimpleHtmlDom/simple_html_dom.php');

if (file_exists(PACKAGES_DIR . '/php-crontab-manager/src/CrontabManager.php'))
    require_once(PACKAGES_DIR . '/php-crontab-manager/src/CrontabManager.php');

if (file_exists(PACKAGES_DIR . '/Excel/Classes/PHPExcel.php'))
    require_once(PACKAGES_DIR . '/Excel/Classes/PHPExcel.php');

if (file_exists(PACKAGES_DIR . '/tcpdf/tcpdf.php'))
    require_once(PACKAGES_DIR . '/tcpdf/tcpdf.php');
?>
