<?php
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



$Property_Type=$_REQUEST['property_type'];
$City=$_REQUEST['city'];
$State=$_REQUEST['state'];
$Beds=$_REQUEST['beds'];
$Baths=$_REQUEST['baths'];
$Lowest_Price=$_REQUEST['lowest_price'];
$Highest_Price=$_REQUEST['highest_price'];
$MLS=$_REQUEST['MLS'];
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


if (is_numeric($_REQUEST['pg'])) {
        $pgnum = ((int) $_REQUEST['pg']);
}

else {
        $pgnum = 0;
        $errorMessage = "Invalid value for page number";

}


$result = mysql_query("SELECT * FROM residential WHERE MLSNUM = '{$MLS}' ") or die(mysql_error());
$row = mysql_fetch_array($result);	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MLS#: <?php echo $MLS; ?> - Joseph Molina</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png"/>
<link charset="utf-8" type="text/css" rel="stylesheet" media="all" href="results.css" />
<link href="galleria/trunk/galleria.css" rel="stylesheet" type="text/css" media="screen">
<script type="text/javascript" src="galleria/demo/jquery.min.js"></script>
<script type="text/javascript" src="galleria/trunk/galleria.css"></script>
<script type="text/javascript" src="galleria/trunk/jquery.galleria.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
		
		$('.gallery_demo_unstyled').addClass('gallery_demo'); // adds new class name to maintain degradability
		
		$('ul.gallery_demo').galleria({
			history   : true, // activates the history object for bookmarking, back-button etc.
			clickNext : true, // helper for making the image clickable
			insert    : '#main_image', // the containing selector for our main image
			onImage   : function(image,caption,thumb) { // effect


				// fade in the image & caption
				image.css('display','none').fadeIn(1000);
				caption.css('display','none').fadeIn(1000);
				image.css('width','400px')
				image.css('height','280px')
				image.css('margin','95px 0px 0px 10px')
				image.css('div','10px')
				
				// fetch the thumbnail container
				var _li = thumb.parents('li');
				
				
				// fade out inactive thumbnail
				_li.siblings().children('img.selected').fadeTo(500,0.3);
				
				// fade in active thumbnail
				thumb.fadeTo('fast',1).addClass('selected');
				
				// add a title for the clickable image
				image.attr('title','Next image >>');
			},
			onThumb : function(thumb) { // thumbnail effects goes here
				
				// fetch the thumbnail container
				var _li = thumb.parents('li');
				
				// if thumbnail is active, fade all the way.
				var _fadeTo = _li.is('.active') ? '1' : '0.3';
				
				// fade in the thumbnail when finnished loading
				thumb.css({display:'none',opacity:_fadeTo}).fadeIn(1500);
				thumb.css('width','63px')
				thumb.css('height','47px')
				
				// hover effects
				thumb.hover(
					function() { thumb.fadeTo('fast',1); },
					function() { _li.not('.active').children('img').fadeTo('fast',0.3); } // don't fade out if the parent is active
				)
			}
		});
	});
</script>
	<style media="screen,projection" type="text/css">
	
	/* BEGIN DEMO STYLE */
	*{
	list-style: none;
	padding-right: 0;
	padding-bottom: 1;
	width: auto;
	margin-top: 0;
	margin-right: 20px;
	margin-bottom: 0;
	margin-left: 0;
}

	body{
	padding:20px;
	background:white;
	text-align:center;
	color:#666;
	font:80%/140% georgia,serif;
	list-style-type: none;
	background-color: #000;
}
	h1,h2{font:bold 80% 'helvetica neue',sans-serif;letter-spacing:3px;text-transform:uppercase;}
	a{color:#348;text-decoration:none;outline:none;}
	a:hover{color:#67a;}
	.caption{font-style:italic;color:#887;}
	.demo{position:relative;margin-top:2em;}
	.gallery_demo{width:702px;margin:0 auto;}
	.gallery_demo li{width:68px;height:50px;border:3px double #111;margin: 0 2px;background:#000;}
	.gallery_demo li div{left:240px}
	.gallery_demo li div .caption{font:italic 0.7em/1.4 georgia,serif;}
	
	#main_image{margin:0 auto 60px auto;height:438px;width:700px;background:black;}
	#main_image img{margin-bottom:10px;}
	
	.nav{padding-top:15px;clear:both;font:80% 'helvetica neue',sans-serif;letter-spacing:3px;text-transform:uppercase;}
	
	.info{text-align:left;width:700px;margin:30px auto;border-top:1px dotted #221;padding-top:30px;}
	.info p{margin-top:1.6em;}
	
    </style>
</head>


<body id="www-jrmolina-com" class="our-listings"  style="background-color: #999;">
<ul id="accessibility">
		<li><a href="#container">Skip to Content</a></li>
	</ul>
	<div id="page">
	  <div id="content-container">
			<div id="content" class="clearfix">
					<div id="container">
					<p align="left">
					<a href="http://friscorealestatesearchtx.com"><img border="0" src="http://jrmolina.com/small%20logo%20jrm.png" alt="Dallas Real Estate Search"></a>
					</p>
					<h2 id="page-title" align="left">Details on <?php echo $row['STREETNUM'] ?> <?php echo $row['STREETNAME'] ?></h2>
					<div id="listing-detail" class="vcard">
					  <p style="text-align: left"><strong>MLS# <?php echo $row['MLSNUM'] ?></strong></p>
					  <ul id="listing-nav" class="clearfix">
							<li class="first-child"><a href=<?php echo "Search_Results.php?pg=" . $pgnum ."&property_Type=".$Property_Type."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$Highest_Price.$mainp."#{$photo['Location']}"; ?> onClick="history.go(-1)">Back to Listings</a></li>
					  </ul><!--/#listing-nav-->
                     
                        
                        
        <div id="general-information" class="demo">
						  <div class="main_image"></div>
						  <div id="general-description">
<h3><?php echo "$".number_format($row['LISTPRICE']); ?></h3>

<p> <span><?php echo $row['BEDS'] ?> bedrooms <br/> 
<?php echo $row['BATHSFULL'] ?> baths <br/>
<?php echo $row['CARPORTCAP']; ?> garage spaces</span> <b>
<?php echo number_format($row['SQFTTOTAL']); ?> sq. ft. </b></p>
						    <ul class="adr">
                              <li class="street-address"><?php echo $row['STREETNUM'] ?> <?php echo $row['STREETNAME'] ?></li>
						      <li><span class="locality"><?php echo $row['CITY']."," ?> <?php echo $row['STATE'] ?></span> <br/>
                                  <span class="region"><?php echo $row['COUNTY'] ?> County</span> <br/>
                                  <span class="postal-code"><?php echo $row['ZIPCODE'] ?></span></li><br/><br/><br/><br/><br/>
					        </ul>
						    <ul class="adr">
						    </ul>
						    </p>
                            </div><div align="left"><!--/#general-description-->
                      </div></div> <div align="left"><!--/#general-information-->
                        
					  <ul id="listing-photos" class="gallery_demo_unstyled">
							
<?php
			$photos = $rets->GetObject("Property", "Photo", "{$row['MLSNUM']}", "*", 1);
				foreach ($photos as $photo) {
						$listing = $photo['Content-ID'];
						$number = $photo['Object-ID'];
				
						if ($photo['Success'] == true) {
								echo "<li><a href='{$photo['Location']}'><img src='{$photo['Location']}' alt='' title=''  class='listing-photo photo' width='63' height='47' /></a></li>";
						}
						else {
							
						}
				}
				
							$photo = $rets->GetObject("Property", "Photo", "{$row['MLSNUM']}", "0", 1);
?>
					  </ul><!-- /#listing-photos -->
					  <div id="listing-description" class="vevent clearfix">
							<p><?php echo $row['REMARKS']; ?></p>
					  </div><!--/#listing-description-->
						<table align="left" class="clearfix" id="property-detail" style="margin-top: 8px" cellpadding="2" cellspacing="2">
							<thead>

								<tr>
									<th scope="col" colspan="2"  style="color: #0061CA;">About the Property</th>
									<th scope="col" colspan="2" style="color: #0061CA;">About the Area</th>
									<th scope="col" colspan="2" style="color: #0061CA;">Measurements</th>
								</tr>
							</thead>
							<tbody>

								<tr>
									<td class="title">MLS #:</td>
									<td><?php echo $row['MLSNUM']; ?></td>
									<td class="title">Mapsco:</td>
									<td><?php echo $row['MAPPAGE']; ?><?php echo $row['MAPCOORD']; ?></td>
									<td class="title">Lot Size:</td>

									<td><?php 
									switch($row['LOTSIZE']){
										case "LTSL.5-ACR":
											echo "Less than 0.5 Acre";
											break;
										case "LTS.5-.99A":
											echo "0.5 Acre to 0.99 Acre";
											break;
										case "LTS1-2.99A":
											echo "1 Acre to 2.99 Acre";
											break;
										case "LTS3-4.99A":
											echo "3 Acre to 4.99 Acre";
											break;
										case "LTS5-9.99A":
											echo "5 Acre to 9.99 Acre";
											break;
										case "LTSCND+TWN":
											echo "Condo/Townhome Lot";
											break;
										case "LTSZERO":
											echo "Zero Lot Line";
											break;
									}
									?>  	
                                    </td>
						    </tr>
								<tr>
									<td class="title">Price:</td>
									<td><?php echo "$".number_format($row['LISTPRICE']); ?></td>
									<td class="title">HOA Fees:</td>
									<td>None</td>

									<td class="title">Acres:</td>
									<td><?php echo $row['ACRES']; ?></td>
								</tr>
								<tr>
									<td class="title">Year Built:</td>
									<td><?php echo $row['YEARBUILT']; ?></td>
									<td class="title">City:</td>

									<td><?php echo $row['CITY']; ?></td>
									<td class="title">Living Room 1:</td>
									<td><?php echo $row['ROOMLIVING1LENGTH']."x".$row['ROOMLIVING1WIDTH'] ; ?></td>
								</tr>
								<tr>
									<td class="title">Bedrooms:</td>
									<td><?php echo $row['BEDS']; ?></td>

									<td class="title">State:</td>
									<td><abbr title="Texas"><?php echo $row['STATE']; ?></abbr></td>
									<td class="title">Living Room 2:</td>
									<td><?php echo $row['ROOMLIVING2LENGTH']."x".$row['ROOMLIVING2WIDTH'] ; ?></td>
								</tr>
								<tr>
									<td class="title">Bathrooms:</td>

									<td><?php echo $row['BATHSFULL']; ?></td>
									<td class="title">Subdivision:</td>
									<td><?php echo $row['SUBDIVISION']; ?></td>
									<td class="title">Living Room 3:</td>
									<td><?php echo $row['ROOMLIVING3LENGTH']."x".$row['ROOMLIVING3WIDTH'] ; ?></td>
								</tr>
								<tr>

									<td class="title">Type:</td>
									<td><?php 
									switch($row['PROPSUBTYPEDISPLAY']){
										case "RES-C":
									 		echo "Condo";
											break;
										case "RES-H":
											echo "Half Duplex";
											break;
										case "RES-S":
											echo "Single Family";
											break;
										case "RES-T":
											echo "Townhouse";
											break;
									}; ?></td>
									<td class="title">School District:</td>
									<td><?php echo $row['SCHOOLDISTRICT']; ?></td>
									<td class="title">Dining Room:</td>
									<td><?php echo $row['NUMDININGAREAS']; ?></td>

								</tr>
								<tr>
									<td class="title">Style:</td>
									<td><?php 
									switch($row['STYLE']){
										case "STYTRAD":
											echo "Traditional";
											break;
										case "STYSPLT-LV":
											echo "Split Level";
											break;
										case "STYCOLONIA":	
											echo "Colonial";
											break;
										case "STYA-FRAME":	
											echo "A-Frame";
											break;
										case "STYPRAIRIE":
											echo "Prairie";
											break;
										case "STYORIENTA":
											echo "Oriental";
											break;
										case "STYGEO+DOM":
											echo "Geo/Dome";
											break;
										case "STYSOUTHWS":	
											echo "Southwestern";
											break;
										case "STYRANCH":
											echo "Ranch";
											break;
										case "STYSTUDIO":
											echo "Studio Apartment";
											break;
										case "STYMED":
											echo "Mediterranean";
											break;
										case "STYEA-AMER":
											echo "Early American";
											break;
										case "STYVICT":
											echo "Victorian";
											break;
										case "STYTUDOR":
											echo "Tudor";
											break;
										case "STYSPAN":
											echo "Spanish";
											break;
										case "STYOTHER":
											echo "Other";
											break;
										case "STYENGLISH":
											echo "English";
											break;
										case "STYFLAT":
											echo "Flat";
											break;
										case "STYCONTEMP";
											echo "Contemporary/Modern";
											break;
										case "STYLOFT":
											echo "Loft Apartment";
											break;
										case "STYFRENCH":
											echo "French";
											break;
									}					
										; ?></td>
									<td class="title">Elementary:</td>
									<td><?php if ($row['SCHOOLTYPE1']=="E"){
										echo $row['SCHOOLNAME1'];
										} elseif($row['SCHOOLTYPE2']=="E"){
										echo $row['SCHOOLNAME2'];
										} elseif($row['SCHOOLTYPE3']=="E"){
										echo $row['SCHOOLNAME3'];
										} elseif($row['SCHOOLTYPE4']=="E"){
										echo $row['SCHOOLNAME4'];
													  }
									; ?></td>
									<td class="title">Kitchen:</td>

									<td><?php echo $row['NUMDININGAREAS']; ?></td>
								</tr>
								<tr>
									<td class="title">Stories:</td>
									<td><?php echo $row['STORIES']; ?></td>
									<td class="title">Middle School:</td>
									<td><?php if ($row['SCHOOLTYPE1']=="M"){
										echo $row['SCHOOLNAME1'];
										} elseif($row['SCHOOLTYPE2']=="M"){
										echo $row['SCHOOLNAME2'];
										} elseif($row['SCHOOLTYPE3']=="M"){
										echo $row['SCHOOLNAME3'];
										} elseif($row['SCHOOLTYPE4']=="M"){
										echo $row['SCHOOLNAME4'];
													  }
									; ?></td>

									<td class="title">Study:</td>
									<td><?php $study = $row['ROOMOTHER'];
									$searchs = array('SPRLIBR+ST','SPRGAMEROO','SPR2ND-MST','SPRSPA-RM','SPREXT-STO','SPRWINECEL','SPRSAUN+ST','SPRMUSIC','SPROTHER','SPREXERCIS','SPRDARK-RM','SPRSOL+SUN','SPRMEDIA','SPRUNFBONU','SPRMUD-RM');
									$replaces = array(' Library/Study',' Game Room',' Second Master',' Spa/Hot Tub Room',' Extra Storage Room',' Wine Cellar',' Sauna/Steam Room',' Music Room',' Other',' Exercise Room',' Dark Room',' Solarium/ Sunroom',' Media Room',' Unfinished Bonus Room',' Mud Room');
									$msgs = str_replace($searches,$replaces,$study);
									echo $msgs;
									?>
									</td>
								</tr>
								<tr>
									<td class="title">Garage:</td>
									<td><?php $Garage = $row['GARAGEDESC'];
									$search = array('PARSWING','PARNONE','PARGOLFCAR','PARUNCOV','PARWKBENCH','PARUNASSIG','PAROVERSIZ','PARREAR','PARCOVERED','PARPORT-CH','PAROTHER','PAROPENER','PARDETACH','PARATTACHE','PARSIDE','PARCONVERS','PARASSIGN','PARTANDEM','PARSINK','PAROUT-ENT','PARFRONT','PARCIRCLE');
									$replace = array(' Swing Drive',' None',' Golf Cart Garage',' Uncovered',' Workbench',' Unassigned',' Oversized',' Rear',' Covered',' Porte-Cochere',' Other',' Opener',' Detached',' Attached',' Side',' Garage Conversion',' Assign',' Tandem Style',' Has Sink in Garage',' Outside Entry',' Front',' Circle Drive');
									$msg=str_replace($search,$replace,$Garage);
									echo $msg;					

									?></td>
									<td class="title">High School:</td>

									<td><?php if ($row['SCHOOLTYPE1']=="H"){
										echo $row['SCHOOLNAME1'];
										} elseif($row['SCHOOLTYPE2']=="H"){
										echo $row['SCHOOLNAME2'];
										} elseif($row['SCHOOLTYPE3']=="H"){
										echo $row['SCHOOLNAME3'];
										} elseif($row['SCHOOLTYPE4']=="H"){
										echo $row['SCHOOLNAME4'];
													  }
									; ?></td>
									<td class="title">Utility Room:</td>
									<td><?php echo $row['ROOMUTILITYLENGTH']; ?>x<?php echo $row['ROOMUTILITYWIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title"># of Spaces:</td>
									<td><?php echo $row['GARAGECAP']; ?></td>

					<th scope="row" colspan="2" style="color: #0061CA;"><br />Special Features</th>
									<td class="title">Break:</td>
									<td><?php echo $row['ROOMBREAKFASTLENGTH']; ?>x<?php echo $row['ROOMBREAKFASTWIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title">Total Sq Ft:</td>
									<td><?php echo $row['SQFTTOTAL']; ?></td>

									<td colspan="2" rowspan="10">
					<p><strong>Pool:</strong>
					  <?php $pool = $row['POOLDESC'];
									$searchp = array('POLOTHER','POLDIVING','POLATT-SPA','POLPER-FEN','POLINGRN-G','POLSEP-SPA','POLINDOOR','POLLAP','POLCABANA','POLPLAY','POLINGRN-V','POLCLN-SYS','POLHEATED','POLABV-GRN','POLINGRN-F','POLCUST-CO');
									$replacep = array('Other','Diving','Attached Spa','Pool Perimeter Fence','In Ground Gunite','Separate Spa/Hot Tub','Indoor','Lap Pool','Cabana','Play Pool','In Ground Vinyl','Cleaning System','Heated','Above Ground','In Ground Fiber Glass','Custom Cover');
									$msgp = str_replace($searchp,$replacep,$pool);
									echo $msgh;
									?>
					</p>
					<p><strong>Community Features:</strong> <?php $comfeature = $row['COMMONFEATURES'];
									$searchcf = array('COMSAUNA','COMPOOL','COMGATED','COMRV-PRKN','COMOTHER','COMHANGAR','COMGUARDED','COMGOLF','COMTENNIS','COMPER-FEN','COMSPA','COMMARINA','COMLAKE+PN','COMGREENBL','COMSPRK-SY','COMJOG+BIK','COMHORSEFA','COMPARK','COMLND-STR','COMLAUNDRY','COMCAMP-GR','COMELEVATO','COMBOATRAM','COMPLAY-GR','COMCLUB-HS','COMRACQT-C');
									$replacecf = array('Sauna','Community Pool','Gated Entrance','RV Parking','Other','Public Hangar','Guarded Entrance','Golf','Tennis','Perimeter Fencing','Spa','Marina','Private Lake/Pond','Greenbelt','Comm Sprinkler System','Jogging Path/ Bike Path','Horse Facilities','Park','Landing Strip','Laundry','Campground','Common Elevator','Boat Ramp','Playground','Club House','Racquet Ball');
									$msgcf = str_replace($searchcf,$replacecf,$comfeature);
									echo $msgcf;
									?></p>
					<p><strong>Lot Features:</strong> <?php $lotfeature = $row['LOTDESC'];
									$searchlf = array('LTDTNK+PON','LTDINTERIO','LTDACREAGE','LTDUNDIVID','LTDCULTIV','LTDOTHER','LTDGOLF-LO','LTDCANAL','LTDPASTURE','LTDNO-BKYD','LTDIRREG','LTDGREENBL','LTDCORNER','LTDBKYDLAW','LTDSUBDIV','LTDSOMETRE','LTDHVYTREE','LTDCREEK','LTDWTR-VIE','LTDPAR-CUL','LTDRIV-FRN','LTDLANDSCP','LTDWTR-FRN','LTDADJGRNBLT','LTDHORSES','LTDCULDSAC');
									$replacelf = array('Tank/ Pond','Interior Lot','Acreage','Undivided','Cultivated','Other','Golf Course Lot','Canal','Pasture','No Backyard Grass','Irregular','Greenbelt','Corner','Lrg. Backyard Grass','Subdivision','Some Trees','Heavily Treed','Creek','Water/Lake View','Partially Cultivated','River Front','Landscaped','Water/Lake Front','Adjacent to Greenbelt','Horses Permitted','Cul De Sac);
									$msglf = str_replace($searchlf,$replacelf,$lotfeature');
									echo $msglf;
									?></p>

					</td>
									<td class="title">Other:</td>
									<td><?php echo $row['ROOMOTHER1LENGTH']; ?>x<?php echo $row['ROOMOTHER1WIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title">Foundation:</td>
									<td><?php $foundation = $row['FOUNDATION'];
										$searchf = array('FNDBOISDAR','FNDSLAB','FNDBASEMEN','FNDPIERBEA','FNDPILINGS','FNDOTHER','FNDP+B-SLA');
										$replacef = array('Bois DArc Post','Slab','Basement','Pier & Beam','Pilings','Other','Piered Beam Slab');
										$msgf = str_replace($searchf,$replacef,$foundation);
										echo $msgf;
									; ?></td>

									<td class="title">Other 2:</td>
									<td><?php echo $row['ROOMOTHER2LENGTH']; ?>x<?php echo $row['ROOMOTHER2WIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title">Roof:</td>
									<td><?php $roof= $row['ROOF'];
									$searchr = array('ROFTILE+SL','ROFFIBR-CM','ROFWOOD','ROFCOMP','ROFOVERLAY','ROFOTHER','ROFMETAL','ROFCONCRET','ROFBUILTUP','ROFTAR+GRA','ROFSHK-WOO','ROFSHK-MET');
									$replacer = array('Tile/Slate','Fiber Cement','Wood Shingle','Composition','Overlay','Other','Metal','Concrete','Built-Up','Tar/Gravel','Wood Shake','Shake Metal');
									$msgr = str_replace($searchr,$replacer,$roof);
									echo $msgr;
									?>
									</td>
									<td class="title">Master Bedroom:</td>

									<td><?php echo $row['ROOMMASTERBEDLENGTH']; ?>x<?php echo $row['ROOMMASTERBEDWIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title">Heat/Cool:</td>
									<td><?php $heat = $row['HEATSYSTEM'];
									$searchh = array('HACSPACEHT','HACHEAT-EL','HACAIR-GAS','HACELE-FLT','HACDIR-VEN','HACHUMIDIF','HACADD-W+H','HAC2+PIPE','HACNO-HEAT','HACHEAT-GA','HACZONED','HACAIR-ELE','HACGEOTHER','HACNO-AIR','HACHEATPUM','HACPANEL','HACWINDOW','HACGAS-JET','HACPROPANE','HACSOLAR','HACOTHER');
									$replaceh = array('Space Heater','Central Heat-Elec','Central Air-Gas','Electrostatic Air Filter','Direct Vent','Humidifier','Additional Water Heater(s)','Two(+) Pipe (Condo)','No Heat','Central Heat-Gas','Zoned','Central Air-Elec','Geotherm','No Air','Heat Pump','Panel/Floor/Wall','Window Unit','Gas Jets','Propane','Solar','Other');
									$msgh = str_replace($searchh,$replaceh,$heat);
									echo $msgh;
									?>
                                    </td>
									<td class="title">Master Bed Level:</td>
									<td><?php echo $row['ROOMMASTERBEDLEVEL']; ?></td>

								</tr>
								<tr>
									<td class="title">Fence:</td>
									<td><?php $fence = $row['FENCE'];
									$searchf = array('FENRAIL','FENAUTOGAT','FENPIPE','FENWOOD','FENDOG-RUN','FENSLCKWIR','FENVINYL','FENCHAIN','FENCROSS','FENROCK+ST','FENBRICK','FENPARTIAL','FENIRON','FENBARBWIR','FENOTHER','FENNONE');
									$replacef = array('Rail','Automatic Gate','Pipe','Wood','Dog Run','Slick/Smooth Wire','Vinyl','Chain Link','Cross Fenced','Rock/Stone','Brick','Partially Fenced','Iron','Barbed Wire','Other','None');
									$msgf = str_replace($searchf,$replacef,$fence);
									echo $msgf;
									?></td>
									<td class="title">Bedroom 2:</td>
									<td><?php echo $row['ROOMBED2LENGTH']; ?>x<?php echo $row['ROOMBED2WIDTH']; ?></td>
								</tr>

							</tbody>
						</table><br/>
			    <p id="listing-agent">&nbsp;</p>
			    <p><strong>Listing Agent:</strong> <?php echo $row['AGENTLIST_FULLNAME']; ?></p>
			    <p id="broker"><strong>Broker:</strong> <?php echo $row['OFFICELIST_OFFICENAM1']; ?></p>
					</div></div><div align="left"><!--/#listing-detail-->				</div></div><div align="left"><!--/#container-->

			</div></div><div align="left"><!--/#content -->		
	  </div></div><div align="left"><!--/#content-container--><!--footer-container-->
</div></div><div align="left"><!-- /#page -->
	

<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, { "basePath": "/" });
//--><!]]>
</script>
<script type="text/javascript">
	Cufon.replace('h4');
</script>

</div></body>
</html>
