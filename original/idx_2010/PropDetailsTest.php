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


$Property_Type=$_GET['property_type'];
$City=$_GET['city'];
$Beds=$_GET['beds'];
$Baths=$_GET['baths'];
$Lowest_Price=$_GET['lowest_price'];
$Highest_Price=$_GET['highest_price'];
$MLS=$_GET['MLS'];
if (is_numeric($_GET['pg'])) {
        $pgnum = ((int) $_GET['pg']);
}

else {
        $pgnum = 0;
        $errorMessage = "Invalid value for page number";

}


$result = mysql_query("SELECT * FROM residential WHERE MLSNUM = '{$MLS}' ")
 or die(mysql_error());


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MLS#: <?php echo $MLS; ?> - Joseph Molina</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index,follow" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png"/>
<link charset="utf-8" type="text/css" rel="stylesheet" media="all" href="results.css" />
<link rel="stylesheet" type="text/css" href="slideshow/style.css" />
</head>

<body id="www-jromlina-com" class="our-listings">
	<ul id="accessibility">
		<li><a href="#container">Skip to Content</a></li>
	</ul>
	<div id="nav">
			
		<ul id="primary-navigation">
			
		</ul><!-- /#primary-navigation-->
	</div><!--/#nav-->
	<div id="page">
		<div id="content-container">
			<div id="content" class="clearfix">
<?php
$row = mysql_fetch_array($result);	

?>
					<div id="container">
					<h2 id="page-title">Details on <?php echo $row['STREETNUM'] ?> <?php echo $row['STREETNAME'] ?></h2>
					<div id="listing-detail" class="vcard">
						<p><strong>MLS# <?php echo $row['MLSNUM'] ?></strong></p>
						<a href="" class="optional-link print"></a>

					  <ul id="listing-nav" class="clearfix">
							<li class="first-child"><a href="<?php $url="Search Results.php?pg=" . $pgnum ."&property_Type=".$Property_Type."&city=".$City."&beds=".$Beds."&baths=".$Baths."&lowest_price=".$Lowest_Price."&highest_price=".$Highest_Price."\" class=\"button url\>"; 
							echo $url;?>">Back to Listings</a></li>
						</ul><!--/#listing-nav--><!--/#general-information-->
                        
                        
<div id="gallery">
  <div id="imagearea">
    <div id="image">
      <a href="javascript:slideShow.nav(-1)" class="imgnav " id="previmg"></a>
      <a href="javascript:slideShow.nav(1)" class="imgnav " id="nextimg"></a>
    </div>
  </div>
  <div id="thumbwrapper">
    <div id="thumbarea">
      <ul id="thumbs">
        <li value="1"><img src="thumbs/1.jpg" width="179" height="100" alt="" /></li>
        <li value="2"><img src="thumbs/2.jpg" width="179" height="100" alt="" /></li>
        <li value="3"><img src="thumbs/3.jpg" width="179" height="100" alt="" /></li>
        <li value="4"><img src="thumbs/4.jpg" width="179" height="100" alt="" /></li>
        <li value="5"><img src="thumbs/5.jpg" width="179" height="100" alt="" /></li>
      </ul>
    </div>
  </div>
</div>                        
                        
                        
                        <div id="general-information" class="clearfix">
<div id="gallery">
  <div id="imagearea">
    <div id="image">
      <a href="javascript:slideShow.nav(-1)" class="imgnav " id="previmg"></a>
      <a href="javascript:slideShow.nav(1)" class="imgnav " id="nextimg"></a>
    </div>
  </div>
						    <h3><?php echo "$".number_format($row['LISTPRICE']); ?></h3>
						    <p> <span><?php echo $row['BEDS'] ?> bedroom, <?php echo $row['BATHSFULL'] ?> bath, <?php echo $row['CARPORTCAP']; ?> garage</span> <?php echo number_format($row['SQFTTOTAL']); ?> square feet </p>
						    <ul class="adr">
						      <li class="street-address"><?php echo $row['STREETNUM'] ?> <?php echo $row['STREETNAME'] ?></li>
						      <li><span class="locality"><?php echo $row['CITY'] ?></span>, <span class="region"><?php echo $row['COUNTY'] ?></span> <span class="postal-code"><?php echo $row['ZIPCODE'] ?></span></li>
					        </ul>
						    </p>
                            <br/><br/>
						    <a href="mailto:jae.choi@hospitality-solutions.co.nz?subject=I would like more info about a property I saw on JRMolina.com&amp;body=Here is the property details: <?php echo urlencode("http://localhost/MLS Search Form/Searchresults.php?MLS=".$mls); ?>" class="email button">E-mail Realtor</a> <a href="mailto:?subject=I found something interesting in JRMolina website &body=I think you'll like this property:%0D%0A%0D%0A<?php echo urlencode("http://localhost/MLS Search Form/Searchresults.php?MLS=".$mls); ?>0%0D%0A%0D%0AIf you are interested in checking it out, you can contact JRMolina & Taylor Realty Associates at  (214) 444-8289 or send them an e-mail at jae.choi@hospitality-solutions.co.nz.%0D%0A%0D%0AIf you'd like to see more listings from JRMolina & Taylor Realty Associates, you can visit their Web site at www.jromlina.com." class="optional-link">Or E-mail Property to a Friend</a> 
                          </div><!--/#general-description-->
                      </div> 
                        
  <div id="thumbwrapper">
    <div id="thumbarea">
      <ul id="thumbs">
							
<?php
			$photos = $rets->GetObject("Property", "Photo", "{$row['MLSNUM']}", "*", 1);
				foreach ($photos as $photo) {
						$listing = $photo['Content-ID'];
						$number = $photo['Object-ID'];
						$count=count($photo);
						if ($photo['Success'] == true) {
							for($i=1;$count<=$i;$i++){
								echo "<li class='$i'>";
							}
							echo "<img src='{$photo['Location']}' alt='' title=''  class='listing-photo photo' width='63' height='47' /></li>";
						}
						else {


							
						}
				}
				
							$photo = $rets->GetObject("Property", "Photo", "{$row['MLSNUM']}", "0", 1);
?>
      </ul>
    </div>
  </div>
</div>

						<div id="listing-description" class="vevent clearfix">
							<p><?php echo $row['REMARKS']; ?></p>
					  </div><!--/#listing-description-->
						<table id="property-detail" class="clearfix">
							<thead>

								<tr>
									<th scope="col" colspan="2">About the Property</th>
									<th scope="col" colspan="2">About the Area</th>
									<th scope="col" colspan="2">Measurements</th>
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
											echo "Less Than .5 Acre (not Zero)";
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
									<td class="title"><abbr title="Association">Assn</abbr>. Fees:</td>
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
									<td><?php echo $row['ROOMLIVING1LENGTH']."L x ".$row['ROOMLIVING1WIDTH']."W" ; ?></td>
								</tr>
								<tr>
									<td class="title">Bedrooms:</td>
									<td><?php echo $row['BEDS']; ?></td>

									<td class="title">State:</td>
									<td><abbr title="Texas"><?php echo $row['STATE']; ?></abbr></td>
									<td class="title">Living Room 2:</td>
									<td><?php echo $row['ROOMLIVING2LENGTH']." x ".$row['ROOMLIVING2WIDTH'] ; ?></td>
								</tr>
								<tr>
									<td class="title">Bathrooms:</td>

									<td><?php echo $row['BATHSFULL']; ?></td>
									<td class="title">Subdivision:</td>
									<td><?php echo $row['SUBDIVISION']; ?></td>
									<td class="title">Living Room 3:</td>
									<td><?php echo $row['ROOMLIVING3LENGTH']." x ".$row['ROOMLIVING3WIDTH'] ; ?></td>
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
									$searchs = array ('SPRLIBR+ST','SPRGAMEROO','SPR2ND-MST','SPRSPA-RM','SPREXT-STO','SPRWINECEL','SPRSAUN+ST','SPRMUSIC','SPROTHER','SPREXERCIS','SPRDARK-RM','SPRSOL+SUN','SPRMEDIA','SPRUNFBONU','SPRMUD-RM');
									$replaces = array('Library/Study','Game Room','Second Master','Spa/Hot Tub Room','Extra Storage Room','Wine Cellar','Sauna/Steam Room','Music Room','Other','Exercise Room','Dark Room','Solarium/ Sunroom','Media Room','Unfinished Bonus Room','Mud Room');
									$msgs = str_replace($searches,$replaces,$study);
									echo $msgs;
									?>
									</td>
								</tr>
								<tr>
									<td class="title">Garage:</td>
									<td><?php $Garage = $row['GARAGEDESC'];
									$search = array('PARSWING','PARNONE','PARGOLFCAR','PARUNCOV','PARWKBENCH','PARUNASSIG','PAROVERSIZ','PARREAR','PARCOVERED','PARPORT-CH','PAROTHER','PAROPENER','PARDETACH','PARATTACHE','PARSIDE','PARCONVERS','PARASSIGN','PARTANDEM','PARSINK','PAROUT-ENT','PARFRONT','PARCIRCLE');
									$replace = array('Swing Drive','None','Golf Cart Garage','Uncovered','Workbench','Unassigned','Oversized','Rear','Covered','Porte-Cochere','Other','Opener','Detached','Attached','Side','Garage Conversion','Assign','Tandem Style','Has Sink in Garage','Outside Entry','Front','Circle Drive');
									$msg=str_replace($search,$replace,$Garage);
									echo $msg;					

									?>
										</td>
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
									<td><?php echo $row['ROOMUTILITYLENGTH']; ?> x <?php echo $row['ROOMUTILITYWIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title"># of Spaces:</td>
									<td><?php echo $row['GARAGECAP']; ?></td>

					<th scope="row" colspan="2">Special Features</th>
									<td class="title">Break:</td>
									<td><?php echo $row['ROOMBREAKFASTLENGTH']; ?> x <?php echo $row['ROOMBREAKFASTWIDTH']; ?></td>
								</tr>
								<tr>
									<td class="title">Total Sq Ft:</td>
									<td><?php echo $row['SQFTTOTAL']; ?></td>

									<td colspan="2" rowspan="10">
					<p><strong>Pool</strong> <?php $pool = $row['POOLDESC'];
									$searchp = array('POLOTHER','POLDIVING','POLATT-SPA','POLPER-FEN','POLINGRN-G','POLSEP-SPA','POLINDOOR','POLLAP','POLCABANA','POLPLAY','POLINGRN-V','POLCLN-SYS','POLHEATED','POLABV-GRN','POLINGRN-F','POLCUST-CO');
									$replacep = array('Other','Diving','Attached Spa','Pool Perimeter Fence','In Ground Gunite','Separate Spa/Hot Tub','Indoor','Lap Pool','Cabana','Play Pool','In Ground Vinyl','Cleaning System','Heated','Above Ground','In Ground Fiber Glass','Custom Cover');
									$msgp = str_replace($searchp,$replacep,$pool);
									echo $msgh;
									?></p>
					<p><strong>Community Features</strong> <?php $comfeature = $row['COMMONFEATURES'];
									$searchcf = array('COMSAUNA','COMPOOL','COMGATED','COMRV-PRKN','COMOTHER','COMHANGAR','COMGUARDED','COMGOLF','COMTENNIS','COMPER-FEN','COMSPA','COMMARINA','COMLAKE+PN','COMGREENBL','COMSPRK-SY','COMJOG+BIK','COMHORSEFA','COMPARK','COMLND-STR','COMLAUNDRY','COMCAMP-GR','COMELEVATO','COMBOATRAM','COMPLAY-GR','COMCLUB-HS','COMRACQT-C');
									$replacecf = array('Sauna','Community Pool','Gated Entrance','RV Parking','Other','Public Hangar','Guarded Entrance','Golf','Tennis','Perimeter Fencing','Spa','Marina','Private Lake/Pond','Greenbelt','Comm Sprinkler System','Jogging Path/ Bike Path','Horse Facilities','Park','Landing Strip','Laundry','Campground','Common Elevator','Boat Ramp','Playground','Club House','Racquet Ball');
									$msgcf = str_replace($searchcf,$replacecf,$comfeature);
									echo $msgcf;
									?></p>
					<p><strong>Lot Features</strong> <?php $lotfeature = $row['LOTDESC'];
									$searchlf = array('LTDTNK+PON','LTDINTERIO','LTDACREAGE','LTDUNDIVID','LTDCULTIV','LTDOTHER','LTDGOLF-LO','LTDCANAL','LTDPASTURE','LTDNO-BKYD','LTDIRREG','LTDGREENBL','LTDCORNER','LTDBKYDLAW','LTDSUBDIV','LTDSOMETRE','LTDHVYTREE','LTDCREEK','LTDWTR-VIE','LTDPAR-CUL','LTDRIV-FRN','LTDLANDSCP','LTDWTR-FRN','LTDADJGRNBLT','LTDHORSES','LTDCULDSAC');
									$replacelf = array('Tank/ Pond','Interior Lot','Acreage','Undivided','Cultivated','Other','Golf Course Lot','Canal','Pasture','No Backyard Grass','Irregular','Greenbelt','Corner','Lrg. Backyard Grass','Subdivision','Some Trees','Heavily Treed','Creek','Water/Lake View','Partially Cultivated','River Front','Landscaped','Water/Lake Front','Adjacent to Greenbelt','Horses Permitted','Cul De Sac);
									$msglf = str_replace($searchlf,$replacelf,$lotfeature');
									echo $msglf;
									?></p>

					</td>
									<td class="title">Other:</td>
									<td><?php echo $row['ROOMOTHER1LENGTH']; ?> x <?php echo $row['ROOMOTHER1WIDTH']; ?></td>
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
									<td><?php echo $row['ROOMOTHER2LENGTH']; ?> x <?php echo $row['ROOMOTHER2WIDTH']; ?></td>
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

									<td><?php echo $row['ROOMMASTERBEDLENGTH']; ?> x <?php echo $row['ROOMMASTERBEDWIDTH']; ?></td>
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
									<td><?php echo $row['ROOMBED2LENGTH']; ?> x <?php echo $row['ROOMBED2WIDTH']; ?></td>
								</tr>

							</tbody>
						</table>
							<p id="listing-agent"><strong>Listing Agent:</strong> <?php echo $row['AGENTLIST_FULLNAME']; ?></p>
							<p id="broker"><strong>Broker:</strong> <?php echo $row['OFFICELIST_OFFICENAM1']; ?></p>
					</div><!--/#listing-detail-->				</div><!--/#container-->

			</div><!--/#content -->		
		</div><!--/#content-container-->
		<div id="footer-container">
			<div id="footer" class="clearfix">
				
				<ul id="utility-navigation">
					
				</ul><!-- /#utility-navigation-->
				<ul id="informational">
					<li>&copy; 2010 Hospitality Solutions Ltd. All Rights Reserved.</li>
					<li class="hat-tip"><a href="http://www.hck2.com/" title="Designed and Developed by HCK2 Partners">Designed and Developed by HCK2 Partners</a></li>
				</ul>
			</div><!--#footer-->

		</div><!--footer-container-->
	</div><!-- /#page -->


<script type="text/javascript">
var imgid = 'image';
var imgdir = 'fullsize';
var imgext = '.jpg';
var thumbid = 'thumbs';
var auto = true;
var autodelay = 5;
</script>
<script type="text/javascript" src="slide.js"></script>


	<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
<!--//--><![CDATA[//><!--
jQuery.extend(Drupal.settings, { "basePath": "/" });
//--><!]]>
</script>
<script type="text/javascript">
	Cufon.replace('h4');
</script>
</body>
</html>