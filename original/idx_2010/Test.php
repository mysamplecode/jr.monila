<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body bgcolor="#FFFFFF">
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
$School_elementaryA=$_GET['school_type[elementary]'];
$School_middleA=$_GET['school_type[middle]'];
$School_highA=$_GET['school_type[high]'];
$School_nameA=$_GET['school_name'];
$Guest_quartersA=$_GET['property[guest-quarters]'];
$High_riseA=$_GET['property[high-rise-condominium]'];
$Loft_A=$_GET['property[loft]'];
$BalconyA=$_GET['property[balcony]'];
$LibraryA=$_GET['property[library-or-study]'];
$MediaA=$_GET['property[media-room]'];
$Gated_communityA=$_GET['location[gated-community]'];
$Golf_course_communityA=$_GET['location[golf-course-community]'];
$Golf_course_lotA=$_GET['location[golf-course-lot]'];
$Lake_front_lotA=$_GET['location[lake-front-lot]'];
$Lake_viewA=$_GET['location[lake-view]'];
$Handicap_amenitiesA=$_GET['location[handicap-ammenities]'];
$Zero_lot_lineA=$_GET['location[zero-lot-line]'];
$Horses_allowedA=$_GET['location[horses-allowed]'];
$Fence_woodA=$_GET['fence[wood]'];
$Fence_ironA=$_GET['fence[iron]'];
$Fence_brickA=$_GET['fence[brick]'];
$Fence_rockA=$_GET['fence[rock]'];
$Fence_automatic_gateA=$_GET['fence[automatic-gate]'];
$Fence_noneA=$_GET['fence[none]'];
$Special_requirementsA=$_GET['special_requirements'];
$Properties_with_photosA=$_GET['properties_with[photos]'];
$Single_detachedA=$_GET['property_types[single-detached]'];
$MultiA=$_GET['property_types[multi]'];
$TownhomeA=$_GET['property_types[townhome]'];
$CondoA=$_GET['property_types[condo]'];
$Half_duplexA=$_GET['property_types[half-duplex]'];
$LeaseA=$_GET['property_types[lease]'];
$Joseph_molinaA=$_GET['only[joseph-molina-properties]'];
$Open_housesA=$_GET['only[open-houses]'];

include("db.php");

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
		$City=0;
		$Any_City= "LIKE";
	}
if($MLS==NULL){
		$Any_MLS= "IS NOT";
	} else {
		$Any_MLS= "=";
	}

echo $Any_City;
echo $Any_MLS."<br/>";

$result = mysql_query("SELECT * 
					  FROM residential 
					  WHERE	PROPSUBTYPEDISPLAY LIKE '%{$Property_Type}%'
					  AND	AREA {$Any_City} {$City}
					  AND	BEDS >={$Beds}
					  AND	BATHSTOTAL >= {$Baths}
					  AND	LISTPRICE >= {$Lowest_Price}
					  AND	LISTPRICE {$Any} {$Highest_Price}
					  LIMIT 0, 20")
 or die(mysql_error());



?>

</body>
</html>
