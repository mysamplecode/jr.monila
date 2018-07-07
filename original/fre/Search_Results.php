<?php
if (is_numeric($_REQUEST['pg'])) {
	$pgnum = ((int) $_REQUEST['pg']);
} else {
    $pgnum = 0;
    $errorMessage = "Invalid value for page number";
}

$startnum = 1;
$nextpg = ($pgnum + 1);
$prevpg = ($pgnum-1);

if ($pgnum >= 0) {
	$offset = ($pgnum * 20);
} else {
    $offset = 0;
}
$limit = 20; 

$Property_Type=$_REQUEST['property_type'];
$City=$_REQUEST['city'];
$Beds=$_REQUEST['beds'];
$Baths=$_REQUEST['baths'];
$Lowest_Price=$_REQUEST['lowest_price'];
$Highest_Price=$_REQUEST['highest_price'];
$MLS=$_REQUEST['mls_number'];
$CityA=$_REQUEST['citya'];
$AddressA=$_REQUEST['address'];
$Zip_codeA=$_REQUEST['zip_code'];
$SubdivisionA=$_REQUEST['subdivision'];
$GarageA=$_REQUEST['garage'];
$StoriesA=$_REQUEST['stories'];
$FireplacesA=$_REQUEST['fireplaces'];
$Yard_sizeA=$_REQUEST['yard_size'];
$CitiesA=$_REQUEST['cities'];
$AreasA=$_REQUEST['areas'];
$CountiesA=$_REQUEST['counties'];
$School_districtA=$_REQUEST['school_district'];
$School_type_elementaryA=$_REQUEST['school_type'];
$School_type_middleA=$_REQUEST['school_type'];
$School_type_highA=$_REQUEST['school_type'];
$School_nameA=$_REQUEST['school_name'];
$Guest_quartersA=$_REQUEST['property'];
$High_riseA=$_REQUEST['property'];
$Loft_A=$_REQUEST['property'];
$BalconyA=$_REQUEST['property'];
$LibraryA=$_REQUEST['property'];
$MediaA=$_REQUEST['property'];
$Gated_communityA=$_REQUEST['location'];
$Golf_course_communityA=$_REQUEST['location'];
$Golf_course_lotA=$_REQUEST['location'];
$Lake_front_lotA=$_REQUEST['location'];
$Lake_viewA=$_REQUEST['location'];
$Handicap_amenitiesA=$_REQUEST['location'];
$Zero_lot_lineA=$_REQUEST['location'];
$Horses_allowedA=$_REQUEST['location'];
$Fence_woodA=$_REQUEST['fence'];
$Fence_ironA=$_REQUEST['fence'];
$Fence_brickA=$_REQUEST['fence'];
$Fence_rockA=$_REQUEST['fence'];
$Fence_automatic_gateA=$_REQUEST['fence'];
$Fence_noneA=$_REQUEST['fence'];
$Special_requirementsA=$_REQUEST['special_requirements'];
$Properties_with_photosA=$_REQUEST['properties_with'];
$Single_detachedA=$_REQUEST['property_types'];
$MultiA=$_REQUEST['property_types'];
$TownhomeA=$_REQUEST['property_types'];
$CondoA=$_REQUEST['property_types'];
$Half_duplexA=$_REQUEST['property_types'];
$LeaseA=$_REQUEST['property_types'];
$Joseph_molinaA=$_REQUEST['only'];
$Open_housesA=$_REQUEST['only'];

include("db.php");

$rets_login_url = "http://ntreisrets.mls.ntreis.net:80/rets/login";
$rets_username = "j_Kp$06$";
$rets_password = "2$@P866";
$rets_agent = "JKP";

require_once('phRets.php');
$rets = new phRets;
$connect = $rets->Connect($rets_login_url, $rets_username, $rets_password);
if (!$connect) {
        print_r($rets->Error());
}

if($GarageA == NULL) $GarageA = 0;
if($StoriesA == NULL) $StoriesA = 0;
if($FireplacesA == NULL) $FireplacesA = 0;

if(isset($_REQUEST['sort'])){
	$sort=$_REQUEST['sort'];
} else {
	$sort = "MODIFIED ASC";
}

switch($_POST['sort_by']){
	case "none":
		$sort = "MODIFIED ASC";
		break;	
	case "price-high-to-low":
		$sort = "LISTPRICE DESC";
		break;
	case "price-low-to-high":
		$sort = "LISTPRICE ASC";
		break;
	case "sqft-low-to-high":
		$sort = "SQFTTOTAL ASC";
		break;
	case "sqft-high-to-low":
		$sort = "SQFTTOTAL DESC";
		break;
	case "street-name-alpha":
		$sort = "STREETNAME ASC";
		break;
	case "zip-code-numeric":
		$sort = "ZIPCODE ASC";
		break;
}



if($Highest_Price==0 || $Highest_Price=="no_limit"){
	if($Highest_Price=="no_limit") $Highest_Price="10000000";
	$Any= ">=";
} else {
	$Any= "<=";
}
		
	
if($City==0||$City==NULL) {
		$City=0;
		$Any_City= ">";
} else {
	$Any_City= "LIKE";
}

if($MLS==NULL){
		$MLSNUM= NULL;
	} else {
		$MLSNUM= $MLS;
}

if($Zip_codeA==0||$Zip_codeA==NULL){
		$Zip_codeA=0;
		$Any_Zip= ">";
} else {
	$Any_Zip="=";
}

//$CitiesA	=	"'".implode("'| '",$CitiesA)."'";
//echo $CitiesA;
//AND CITY	IN	({$CitiesA})
//$AreasA
//$CountiesA

if($Yard_sizeA == NULL||$Yard_sizeA == 0){
	$Yard = "IS NOT NULL";
} else {
	$Yard = "LIKE '{$Yard_sizeA}'";
}

$E = $School_type_elementaryA['elementary'];
$M = $School_type_middleA['middle'];
$H = $School_type_highA['high'];

if ($E == "elementary"){
	$E = "= 'E'";	
} else {
	$E = "IS NOT NULL";
}

if ($M == "middle"){
	$M = "= 'M'";	
} else {
	$M = "IS NOT NULL";
}

if ($H == "high"){
	$H = "= 'H'";	
} else {
	$H = "IS NOT NULL";
}

if ($Guest_quartersA['guest-quarters'] == "guest-quarters"){
	$Guest_quartersA = "LIKE 'EXFGST-QUA'";	
} else {
	$Guest_quartersA = "IS NOT NULL";	
}

if ($High_riseA['high-rise-condominium'] == "high-rise-condominium"){
	$High_riseA = "LIKE 'HOUHI-RISE'";	
} else {
	$High_riseA = "IS NOT NULL";	
}

if ($Loft_A['loft'] == "loft"){
	$Loft_A = "LIKE 'INFLOFT'";	
} else {
	$Loft_A = "IS NOT NULL";	
}

if ($BalconyA['balcony'] == "balcony"){
	$BalconyA = "LIKE 'EXFBALCONY'";	
} else {
	$BalconyA = "IS NOT NULL";	
}

if ($LibraryA['library-or-study'] == "library-or-study"){
	$LibraryA = "LIKE 'SPRLIBR+ST'";	
} else {
	$LibraryA = "IS NOT NULL";	
}

if ($MediaA['media-room'] == "media-room"){
	$MediaA = "LIKE 'SPRMEDIA'";	
} else {
	$MediaA = "IS NOT NULL";	
}

if ($Gated_communityA['gated-community'] == "gated-community"){
	$Gated_communityA = "LIKE 'COMGATED'";	
} else {
	$Gated_communityA = "IS NOT NULL";	
}


if ($Golf_course_communityA['golf-course-community'] == "golf-course-community"){
	$Golf_course_communityA = "LIKE 'COMGOLF'";	
} else {
	$Golf_course_communityA = "IS NOT NULL";	
}

if ($Golf_course_lotA['golf-course-lot'] == "golf-course-lot"){
	$Golf_course_lotA = "LIKE 'COMGOLF'";	
} else {
	$Golf_course_lotA = "IS NOT NULL";	
}

if ($Lake_front_lotA['lake-front-lot'] == "lake-front-lot"){
	$Lake_front_lotA = "LIKE 'COMLAKE+PN'";	
} else {
	$Lake_front_lotA = "IS NOT NULL";	
}

if ($Properties_with_photosA['properties_with'] == "properties_with"){
	$Properties_with_photosA = "> 0";	
} else {
	$Properties_with_photosA = "IS NOT NULL";	
}

if ($Lake_viewA['lake-view'] == "lake-view"){
	$Lake_viewA = "LIKE 'COMLAKE+PN'";	
} else {
	$Lake_viewA = "IS NOT NULL";	
}

if(strlen($CitiesA[0])>2){
	$CitiesA0 = "AND CITY LIKE '{$CitiesA[0]}'";
} else { $CitiesA0 = NULL; }
if(strlen($CitiesA[1])>2){
	$CitiesA1 = "OR CITY LIKE '{$CitiesA[1]}'";
} else { $CitiesA1 = NULL; }
if(strlen($CitiesA[2])>2){
	$CitiesA2 = "OR CITY LIKE '{$CitiesA[2]}'";
} else { $CitiesA2 = NULL; }
if(strlen($CitiesA[3])>2){
	$CitiesA3 = "OR CITY LIKE '{$CitiesA[3]}'";
} else { $CitiesA3 = NULL; }
if(strlen($CitiesA[4])>2){
	$CitiesA4 = "OR CITY LIKE '{$CitiesA[4]}'";
} else { $CitiesA4 = NULL; }
if(strlen($CitiesA[5])>2){
	$CitiesA5 = "OR CITY LIKE '{$CitiesA[5]}'";
} else { $CitiesA5 = NULL; }
if(strlen($CitiesA[6])>2){
	$CitiesA6 = "OR CITY LIKE '{$CitiesA[6]}'";
} else { $CitiesA6 = NULL; }
if(strlen($CitiesA[7])>2){
	$CitiesA7 = "OR CITY LIKE '{$CitiesA[7]}'";
} else { $CitiesA7 = NULL; }
if(strlen($CitiesA[8])>2){
	$CitiesA8 = "OR CITY LIKE '{$CitiesA[8]}'";
} else { $CitiesA8 = NULL; }
if(strlen($CitiesA[9])>2){
	$CitiesA9 = "OR CITY LIKE '{$CitiesA[9]}'";
} else { $CitiesA9 = NULL; }
if(strlen($CitiesA[10])>2){
	$CitiesA10 = "OR CITY LIKE '{$CitiesA[10]}'";
} else { $CitiesA10 = NULL; }


if(is_null($AreasA[0])){
	$AreasA0 = NULL;
} else { $AreasA0 = "AND AREA = {$AreasA[0]}";}
if(is_null($AreasA[1])){
	$AreasA1 = NULL;
} else { $AreasA1 = "OR AREA = {$AreasA[1]}";}
if(is_null($AreasA[2])){
	$AreasA2 = NULL;
} else { $AreasA2 = "OR AREA = '{$AreasA[2]}'";}
if(is_null($AreasA[3])){
	$AreasA3 = NULL;
} else { $AreasA3 = "OR AREA = '{$AreasA[3]}'";}
if(is_null($AreasA[4])){
	$AreasA4 = NULL;
} else { $AreasA4 = "OR AREA = '{$AreasA[4]}'";}
if(is_null($AreasA[5])){
	$AreasA5 = NULL;
} else { $AreasA5 = "OR AREA = '{$AreasA[5]}'";}
if(is_null($AreasA[6])){
	$AreasA6 = NULL;
} else { $AreasA6 = "OR AREA = '{$AreasA[6]}'";}
if(is_null($AreasA[7])){
	$AreasA7 = NULL;
} else { $AreasA7 = "OR AREA = '{$AreasA[7]}'";}
if(is_null($AreasA[8])){
	$AreasA8 = NULL;
} else { $AreasA8 = "OR AREA = '{$AreasA[8]}'";}
if(is_null($AreasA[9])){
	$AreasA9 = NULL;
} else { $AreasA9 = "OR AREA = '{$AreasA[9]}'";}
if(is_null($AreasA[10])){
	$AreasA10 = NULL;
} else { $AreasA10 = "OR AREA = '{$AreasA[10]}'";}




if(strlen($CountiesA[0])>2){
	$CountiesA0 = "AND COUNTY LIKE '{$CountiesA[0]}'";
} else { $CountiesA0 = NULL; }
if(strlen($CountiesA[1])>2){
	$CountiesA1 = "OR COUNTY LIKE '{$CountiesA[1]}'";
} else { $CountiesA1 = NULL; }
if(strlen($CountiesA[2])>2){
	$CountiesA2 = "OR COUNTY LIKE '{$CountiesA[2]}'";
} else { $CountiesA2 = NULL; }
if(strlen($CountiesA[3])>2){
	$CountiesA3 = "OR COUNTY LIKE '{$CountiesA[3]}'";
} else { $CountiesA3 = NULL; }
if(strlen($CountiesA[4])>2){
	$CountiesA4 = "OR COUNTY LIKE '{$CountiesA[4]}'";
} else { $CountiesA4 = NULL; }
if(strlen($CountiesA[5])>2){
	$CountiesA5 = "OR COUNTY LIKE '{$CountiesA[5]}'";
} else { $CountiesA5 = NULL; }
if(strlen($CountiesA[6])>2){
	$CountiesA6 = "OR COUNTY LIKE '{$CountiesA[6]}'";
} else { $CountiesA6 = NULL; }
if(strlen($CountiesA[7])>2){
	$CountiesA7 = "OR COUNTY LIKE '{$CountiesA[7]}'";
} else { $CountiesA7 = NULL; }
if(strlen($CountiesA[8])>2){
	$CountiesA8 = "OR COUNTY LIKE '{$CountiesA[8]}'";
} else { $CountiesA8 = NULL; }
if(strlen($CountiesA[9])>2){
	$CountiesA9 = "OR COUNTY LIKE '{$CountiesA[9]}'";
} else { $CountiesA9 = NULL; }
if(strlen($CountiesA[10])>2){
	$CountiesA10 = "OR COUNTY LIKE '{$CountiesA[10]}'";
} else { $CountiesA10 = NULL; }




echo $Lease;
if($Property_Type=="LSE"){
	$SEARCH="WHERE FORLEASE LIKE 'Y'
	  		   AND	AREA {$Any_City} {$City}
			   AND	BEDS >={$Beds}
			   AND	BATHSTOTAL >={$Baths}
			   AND	LISTPRICE >={$Lowest_Price}
			   AND	LISTPRICE {$Any} {$Highest_Price}";
} elseif($MLSNUM != NULL) {
	$SEARCH = "WHERE MLSNUM = {$MLSNUM}";
} else { 
	$SEARCH = "WHERE PROPSUBTYPEDISPLAY LIKE '%{$Property_Type}%'
				AND	AREA {$Any_City} {$City}
				AND	BEDS >={$Beds}
				AND	BATHSTOTAL >={$Baths}
				AND	LISTPRICE >={$Lowest_Price}
				AND	LISTPRICE {$Any} {$Highest_Price}
				AND	CITY LIKE '%{$CityA}%'
				AND STREETNAME LIKE '%{$AddressA}%'
				AND ZIPCODE {$Any_Zip} '{$Zip_codeA}'
				AND SUBDIVISION LIKE '%{$SubdivisionA}%'
				AND GARAGECAP	>=	{$GarageA}
				AND STORIES		>=	{$StoriesA}
				AND	FIREPLACES	>=	{$FireplacesA}
				AND LOTSIZE		{$Yard}
				AND SCHOOLDISTRICT LIKE '%{$School_districtA}%'
				AND SCHOOLNAME1 LIKE '%{$School_nameA}%'
				AND SCHOOLNAME2 LIKE '%{$School_nameA}%'
				AND SCHOOLNAME3 LIKE '%{$School_nameA}%'
				AND SCHOOLTYPE1 {$E}
				AND SCHOOLTYPE2 {$M}
				AND SCHOOLTYPE3 {$H}
				AND EXTERIOR 	{$Guest_quartersA}
				AND HOUSINGTYPE {$High_riseA}
				AND INTERIOR	{$Loft_A}
				AND EXTERIOR	{$BalconyA}
				AND ROOMOTHER	{$LibraryA}
				AND ROOMOTHER	{$MediaA}
				AND COMMONFEATURES	{$Gated_communityA}
				AND COMMONFEATURES	{$Golf_course_communityA}
				AND COMMONFEATURES	{$Golf_course_lotA}
				AND COMMONFEATURES	{$Lake_front_lotA}
				AND COMMONFEATURES	{$Lake_viewA}
				{$CitiesA0}
				{$CitiesA1}
				{$CitiesA2}
				{$CitiesA3}
				{$CitiesA4}
				{$CitiesA5}
				{$CitiesA6}
				{$CitiesA7}
				{$CitiesA8}
				{$CitiesA9}
				{$CitiesA10}
				{$AreasA0}
				{$AreasA1}
				{$AreasA2}
				{$AreasA3}
				{$AreasA4}
				{$AreasA5}
				{$AreasA6}
				{$AreasA7}
				{$AreasA8}
				{$AreasA9}
				{$AreasA10}
				{$CountiesA0}
				{$CountiesA1}
				{$CountiesA2}
				{$CountiesA3}
				{$CountiesA4}
				{$CountiesA5}
				{$CountiesA6}
				{$CountiesA7}
				{$CountiesA8}
				{$CountiesA9}
				{$CountiesA10}
				AND PHOTOCOUNT	{$Properties_with_photosA}";}
	
$result = mysql_query("SELECT * FROM residential " . $SEARCH . " ORDER BY {$sort} LIMIT {$offset}, {$limit}") or die(mysql_error());

/*
mysql_query("SELECT SQL_CALC_FOUND_ROWS * FROM residential " . $SEARCH . " ORDER BY {$sort} LIMIT {$offset}, {$limit}");
$total_rows		=	mysql_query("SELECT FOUND_ROWS()");
$total_found	= 	mysql_fetch_array($total_rows);
*/

$total_found = mysql_num_rows($result);

$pages_count= $total_found / $limit;
$num_pages=intval($pages_count);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>JR Molina</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png"/>
	<link charset="utf-8" type="text/css" rel="stylesheet" media="all" href="results.css" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	
	<link href="http://css.friscohomesearchtx.com/themes/default/css/min/webcapture.css?aug2013b-tsb.2.0" media="screen" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="http://js.friscohomesearchtx.com/js/min/jquery/jquery-1.4.2.min.js?aug2013b-tsb.2.0"></script>	
</head>
<body>
	<center>
	<table align="center">
		<tr>
			<td valign="top">
				<a href="http://friscorealestatesearchtx.com">
				<img border="0" src="http://jrmolina.com/small%20logo%20jrm.png" alt="Dallas Real Estate Search"></a>
				<BR><BR>
				<div class="view-listingsearch-webcaptureiframemediumrectangle webcaptureiframe">
					<div class="medRectangleBackground">
						<div class="medRectangleWidgetContent">
							<form id="searchHomesForm" class="check-form" action="Search_Results.php" target="_top" method="post">
							<input type="hidden" name="pg" value="0" />
								<div id="mainForm">
									<table>
									<tbody><tr>
										<td><label id="city">Area:</label></td>
										<td colspan="3">
											<select id="areaSelect" name="areas">
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23524') $vSelected = ' SELECTED ';?>
												<option value="23524" <?php echo $vSelected; ?>> PLANO</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23498') $vSelected = ' SELECTED ';?>
												<option value="23498" <?php echo $vSelected; ?>>CASTLE_HILLS</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23575,23576,23625') $vSelected = ' SELECTED ';?>
												<option value="23575,23576,23625" <?php echo $vSelected; ?>>DOWNTOWN</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23484,23485') $vSelected = ' SELECTED ';?>
												<option value="23484,23485" <?php echo $vSelected; ?>>FRISCO</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23583,23596') $vSelected = ' SELECTED ';?>
												<option value="23583,23596" <?php echo $vSelected; ?>>HIGHLAND PARK</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23580,23587') $vSelected = ' SELECTED ';?>
												<option value="23580,23587" <?php echo $vSelected; ?>>M STREETS</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23593,23596,23600,23601,23614') $vSelected = ' SELECTED ';?>
												<option value="23593,23596,23600,23601,23614" <?php echo $vSelected; ?>>PRESTON HOLLOW</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23902') $vSelected = ' SELECTED ';?>
												<option value="23902" <?php echo $vSelected; ?>>SOUTHLAKE</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23596') $vSelected = ' SELECTED ';?>
												<option value="23596" <?php echo $vSelected; ?>>UNIVERSITY PARK</option>
												<?php $vSelected=''; if ($_REQUEST["areas"] == '23592') $vSelected = ' SELECTED ';?>
												<option value="23592" <?php echo $vSelected; ?>>UPTOWN</option>
											</select>
										</td>
									</tr>
									<tr>
										<td><label id="property_type">Type:</label></td>
										<td colspan="3">
											<select id="typeSelect" name="propertytype">
												<option <?php echo $vSelected; ?> value="" selected="selected">All Types</option>
												<?php $vSelected=''; if ($_REQUEST["propertytype"] == 'SINGLE') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="SINGLE">Single Family</option>
												<?php $vSelected=''; if ($_REQUEST["propertytype"] == 'LAND') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="LAND">Lot/Land/Acreage</option>
												<?php $vSelected=''; if ($_REQUEST["propertytype"] == 'FARM') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="FARM">Farms/Ranch</option>
												<?php $vSelected=''; if ($_REQUEST["propertytype"] == 'RENTAL') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="RENTAL">Rental Properties</option>
											</select>
										</td>
									</tr>
									<tr>
										<td><label id="priceLabel">Price:</label></td>
										<td>
											<select id="lowest_price" name="lowest_price" style="width: 84px;">
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '0') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="0" selected="selected">&lt; 100k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '100000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="100000">100k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '150000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="150000">150k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '200000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="200000">200k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '250000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="250000">250k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '350000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="350000">350k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '450000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="450000">450k</option>
												<?php $vSelected=''; if ($_REQUEST["lowest_price"] == '500000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="500000">500k+</option>
											</select>
										</td>
										<td class="toLabel"><span>to</span></td>
										<td>
											<select id="highest_price" name="highest_price" style="width: 84px;">
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '150000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="150000">150k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '200000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="200000">200k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '250000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="250000">250k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '350000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="350000">350k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '450000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="450000">450k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == '500000') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="500000">500k</option>
												<?php $vSelected=''; if ($_REQUEST["highest_price"] == 'no_limit') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="no_limit">&gt; 500k</option>
											</select>
										</td>
										
									</tr>
									<tr>
										<td><label id="beds">Beds:</label></td>
										<td colspan="3">
											<select id="beds" name="beds">
												<?php $vSelected=''; if ($_REQUEST["beds"] == '0') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="0" selected="selected">Any</option>
												<?php $vSelected=''; if ($_REQUEST["beds"] == '1') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="1">1+</option>
												<?php $vSelected=''; if ($_REQUEST["beds"] == '2') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="2">2+</option>
												<?php $vSelected=''; if ($_REQUEST["beds"] == '3') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="3">3+</option>
												<?php $vSelected=''; if ($_REQUEST["beds"] == '4') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="4">4+</option>
												<?php $vSelected=''; if ($_REQUEST["beds"] == '5') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="5">5+</option>
											</select>
										</td>
									</tr>
									<tr>
										<td><label id="baths">Baths:</label></td>
										<td colspan="3">
											<select id="baths" name="baths">
												<?php $vSelected=''; if ($_REQUEST["baths"] == '0') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="0" selected="selected">Any</option>
												<?php $vSelected=''; if ($_REQUEST["baths"] == '1') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="1">1+</option>
												<?php $vSelected=''; if ($_REQUEST["baths"] == '2') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="2">2+</option>
												<?php $vSelected=''; if ($_REQUEST["baths"] == '3') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="3">3+</option>
												<?php $vSelected=''; if ($_REQUEST["baths"] == '4') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="4">4+</option>
												<?php $vSelected=''; if ($_REQUEST["baths"] == '5') $vSelected = ' SELECTED ';?>
												<option <?php echo $vSelected; ?> value="5">5+</option>
											</select>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td colspan="3"><button value="" type="submit" name="op" class="largeSearch squareSubmit"><span></span></button></td>
									</tr>
									</tbody></table>
								</div>
							</form>
						</div>
					</div>
				</div>	
			</td>
			<td>
				<div id="content" class="clearfix">
					<div id="container">
						<h1>Our Listings</h1>
						<table width="700">
							<tr>
								<td align="left" width="275">
									<form action="<?php echo "Search_Results.php?op=Begin+Search&property_Type=".urlencode($Property_Type)."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$_REQUEST['highest_price']."&mls_number=".$MLS."&citya=".$CityA."&address=".$AddressA."&zip_code=".$Zip_codeA."&subdivision=".$SubdivisionA."&garage=".$GarageA."&stories=".$StoriesA."&fireplaces=".$FireplacesA."&yard_size=".$Yard_sizeA."&cities=".$CitiesA."&areas=".$AreasA."&counties=".$CountiesA."&school_district=".$School_districtA."&school_type=".$School_type_elementaryA."&school_type=".$School_type_middleA."&school_type=".$School_type_highA."&school_name=".$School_nameA."&property=".$Guest_quartersA."&property=".$High_riseA."&property=".$Loft_A."&property=".$BalconyA."&property=".$LibraryA."&property=".$MediaA."&location=".$Gated_communityA."&location=".$Golf_course_communityA."&location=".$Golf_course_lotA."&location=".$Lake_front_lotA."&location=".$Lake_viewA."&location=".$Handicap_amenitiesA."&location=".$Horses_Allowed."&fence=".$Fence_woodA."&fence=".$Fence_ironA."&fence=".$Fence_brickA."&fence=".$Fence_rockA."&fence=".$Fence_automatic_gateA."&fence=".$Fence_noneA."&special_requirements=".$Special_requirementsA."&properties_with=".$Properties_with_photosA."&property_types=".$Single_detachedA."&property_types=".$MultiA."&property_types=".$TownhomeA."&property_types=".$CondoA."&property_types=".$LeaseA."&only=".$Joseph_molinaA."&only=".$Open_housesA; ?>" method="post" id="rha-mls-our-listings-sort">
									<div id="rha-mls-our-listings-sort-container">
										<label for="edit-sort-by" id="for-edit-sort-by"><span>Sort By</span> 
											<select name="sort_by" class="form-select" id="edit-sort-by" onchange="this.form.submit()">
												<option value="none">Choose one</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'price-high-to-low') $vSelected = ' SELECTED ';?>
												<option value="price-high-to-low" <?php echo $vSelected; ?>>Price Highest to Lowest</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'price-low-to-high') $vSelected = ' SELECTED ';?>
												<option value="price-low-to-high" <?php echo $vSelected; ?>>Price Lowest to Highest</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'sqft-high-to-low') $vSelected = ' SELECTED ';?>
												<option value="sqft-high-to-low" <?php echo $vSelected; ?>>Size Largest to Smallest</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'sqft-low-to-high') $vSelected = ' SELECTED ';?>
												<option value="sqft-low-to-high" <?php echo $vSelected; ?>>Size Smallest to Largest</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'street-name-alpha') $vSelected = ' SELECTED ';?>
												<option value="street-name-alpha" <?php echo $vSelected; ?>>Street Name</option>
												<?php $vSelected=''; if ($_REQUEST["sort_by"] == 'zip-code-numeric') $vSelected = ' SELECTED ';?>
												<option value="zip-code-numeric" <?php echo $vSelected; ?>>Zip Code</option>
											</select>
										</label>
									</div><!--/#rha-mls-our-listings-sort-container-->
								</td>
								<td align="center" valign="middle">
									<label for="pg" id="for-pg"><span>Page: </span>
									<select name="pg" class="form-select" id="pg" onchange="this.form.submit()">
										<?php
											for ($x=0; $x<=$num_pages; $x++) {
												$vSelected='';
												if ($pgnum == $x) $vSelected = ' SELECTED';
										  		echo '<option' . $vSelected . ' value="' . $x . '">' . ($x+1) . '</option>';
										  	} 
										?>
									</select>
																		<?php	//echo $total_found . " results found<BR>";						?>

									</form><!--/#rha-mls-our-listings-sort-->
								</td>
								<td align="right" width="275">
									<?php
										if ($pgnum > 0) {
											 echo("<a href='Search_Results.php?op=Begin+Search&pg=" . $prevpg ."&property_Type=".urlencode($Property_Type)."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$_REQUEST['highest_price']."&mls_number=".$MLS."&citya=".$CityA."&address=".$AddressA."&zip_code=".$Zip_codeA."&subdivision=".$SubdivisionA."&garage=".$GarageA."&stories=".$StoriesA."&fireplaces=".$FireplacesA."&yard_size=".$Yard_sizeA."&cities=".$CitiesA."&areas=".$AreasA."&counties=".$CountiesA."&school_district=".$School_districtA."&school_type=".$School_type_elementaryA."&school_type=".$School_type_middleA."&school_type=".$School_type_highA."&school_name=".$School_nameA."&property=".$Guest_quartersA."&property=".$High_riseA."&property=".$Loft_A."&property=".$BalconyA."&property=".$LibraryA."&property=".$MediaA."&location=".$Gated_communityA."&location=".$Golf_course_communityA."&location=".$Golf_course_lotA."&location=".$Lake_front_lotA."&location=".$Lake_viewA."&location=".$Handicap_amenitiesA."&location=".$Horses_Allowed."&fence=".$Fence_woodA."&fence=".$Fence_ironA."&fence=".$Fence_brickA."&fence=".$Fence_rockA."&fence=".$Fence_automatic_gateA."&fence=".$Fence_noneA."&special_requirements=".$Special_requirementsA."&properties_with=".$Properties_with_photosA."&property_types=".$Single_detachedA."&property_types=".$MultiA."&property_types=".$TownhomeA."&property_types=".$CondoA."&property_types=".$LeaseA."&only=".$Joseph_molinaA."&only=".$Open_housesA."&sort=".$sort. "'><< Previous page</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
										}  
										if ($pgnum < $num_pages) {
											 echo("<a href='Search_Results.php?op=Begin+Search&pg=" . $nextpg . "&property_Type=".urlencode($Property_Type)."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$_REQUEST['highest_price']."&mls_number=".$MLS."&citya=".$CityA."&address=".$AddressA."&zip_code=".$Zip_codeA."&subdivision=".$SubdivisionA."&garage=".$GarageA."&stories=".$StoriesA."&fireplaces=".$FireplacesA."&yard_size=".$Yard_sizeA."&cities=".$CitiesA."&areas=".$AreasA."&counties=".$CountiesA."&school_district=".$School_districtA."&school_type=".$School_type_elementaryA."&school_type=".$School_type_middleA."&school_type=".$School_type_highA."&school_name=".$School_nameA."&property=".$Guest_quartersA."&property=".$High_riseA."&property=".$Loft_A."&property=".$BalconyA."&property=".$LibraryA."&property=".$MediaA."&location=".$Gated_communityA."&location=".$Golf_course_communityA."&location=".$Golf_course_lotA."&location=".$Lake_front_lotA."&location=".$Lake_viewA."&location=".$Handicap_amenitiesA."&location=".$Horses_Allowed."&fence=".$Fence_woodA."&fence=".$Fence_ironA."&fence=".$Fence_brickA."&fence=".$Fence_rockA."&fence=".$Fence_automatic_gateA."&fence=".$Fence_noneA."&special_requirements=".$Special_requirementsA."&properties_with=".$Properties_with_photosA."&property_types=".$Single_detachedA."&property_types=".$MultiA."&property_types=".$TownhomeA."&property_types=".$CondoA."&property_types=".$LeaseA."&only=".$Joseph_molinaA."&only=".$Open_housesA."&sort=".$sort.  "'>Next page >></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
										}  
									?>
								</td>
							</tr>
						</table>
						<input type="hidden" name="redirect" id="edit-redirect" value="/our-listings"  />
						<input type="hidden" name="page_count" id="edit-page-count" value="140"  />
						<input type="hidden" name="form_build_id" id="form-524b5209ac82045a8e3c250785a6e75b" value="form-524b5209ac82045a8e3c250785a6e75b"  />
						<input type="hidden" name="form_id" id="edit-rha-mls-pager" value="rha_mls_pager"  />
						<div id="listings-container"> 
							<div id="listings">
								<?php
								while ($row = mysql_fetch_array($result)){
										echo	"<div class=\"vcard listing\">";
										echo	"<div class=\"information\">";
										echo 	"<span class=\"listprice\">\$".number_format($row['LISTPRICE'])."\n </span><br/>";
										echo 	"<p><span>{$row['STREETNUM']},{$row['STREETNAME']} ";
										echo 	"<BR/>{$row['CITY']}</span>";
										echo 	"{$row['STATE']}, {$row['ZIPCODE']}</p>";
										echo 	"<p><span>Beds: {$row['BEDS']}, Baths:{$row['BATHSTOTAL']}<br/>Square Feet: ".number_format($row['SQFTTOTAL'])." </span></p>";	
										echo	"</div>";

						
											$photos = $rets->GetObject("Property", "Photo", "{$row['MLSNUM']}", "0", 1);
												foreach ($photos as $photo) {
														$listing = $photo['Content-ID'];
														$number = $photo['Object-ID'];
				
														if ($photo['Success'] == true) {
																echo "<img src='{$photo['Location']}\n' alt=\"\" title=\"\"  class=\"listing-photo photo\" width=\"146\" height=\"107\" />";
																echo "<a href=\"PropDetails.php?pg=" . $pgnum ."&property_Type=".$Property_Type."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$Highest_Price."&MLS=".$row['MLSNUM'].$mainp."#{$photo['Location']}"."\" class=\"button url\">Property Details</a>";
														}
														else {
																echo "<img src='images/no-image.png' alt=\"\" title=\"\"  class=\"listing-photo photo\" width=\"146\" height=\"107\" />";
																echo "<a href=\"PropDetails.php?MLS={$row['MLSNUM']}\" class=\"button url\">Property Details</a>";
														}
												}
										echo "</div>";
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
	</table>
	</center>			
</body>	
</head>
</html>