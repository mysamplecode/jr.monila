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

<?php
if (is_numeric($_GET['pg'])) {
        $pgnum = ((int) $_GET['pg']);
}

else {
        $pgnum = 0;
        $errorMessage = "Invalid value for page number";

}

$startnum = 1;
$nextpg = ($pgnum + 1);
$prevpg = ($pgnum-1);

if ($pgnum >= 0) {
        $offset = ($pgnum * 20);
}

else {
        $offset = 0;
}

$limit = 20; 
?>

<?php

$Property_Type=$_GET['property_type'];
$City=$_GET['city'];
$Beds=$_GET['beds'];
$Baths=$_GET['baths'];
$Lowest_Price=$_GET['lowest_price'];
$Highest_Price=$_GET['highest_price'];
$MLS=$_GET['mls_number'];
$CityA=$_GET['citya'];
$AddressA=$_GET['address'];
$Zip_codeA=$_GET['zip_code'];
$SubdivisionA=$_GET['subdivision'];
$GarageA=$_GET['garage'];
$StoriesA=$_GET['stories'];
$FireplacesA=$_GET['fireplaces'];
$Yard_sizeA=$_GET['yard_size'];
$CitiesA=$_GET['cities'];
$AreasA=$_GET['areas'];
$CountiesA=$_GET['counties'];
$School_districtA=$_GET['school_district'];
$School_type_elementaryA=$_GET['school_type'];
$School_type_middleA=$_GET['school_type'];
$School_type_highA=$_GET['school_type'];
$School_nameA=$_GET['school_name'];
$Guest_quartersA=$_GET['property'];
$High_riseA=$_GET['property'];
$Loft_A=$_GET['property'];
$BalconyA=$_GET['property'];
$LibraryA=$_GET['property'];
$MediaA=$_GET['property'];
$Gated_communityA=$_GET['location'];
$Golf_course_communityA=$_GET['location'];
$Golf_course_lotA=$_GET['location'];
$Lake_front_lotA=$_GET['location'];
$Lake_viewA=$_GET['location'];
$Handicap_amenitiesA=$_GET['location'];
$Zero_lot_lineA=$_GET['location'];
$Horses_allowedA=$_GET['location'];
$Fence_woodA=$_GET['fence'];
$Fence_ironA=$_GET['fence'];
$Fence_brickA=$_GET['fence'];
$Fence_rockA=$_GET['fence'];
$Fence_automatic_gateA=$_GET['fence'];
$Fence_noneA=$_GET['fence'];
$Special_requirementsA=$_GET['special_requirements'];
$Properties_with_photosA=$_GET['properties_with'];
$Single_detachedA=$_GET['property_types'];
$MultiA=$_GET['property_types'];
$TownhomeA=$_GET['property_types'];
$CondoA=$_GET['property_types'];
$Half_duplexA=$_GET['property_types'];
$LeaseA=$_GET['property_types'];
$Joseph_molinaA=$_GET['only'];
$Open_housesA=$_GET['only'];


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


?>



<body id="jrmolina-listing-detail" class="our-listings our-listings-landing" text>
	<div id="page">
		<div id="content-container">
			<div id="content" class="clearfix">
            <div style="search"> 
            
            <table class="style">
<form class="style" id="MLSform" name="MLSform" method="get" action="Search Results.php">
  <tr>
    <td colspan="2">Property Type</td>
    <td colspan="2">Area</td>
    <td rowspan="4"> 
	<input type="submit" name="op" id="edit-search" value="Begin Search"  tabindex="7" class="form-submit" />  
      <br />
      <a href="Advanced_Search.php">&nbsp;&nbsp;Advanced &gt;&gt;</a>
      <input type="hidden" name="pg" value="0" />
      </td>
  </tr>
  <tr>
    <td colspan="2">
      <select name="property_type" id="Property_Type2">
        <option <?php if($Property_Type=="RES"){echo "selected='selected'";} ?> value="RES">All</option>
        <option <?php if($Property_Type=="S"){echo "selected='selected'";} ?> value="S">Single Family</option>
        <option <?php if($Property_Type==""){echo "selected='selected'";} ?> value="RES">Multi Family</option>
        <option <?php if($Property_Type=="T"){echo "selected='selected'";} ?> value="T">Townhome</option>
        <option <?php if($Property_Type=="C"){echo "selected='selected'";} ?> value="C">Condo</option>
        <option <?php if($Property_Type=="H"){echo "selected='selected'";} ?> value="H">Half Duplex</option>
        <option <?php if($Property_Type=="LSE"){echo "selected='selected'";} ?> value="LSE">Residential Lease</option>
      </select>
    </td>
    <td colspan="2">
		<select name="city" tabindex="6" class="form-select" id="area" >
        <option <?php if($City=="0"){echo "selected='selected'";} ?> value="0">Any</option>
        <option <?php if($City=="10"){echo "selected='selected'";} ?> value="10">Addison/Far North Dallas</option>
        <option <?php if($City=="51"){echo "selected='selected'";} ?> value="51">Allen</option>
        <option <?php if($City=="22"){echo "selected='selected'";} ?> value="22">Carrollton</option>
        <option <?php if($City=="123"){echo "selected='selected'";} ?> value="123">Colleyville</option>
        <option <?php if($City=="21"){echo "selected='selected'";} ?> value="21">Coppell</option>
        <option <?php if($City=="12"){echo "selected='selected'";} ?> value="12">East Dallas</option>
        <option <?php if($City=="55"){echo "selected='selected'";} ?> value="55">Frisco</option>
        <option <?php if($City=="24"){echo "selected='selected'";} ?> value="24">Garland</option>
        <option <?php if($City=="124"){echo "selected='selected'";} ?> value="124">Grapevine</option>
        <option <?php if($City=="25"){echo "selected='selected'";} ?> value="25">Highland Park/University Park</option>
        <option <?php if($City=="26"){echo "selected='selected'";} ?> value="26">Irving</option>
        <option <?php if($City=="17"){echo "selected='selected'";} ?> value="17">Knox/Henderson</option>
        <option <?php if($City=="53"){echo "selected='selected'";} ?> value="53">McKinney</option>
        <option <?php if($City=="11"){echo "selected='selected'";} ?> value="11">North Dallas</option>
        <option <?php if($City=="14"){echo "selected='selected'";} ?> value="14">North Oak Cliff</option>
        <option <?php if($City=="18"){echo "selected='selected'";} ?> value="18">Northeast Dallas</option>
        <option <?php if($City=="16"){echo "selected='selected'";} ?> value="16">Northwest Dallas</option>
        <option <?php if($City=="17b"){echo "selected='selected'";} ?> value="17b">Oak Lawn Area</option>
        <option <?php if($City=="20"){echo "selected='selected'";} ?> value="20">Plano</option>
        <option <?php if($City=="23"){echo "selected='selected'";} ?> value="23">Richardson</option>
        <option <?php if($City=="34"){echo "selected='selected'";} ?> value="34">Rockwall</option>
        <option <?php if($City=="8"){echo "selected='selected'";} ?> value="8">Rowlett</option>
        <option <?php if($City=="13"){echo "selected='selected'";} ?> value="13">Southeast Dallas</option>
        <option <?php if($City=="125"){echo "selected='selected'";} ?> value="125">Southlake</option>
        <option <?php if($City=="9"){echo "selected='selected'";} ?> value="9">The Colony</option>
        <option <?php if($City=="132"){echo "selected='selected'";} ?> value="132">West Lake Area</option>
        <option <?php if($City=="17"){echo "selected='selected'";} ?> value="17">Turtle Creek</option>
        <option <?php if($City=="17"){echo "selected='selected'";} ?> value="17">Uptown/Downtown</option>
        </select></label>
        </select>
    </td>
    </tr>
  <tr>
    <td>Beds</td>
    <td>Baths</td>
    <td>Lowest</td>
    <td>Highest</td>
    </tr>
  <tr>
    <td>
      <select name="beds" tabindex="2" class="form-select" id="beds2" >
        <option <?php if($Beds=="0"){echo "selected='selected'";} ?> value="0">Any</option>
        <option <?php if($Beds=="1"){echo "selected='selected'";} ?> value="1">1+</option>
        <option <?php if($Beds=="2"){echo "selected='selected'";} ?> value="2">2+</option>
        <option <?php if($Beds=="3"){echo "selected='selected'";} ?> value="3">3+</option>
        <option <?php if($Beds=="4"){echo "selected='selected'";} ?> value="4">4+</option>
        <option <?php if($Beds=="5"){echo "selected='selected'";} ?> value="5">5+</option>
        <option <?php if($Beds=="6"){echo "selected='selected'";} ?> value="6">6+</option>
        <option <?php if($Beds=="7"){echo "selected='selected'";} ?> value="7">7+</option>
        <option <?php if($Beds=="8"){echo "selected='selected'";} ?> value="8">8+</option>
      </select>
    </td>
    <td>
      <select name="baths" tabindex="3" class="form-select" id="baths2" >
        <option <?php if($Baths=="0"){echo "selected='selected'";} ?> value="0">Any</option>
        <option <?php if($Baths=="1"){echo "selected='selected'";} ?> value="1">1+</option>
        <option <?php if($Baths=="2"){echo "selected='selected'";} ?> value="2">2+</option>
        <option <?php if($Baths=="3"){echo "selected='selected'";} ?> value="3">3+</option>
        <option <?php if($Baths=="4"){echo "selected='selected'";} ?> value="4">4+</option>
        <option <?php if($Baths=="5"){echo "selected='selected'";} ?> value="5">5+</option>
        <option <?php if($Baths=="6"){echo "selected='selected'";} ?> value="6">6+</option>
        <option <?php if($Baths=="7"){echo "selected='selected'";} ?> value="7">7+</option>
        <option <?php if($Baths=="8"){echo "selected='selected'";} ?> value="8">8+</option>
      </select>
    </td>
    <td>
      <select name="lowest_price" tabindex="4" class="form-select" id="lowest_price" >
        <option <?php if($Lowest_Price=="0"){echo "selected='selected'";} ?> value="0">No min.</option>
        <option <?php if($Lowest_Price=="1000"){echo "selected='selected'";} ?> value="1000">$1,000</option>
        <option <?php if($Lowest_Price=="3000"){echo "selected='selected'";} ?> value="3000">$3,000</option>
        <option <?php if($Lowest_Price=="5000"){echo "selected='selected'";} ?> value="5000">$5,000</option>
        <option <?php if($Lowest_Price=="25000"){echo "selected='selected'";} ?> value="25000">$25,000</option>
        <option <?php if($Lowest_Price=="50000"){echo "selected='selected'";} ?> value="50000">$50,000</option>
        <option <?php if($Lowest_Price=="75000"){echo "selected='selected'";} ?> value="75000">$75,000</option>
        <option <?php if($Lowest_Price=="100000"){echo "selected='selected'";} ?> value="100000">$100,000</option>
        <option <?php if($Lowest_Price=="125000"){echo "selected='selected'";} ?> value="125000">$125,000</option>
        <option <?php if($Lowest_Price=="150000"){echo "selected='selected'";} ?> value="150000">$150,000</option>
        <option <?php if($Lowest_Price=="175000"){echo "selected='selected'";} ?> value="175000">$175,000</option>
        <option <?php if($Lowest_Price=="200000"){echo "selected='selected'";} ?> value="200000">$200,000</option>
        <option <?php if($Lowest_Price=="225000"){echo "selected='selected'";} ?> value="225000">$225,000</option>
        <option <?php if($Lowest_Price=="250000"){echo "selected='selected'";} ?> value="250000">$250,000</option>
        <option <?php if($Lowest_Price=="275000"){echo "selected='selected'";} ?> value="275000">$275,000</option>
        <option <?php if($Lowest_Price=="300000"){echo "selected='selected'";} ?> value="300000">$300,000</option>
        <option <?php if($Lowest_Price=="325000"){echo "selected='selected'";} ?> value="325000">$325,000</option>
        <option <?php if($Lowest_Price=="350000"){echo "selected='selected'";} ?> value="350000">$350,000</option>
        <option <?php if($Lowest_Price=="400000"){echo "selected='selected'";} ?> value="400000">$400,000</option>
        <option <?php if($Lowest_Price=="425000"){echo "selected='selected'";} ?> value="425000">$425,000</option>
        <option <?php if($Lowest_Price=="450000"){echo "selected='selected'";} ?> value="450000">$450,000</option>
        <option <?php if($Lowest_Price=="475000"){echo "selected='selected'";} ?> value="475000">$475,000</option>
        <option <?php if($Lowest_Price=="500000"){echo "selected='selected'";} ?> value="500000">$500,000</option>
        <option <?php if($Lowest_Price=="550000"){echo "selected='selected'";} ?> value="550000">$550,000</option>
        <option <?php if($Lowest_Price=="600000"){echo "selected='selected'";} ?> value="600000">$600,000</option>
        <option <?php if($Lowest_Price=="650000"){echo "selected='selected'";} ?> value="650000">$650,000</option>
        <option <?php if($Lowest_Price=="700000"){echo "selected='selected'";} ?> value="700000">$700,000</option>
        <option <?php if($Lowest_Price=="750000"){echo "selected='selected'";} ?> value="750000">$750,000</option>
        <option <?php if($Lowest_Price=="800000"){echo "selected='selected'";} ?> value="800000">$800,000</option>
        <option <?php if($Lowest_Price=="850000"){echo "selected='selected'";} ?> value="850000">$850,000</option>
        <option <?php if($Lowest_Price=="900000"){echo "selected='selected'";} ?> value="900000">$900,000</option>
        <option <?php if($Lowest_Price=="950000"){echo "selected='selected'";} ?> value="950000">$950,000</option>
        <option <?php if($Lowest_Price=="1000000"){echo "selected='selected'";} ?> value="1000000">$1 mil</option>
        <option <?php if($Lowest_Price=="1500000"){echo "selected='selected'";} ?> value="1500000">$1.5 mil</option>
        <option <?php if($Lowest_Price=="2000000"){echo "selected='selected'";} ?> value="2000000">$2 mil</option>
        <option <?php if($Lowest_Price=="2500000"){echo "selected='selected'";} ?> value="2500000">$2.5 mil</option>
        <option <?php if($Lowest_Price=="3000000"){echo "selected='selected'";} ?> value="3000000">$3 mil</option>
        <option <?php if($Lowest_Price=="3500000"){echo "selected='selected'";} ?> value="3500000">$3.5 mil</option>
        <option <?php if($Lowest_Price=="4000000"){echo "selected='selected'";} ?> value="4000000">$4 mil</option>
        <option <?php if($Lowest_Price=="4500000"){echo "selected='selected'";} ?> value="4500000">$4.5 mil</option>
        <option <?php if($Lowest_Price=="5000000"){echo "selected='selected'";} ?> value="5000000">$5 mil</option>
        <option <?php if($Lowest_Price=="5000001"){echo "selected='selected'";} ?> value="5000001">$5 mil+</option>
      </select>
    </td>
    <td>
      
        <select name="highest_price" tabindex="5" class="form-select" id="highest_price" >
          <option <?php if($Highest_Price=="0"){echo "selected='selected'";} ?> value="0">No max.</option>
          <option <?php if($Highest_Price=="1000"){echo "selected='selected'";} ?> value="1000">$1,000</option>
          <option <?php if($Highest_Price=="3000"){echo "selected='selected'";} ?> value="3000">$3,000</option>
          <option <?php if($Highest_Price=="5000"){echo "selected='selected'";} ?> value="5000">$5,000</option>
          <option <?php if($Highest_Price=="25000"){echo "selected='selected'";} ?> value="25000">$25,000</option>
          <option <?php if($Highest_Price=="50000"){echo "selected='selected'";} ?> value="50000">$50,000</option>
          <option <?php if($Highest_Price=="75000"){echo "selected='selected'";} ?> value="75000">$75,000</option>
          <option <?php if($Highest_Price=="100000"){echo "selected='selected'";} ?> value="100000">$100,000</option>
          <option <?php if($Highest_Price=="125000"){echo "selected='selected'";} ?> value="125000">$125,000</option>
          <option <?php if($Highest_Price=="150000"){echo "selected='selected'";} ?> value="150000">$150,000</option>
          <option <?php if($Highest_Price=="175000"){echo "selected='selected'";} ?> value="175000">$175,000</option>
          <option <?php if($Highest_Price=="200000"){echo "selected='selected'";} ?> value="200000">$200,000</option>
          <option <?php if($Highest_Price=="225000"){echo "selected='selected'";} ?> value="225000">$225,000</option>
          <option <?php if($Highest_Price=="250000"){echo "selected='selected'";} ?> value="250000">$250,000</option>
          <option <?php if($Highest_Price=="275000"){echo "selected='selected'";} ?> value="275000">$275,000</option>
          <option <?php if($Highest_Price=="300000"){echo "selected='selected'";} ?> value="300000">$300,000</option>
          <option <?php if($Highest_Price=="325000"){echo "selected='selected'";} ?> value="325000">$325,000</option>
          <option <?php if($Highest_Price=="350000"){echo "selected='selected'";} ?> value="350000">$350,000</option>
          <option <?php if($Highest_Price=="400000"){echo "selected='selected'";} ?> value="400000">$400,000</option>
          <option <?php if($Highest_Price=="425000"){echo "selected='selected'";} ?> value="425000">$425,000</option>
          <option <?php if($Highest_Price=="450000"){echo "selected='selected'";} ?> value="450000">$450,000</option>
          <option <?php if($Highest_Price=="475000"){echo "selected='selected'";} ?> value="475000">$475,000</option>
          <option <?php if($Highest_Price=="500000"){echo "selected='selected'";} ?> value="500000">$500,000</option>
          <option <?php if($Highest_Price=="550000"){echo "selected='selected'";} ?> value="550000">$550,000</option>
          <option <?php if($Highest_Price=="600000"){echo "selected='selected'";} ?> value="600000">$600,000</option>
          <option <?php if($Highest_Price=="650000"){echo "selected='selected'";} ?> value="650000">$650,000</option>
          <option <?php if($Highest_Price=="700000"){echo "selected='selected'";} ?> value="700000">$700,000</option>
          <option <?php if($Highest_Price=="750000"){echo "selected='selected'";} ?> value="750000">$750,000</option>
          <option <?php if($Highest_Price=="800000"){echo "selected='selected'";} ?> value="800000">$800,000</option>
          <option <?php if($Highest_Price=="850000"){echo "selected='selected'";} ?> value="850000">$850,000</option>
          <option <?php if($Highest_Price=="900000"){echo "selected='selected'";} ?> value="900000">$900,000</option>
          <option <?php if($Highest_Price=="950000"){echo "selected='selected'";} ?> value="950000">$950,000</option>
          <option <?php if($Highest_Price=="1000000"){echo "selected='selected'";} ?> value="1000000">$1 mil</option>
          <option <?php if($Highest_Price=="1500000"){echo "selected='selected'";} ?> value="1500000">$1.5 mil</option>
          <option <?php if($Highest_Price=="2000000"){echo "selected='selected'";} ?> value="2000000">$2 mil</option>
          <option <?php if($Highest_Price=="2500000"){echo "selected='selected'";} ?> value="2500000">$2.5 mil</option>
          <option <?php if($Highest_Price=="3000000"){echo "selected='selected'";} ?> value="3000000">$3 mil</option>
          <option <?php if($Highest_Price=="3500000"){echo "selected='selected'";} ?> value="3500000">$3.5 mil</option>
          <option <?php if($Highest_Price=="4000000"){echo "selected='selected'";} ?> value="4000000">$4 mil</option>
          <option <?php if($Highest_Price=="4500000"){echo "selected='selected'";} ?> value="4500000">$4.5 mil</option>
          <option <?php if($Highest_Price=="5000000"){echo "selected='selected'";} ?> value="5000000">$5 mil</option>
          <option <?php if($Highest_Price=="no_limit"){echo "selected='selected'";} ?> value="no_limit">$5 mil+</option>
        </select>
      </td>
    </tr>
  </form>
</table></div>
				<div id="container">
                <form action="<?php 'Search Results.php?op=Begin+Search&pg=' . 0 . '&property_Type='.urlencode($Property_Type).'&city='.$City.'&beds='.$Beds.'&baths='.$Baths.'&lowest_price='.$Lowest_Price.'&highest_price='.$Highest_Price; ?>" method="post" id="rha-mls-our-listings-sort">
										<div id="rha-mls-our-listings-sort-container">
					
												<label for="edit-sort-by" id="for-edit-sort-by"><span>Sort By</span> 
												<select name="sort_by" class="form-select" id="edit-sort-by" ><option value="none">Choose one</option><option value="price-high-to-low">Price Highest to Lowest</option><option value="price-low-to-high">Price Lowest to Highest</option><option value="sqft-high-to-low">Size Largest to Smallest</option><option value="sqft-low-to-high">Size Smallest to Largest</option><option value="street-name-alpha">Street Name</option><option value="zip-code-numeric">Zip Code</option></select></label>

												<input type="submit" name="op" id="edit-submit" value="Go"  class="form-submit" />
					<input type="submit" name="op" id="edit-reset" value="Reset"  class="form-submit" />

					
										</div><!--/#rha-mls-our-listings-sort-container-->
									</form><!--/#rha-mls-our-listings-sort-->

<input type="hidden" name="redirect" id="edit-redirect" value="/our-listings"  />
										<input type="hidden" name="page_count" id="edit-page-count" value="140"  />
										<input type="hidden" name="form_build_id" id="form-524b5209ac82045a8e3c250785a6e75b" value="form-524b5209ac82045a8e3c250785a6e75b"  />
										<input type="hidden" name="form_id" id="edit-rha-mls-pager" value="rha_mls_pager"  />


					<div id="listings-container"> <div id="listings">


<?php
if($GarageA == NULL){
$GarageA = 0;
}

if($StoriesA == NULL){
$StoriesA = 0;
}

if($FireplacesA == NULL){
$FireplacesA = 0;
}

if(isset($_GET['sort'])){
	$sort=$_GET['sort'];
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
		if($Highest_Price=="no_limit"){$Highest_Price="5000000";}
			$Any= ">=";
		} else {
			$Any= "<=";
		}
		
	
if($City==0||$City==NULL){
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
if($Property_Type=="LSE"){$SEARCH="WHERE FORLEASE LIKE 'Y'
						AND	AREA {$Any_City} {$City}
						AND	BEDS >={$Beds}
						AND	BATHSTOTAL >={$Baths}
						AND	LISTPRICE >={$Lowest_Price}
						AND	LISTPRICE {$Any} {$Highest_Price}";}
elseif($MLSNUM != NULL){
	$SEARCH = "WHERE MLSNUM = {$MLSNUM}";
} else { $SEARCH = "WHERE	PROPSUBTYPEDISPLAY LIKE '%{$Property_Type}%'
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
	

$result = mysql_query("SELECT * 
						FROM residential 
						".$SEARCH."
						
						ORDER BY {$sort}
						LIMIT {$offset}, {$limit}")
 or die(mysql_error());
 

?>
<div id="rha-mls-pager-container">
<?php

	
mysql_query("SELECT SQL_CALC_FOUND_ROWS * 
			FROM residential 
			".$SEARCH."
			ORDER BY {$sort}
			LIMIT {$offset}, {$limit}");
$total_rows		=	mysql_query("SELECT FOUND_ROWS()");
$total_found	= 	mysql_fetch_array($total_rows);

$pages_count= $total_found[0] / $limit;
$num_pages=intval($pages_count);

echo $total_found[0]." results found";
echo "<br/>";

if ($pgnum > 0) {
     echo("<a href='Search Results.php?op=Begin+Search&pg=" . $prevpg ."&property_Type=".urlencode($Property_Type)."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$_GET['highest_price']."&mls_number=".$MLS."&citya=".$CityA."&address=".$AddressA."&zip_code=".$Zip_codeA."&subdivision=".$SubdivisionA."&garage=".$GarageA."&stories=".$StoriesA."&fireplaces=".$FireplacesA."&yard_size=".$Yard_sizeA."&cities=".$CitiesA."&areas=".$AreasA."&counties=".$CountiesA."&school_district=".$School_districtA."&school_type=".$School_type_elementaryA."&school_type=".$School_type_middleA."&school_type=".$School_type_highA."&school_name=".$School_nameA."&property=".$Guest_quartersA."&property=".$High_riseA."&property=".$Loft_A."&property=".$BalconyA."&property=".$LibraryA."&property=".$MediaA."&location=".$Gated_communityA."&location=".$Golf_course_communityA."&location=".$Golf_course_lotA."&location=".$Lake_front_lotA."&location=".$Lake_viewA."&location=".$Handicap_amenitiesA."&location=".$Horses_Allowed."&fence=".$Fence_woodA."&fence=".$Fence_ironA."&fence=".$Fence_brickA."&fence=".$Fence_rockA."&fence=".$Fence_automatic_gateA."&fence=".$Fence_noneA."&special_requirements=".$Special_requirementsA."&properties_with=".$Properties_with_photosA."&property_types=".$Single_detachedA."&property_types=".$MultiA."&property_types=".$TownhomeA."&property_types=".$CondoA."&property_types=".$LeaseA."&only=".$Joseph_molinaA."&only=".$Open_housesA."&sort=".$sort. "'><< Previous
page</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
}  

if ($pgnum < $num_pages) {
     echo("<a href='Search Results.php?op=Begin+Search&pg=" . $nextpg . "&property_Type=".urlencode($Property_Type)."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$_GET['highest_price']."&mls_number=".$MLS."&citya=".$CityA."&address=".$AddressA."&zip_code=".$Zip_codeA."&subdivision=".$SubdivisionA."&garage=".$GarageA."&stories=".$StoriesA."&fireplaces=".$FireplacesA."&yard_size=".$Yard_sizeA."&cities=".$CitiesA."&areas=".$AreasA."&counties=".$CountiesA."&school_district=".$School_districtA."&school_type=".$School_type_elementaryA."&school_type=".$School_type_middleA."&school_type=".$School_type_highA."&school_name=".$School_nameA."&property=".$Guest_quartersA."&property=".$High_riseA."&property=".$Loft_A."&property=".$BalconyA."&property=".$LibraryA."&property=".$MediaA."&location=".$Gated_communityA."&location=".$Golf_course_communityA."&location=".$Golf_course_lotA."&location=".$Lake_front_lotA."&location=".$Lake_viewA."&location=".$Handicap_amenitiesA."&location=".$Horses_Allowed."&fence=".$Fence_woodA."&fence=".$Fence_ironA."&fence=".$Fence_brickA."&fence=".$Fence_rockA."&fence=".$Fence_automatic_gateA."&fence=".$Fence_noneA."&special_requirements=".$Special_requirementsA."&properties_with=".$Properties_with_photosA."&property_types=".$Single_detachedA."&property_types=".$MultiA."&property_types=".$TownhomeA."&property_types=".$CondoA."&property_types=".$LeaseA."&only=".$Joseph_molinaA."&only=".$Open_housesA."&sort=".$sort.  "'>Next
page >></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
}  


echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo ($pgnum+1)." out of ".($num_pages+1)." pages";
?>
</div><!--/#rha-mls-pager-container-->
<br/>

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
</div>
</div>	
</body>	
</head>
</html>