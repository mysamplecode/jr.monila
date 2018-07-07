<?php
/* Available Fields

Definition			Fields
- Property
MLS#				['MLSNUM']
City				['CITY']
Address				['STREETNUM'] ['STREETNAME'] ['STREETNUMDISPLAY']
Zip Code			['ZIPCODE']
Subdivision			['SUBDIVISION']
Lowest				['LISTPRICE']
Highest				['LISTPRICE']
Beds				['BEDS']
Baths				['BATHSFULL']
Garage				['GARAGECAP']
Stories				['STORIES']
Fireplaces			['FIREPLACES']
Yard Size			['LOTSIZE']

- Location
Cities				['CITY']
Areas				['AREA']
Countries			['COUNTY']

- Schools
School District		['SCHOOLDISTRICT']
School Name			['SCHOOLNAME1'], ['SCHOOLNAME2'], ['SCHOOLNAME3'], ['SCHOOLNAME4']
School Type			['SCHOOLTYPE1'], ['SCHOOLTYPE2'], ['SCHOOLTYPE3'], ['SCHOOLTYPE4']
Elementary		E
Middle			M
Intermediate	I
High			H

- Essential Features
>Property
Guest Quarters			['EXTERIOR']	EXFGST-QUA
High Rise/Condominium	
Loft					['INTERIOR']	INFLOFT
Balcony					['EXTERIOR']	EXFBALCONY
Library or Study		['ROOMOTHER']	SPRLIBR+ST
Media Room				['ROOMOTHER']	SPRMEDIA

>Location
Gated Community			['COMMONFEATURES']	COMGATED	Gated Entrance
Golf Course Community	['COMMONFEATURES']	COMGOLF		Golf
Golf Course Lot			['LOTDESC']		LTDGOLF-LO		
Lake Front Lot			['LOTDESC']		LTDWTR-FRN		Water/Lake Front
Lake View				['LOTDESC']		LTDWTR-VIE		Water/Lake Front
Handicap Amminities		['HANDICAP']
Zero Lot Line			['LOT SIZE']	LTSZERO			
Horses Allowed			['LOTDESC']		LTDHORSES		Horses Permitted

>Fence
Wood					['FENCE']	
Iron					['FENCE']
Brick					['FENCE']
Rock					['FENCE']	Rock/Stone
Auto Gate				['FENCE']	Automatic Gate
None					['FENCE']	NULL

>Special Requirements
Pool - No Preference
Pool - Yes				['POOLYN']	Y
Pool - No				['POOLYN']	N

-Show Me
>Property With 
Photos					['PHOTOCOUNT']
Virtual Tour			['SPECIAL NOTES']

>These Property Types
Single Detached			['HOUSING TYPE']
Multi Family			"MUL"				MultiFamily
Townhome				['HOUSING TYPE']	Condo/Townhome
Condo					['HOUSING TYPE']	Condo/Townhome
Half Duplex				['PROPSUBTYPE']		RES-Half Duplex 
Residential Lease		"LSE"				Lease

>Only
JRM Properties			
Open Houses				[OPENHOUSEDATE] [OPENHOUSETIME]


-Residential- RES
List Status				['LISTSTATUS']

PROPERTY:LISTSTATUS_RES Lookup Values
Value	Short Value		
OPT		Active Option Contract	
KO		Active Kick Out	
WTH		Withdrawn	
EXP		Expired	
ACT		Active	
SLD		Sold	
CAN		Cancelled	
TOM		Temp Off Market
WS		Withdrawn Sublisting	 
PND		Pending	
CON		Active Contingent	 


-Lease- LSE
List Status				['LISTSTATUS']
PROPERTY:LISTSTATUS_LSE Lookup Values
Value	Short Value	Long Value
OPT	Active Option Contract	Active Option Contract
KO	Active Kick Out	Active Kick Out
WTH	Withdrawn	Withdrawn
EXP	Expired	Expired
ACT	Active	Active
CAN	Cancelled	Cancelled
LSE	Leased	Leased
TOM	Temp Off Market	Temp Off Market
WS	Withdrawn Sublisting	Withdrawn Sublisting
PND	Pending	Pending
CON	Active Contingent	Active Contingent



['ACRES'] => 0.1705 ['ACRESBOTTOMLAND'] => ['ACRESCULTIVATED'] => ['ACRESIRRIGATED'] => ['ACRESPASTURE'] => ['ACRESPRICE'] => 9941348 ['AGENTLIST'] => 0355708 ['AGENTLIST_FULLNAME'] => Frank Purcell ['AGENTSELL_FULLNAME'] => ['AGEXEMPTION'] => ['APPROVALNUM'] => ['AREA'] => 25 ['ASSOCFEE'] => ['ASSOCFEEINCLUDES'] => ['ASSOCFEEPAID'] => ['ASSUMPTION'] => Not Assumable ['BARN1LENGTH'] => ['BARN1WIDTH'] => ['BARN2LENGTH'] => ['BARN2WIDTH'] => ['BARN3LENGTH'] => ['BARN3WIDTH'] => ['BARNDESC'] => ['BATHSFULL'] => 4 ['BATHSFULLBASEMENT'] => ['BATHSFULLLEVEL1'] => 1 ['BATHSFULLLEVEL2'] => 3 ['BATHSFULLLEVEL3'] => ['BATHSHALF'] => 1 ['BATHSHALFBASEMENT'] => ['BATHSHALFLEVEL1'] => 1 ['BATHSHALFLEVEL2'] => ['BATHSHALFLEVEL3'] => ['BATHSTOTAL'] => 4.1 ['BEDS'] => 5 ['BLOCK'] => E ['BUILDING'] => ['BUILDINGNUM'] => ['BUS1'] => ['BUS2'] => ['BUS3'] => ['BUS4'] => ['CARPORTCAP'] => 0 ['CITY'] => University Park ['COMMONFEATURES'] => ['COMPLEXNAME'] => ['CONSTRUCTION'] => Brick ['COUNTY'] => Dallas ['COVEREDSPACESTOTAL'] => 2 ['CROPPROGRAM'] => ['CROPS'] => ['DIRECTIONS'] => Between Hillcrest and Athens on the north side of Westminster completely remodelled in 2007. ['EASEMENTS'] => ['ENERGY'] => Double Pane Windows, Gas Water Heater, Programmable Thermostat ['EQUIPMENT'] => Built-in Icemaker, Built-in Refrigerator/Freezer, Cooktop - Gas, Dishwasher, Disposal, Double Oven, Self Clean, Vent Mechanism, Warmer Oven Drawer, Other ['EXTERIOR'] => Gutters, Patio Covered, Sprinkler System ['FENCE'] => Automatic Gate, Wood ['FILLACRES'] => ['FILLAREA'] => ['FILLBLOCK'] => ['FILLCITY'] => ['FILLCOUNTY'] => ['FILLLEGAL'] => ['FILLLOTDEPTH'] => ['FILLLOTFRONTAGE'] => ['FILLLOTNUM'] => ['FILLLOTSQFT'] => ['FILLMAP'] => ['FILLMAPBOOK'] => ['FILLMAPCOORD'] => ['FILLMAPPAGE'] => ['FILLSCHOOLDISTRICT'] => ['FILLSQFTTOTAL'] => ['FILLSTREETNUMDISPLAY'] => ['FILLSUBAREA'] => ['FILLSUBDIVISION'] => ['FILLTAXID'] => ['FILLTAXUNEXEMPT'] => ['FILLUNITNUM'] => ['FILLYEARBUILT'] => ['FILLZIPCODE'] => ['FINANCEPROPOSED'] => Cash, Conventional ['FIREPLACEDESC'] => Gas Logs, Gas Starter, Wood Burning ['FIREPLACES'] => 2 ['FLOORS'] => Carpet, Marble, Wood Floor ['FORLEASE'] => Y ['FOUNDATION'] => Piered Beam Slab ['GARAGECAP'] => 2 ['GARAGEDESC'] => Attached, Opener, Rear ['GREENCERTIFICATION'] => ['GREENFEATURES'] => ['HANDICAP'] => ['HANDICAPYN'] => N ['HEATSYSTEM'] => Central Air-Elec, Central Heat-Gas, Zoned ['HOA'] => None ['HOUSINGTYPE'] => Single Detached ['INTERIOR'] => Built-in Wine Cooler, Cable TV Available, Decorative Lighting, Sound System Wiring, Other ['INTERNETADDRYN'] => Y ['INTERNETDISPLAYYN'] => Y ['INTERNETLIST_ALL'] => Members IDX Websites, NTREIS Translator, REALTOR.com, Syndicate Listing ['LANDLEASE'] => ['LEGAL'] => S M U Heights Blk E Lt 1 Int20 ['LISTPRICE'] => 1695000 ['LISTPRICELOW'] => 0 ['LISTPRICEORIG'] => 1695000 ['LISTPRICERANGE'] => N ['LISTSTATUS'] => Cancelled ['LISTSTATUSFLAG'] => ['LOTDESC'] => Landscaped ['LOTDIM'] => 55X135 ['LOTNUM'] => 1 ['LOTSIZE'] => Less Than .5 Acre (not Zero) ['MAPBOOK'] => DALLAS ['MAPCOORD'] => D ['MAPPAGE'] => 0035 ['MISCELLANEOUS'] => ['MLSNUM'] => 11325091 ['MODIFIED'] => 2010-04-14 13:36:38 ['MUDDISTRICT'] => N ['NUMBARN1STALLS'] => ['NUMBARN2STALLS'] => ['NUMBARN3STALLS'] => ['NUMBARNS'] => ['NUMDININGAREAS'] => 2 ['NUMLAKES'] => ['NUMLIVINGAREAS'] => 3 ['NUMPONDS'] => ['NUMRESIDENCE'] => ['NUMSTOCKTANKS'] => ['NUMWELLS'] => ['OFFICELIST'] => ABAR01 ['OFFICELIST_OFFICENAM1'] => Allie Beth Allman & Assoc. ['OFFICESELL_OFFICENAM2'] => ['OPENHOUSEDATE'] => ['OPENHOUSETIME'] => ['PARCELSMULTIPLE'] => N ['PHOTOAERIALAVAIL'] => ['PHOTOCOUNT'] => 0 ['PHOTODATE'] => ['PLANNEDDEVELOPMENT'] => ['POOLDESC'] => ['POOLYN'] => N ['POSSESSION'] => Negotiable ['PRESENTUSE'] => ['PROPOSEDUSE'] => ['PROPSUBTYPE'] => RES-Single Family ['PROPSUBTYPEDISPLAY'] => res-S ['PROPTYPE'] => Residential ['RANCHNAME'] => ['RANCHTYPE'] => ['REMARKS'] => Unbelieveable home has MASTER RETREAT DOWN with goregous new bath and fitted California closets. Meticulous attention has been lavished on this much loved home which was completely remodelled and expanded in 2007 to include a MEDIA ROOM, SEPARATE GAMEROOM and five full bedrooms.Open kitchen has center island,2 dishwashers,large builtin fridge and freezer, new cabinetry,double ovens,warming drawer and Viking gas range.Perfect for an executive. ['RESTRICTIONS'] => ['ROADFRONTAGE'] => ['ROADFRONTAGEDESC'] => ['ROOF'] => Composition ['ROOMBED2LENGTH'] => 14 ['ROOMBED2LEVEL'] => 2 ['ROOMBED2WIDTH'] => 14 ['ROOMBED3LENGTH'] => 14 ['ROOMBED3LEVEL'] => 2 ['ROOMBED3WIDTH'] => 14 ['ROOMBED4LENGTH'] => 14 ['ROOMBED4LEVEL'] => 2 ['ROOMBED4WIDTH'] => 12 ['ROOMBED5LENGTH'] => 15 ['ROOMBED5LEVEL'] => 2 ['ROOMBED5WIDTH'] => 14 ['ROOMBEDBATHDESC'] => Built-ins, Jetted Tub, Linen Closet, Separate Shower, Separate Vanities, Sitting Area in Master, Walk-in Closets ['ROOMBREAKFASTLENGTH'] => 12 ['ROOMBREAKFASTLEVEL'] => 1 ['ROOMBREAKFASTWIDTH'] => 12 ['ROOMDININGLENGTH'] => 15 ['ROOMDININGLEVEL'] => 1 ['ROOMDININGWIDTH'] => 15 ['ROOMGARAGELENGTH'] => 21 ['ROOMGARAGEWIDTH'] => 22 ['ROOMKITCHENDESC'] => Butlers Pantry, Granite /Granite Type Cntrtop, Island, Walk-in Pantry, Other ['ROOMKITCHENLENGTH'] => 18 ['ROOMKITCHENLEVEL'] => 1 ['ROOMKITCHENWIDTH'] => 15 ['ROOMLIVING1LENGTH'] => 14 ['ROOMLIVING1LEVEL'] => 1 ['ROOMLIVING1WIDTH'] => 12 ['ROOMLIVING2LENGTH'] => 19 ['ROOMLIVING2LEVEL'] => 1 ['ROOMLIVING2WIDTH'] => 19 ['ROOMLIVING3LENGTH'] => 17 ['ROOMLIVING3LEVEL'] => 2 ['ROOMLIVING3WIDTH'] => 13 ['ROOMMASTERBEDLENGTH'] => 18 ['ROOMMASTERBEDLEVEL'] => 1 ['ROOMMASTERBEDWIDTH'] => 15 ['ROOMOTHER'] => Media Room ['ROOMOTHER1LENGTH'] => 14 ['ROOMOTHER1LEVEL'] => 2 ['ROOMOTHER1WIDTH'] => 17 ['ROOMOTHER2LENGTH'] => ['ROOMOTHER2LEVEL'] => ['ROOMOTHER2WIDTH'] => ['ROOMSTUDYLENGTH'] => ['ROOMSTUDYLEVEL'] => ['ROOMSTUDYWIDTH'] => ['ROOMUTILDESC'] => Full Size W/D Area, Separate Room, Sink In Utility ['ROOMUTILITYLENGTH'] => 15 ['ROOMUTILITYLEVEL'] => 1 ['ROOMUTILITYWIDTH'] => 6 ['SCHOOLDISTRICT'] => Highland Park ISD ['SCHOOLNAME1'] => UNIVERSITY ['SCHOOLNAME2'] => MCCULLOCH ['SCHOOLNAME3'] => HIGHLANDPA ['SCHOOLNAME4'] => ['SCHOOLTYPE1'] => E ['SCHOOLTYPE2'] => I ['SCHOOLTYPE3'] => H ['SCHOOLTYPE4'] => ['SECURITY'] => Y ['SECURITYDESC'] => Burglar, Fire/Smoke ['SHOWING'] => Agent Or Owner Present ['SOILTYPE'] => ['SPECIALNOTES'] => ['SQFTPRICE'] => 351.81 ['SQFTSOURCE'] => Tax ['SQFTTOTAL'] => 4818 ['STATE'] => TX ['STORIES'] => 2 ['STORIESBLDG'] => ['STREETDIR'] => ['STREETDIRSUFFIX'] => ['STREETNAME'] => Westminster ['STREETNUM'] => 3320 ['STREETNUMDISPLAY'] => 3320 ['STREETTYPE'] => Avenue ['STYLE'] => English, Traditional ['SUBAREA'] => 12 ['SUBDIVIDE'] => No ['SUBDIVISION'] => S M U Heights ['SURFACERIGHTS'] => ['TAXID'] => 60192500050010000 ['TAXUNEXEMPT'] => ['TOPOGRAPHY'] => ['UID'] => 3213795 ['UIDPRP'] => 3213795 ['UNITFLOORNUM'] => ['UNITNUM'] => ['UTILITIES'] => City Sewer, City Water, Curbs, Sidewalk ['UTILITIESOTHER'] => ['VOWAVMYN'] => Y ['VOWCOMMYN'] => Y ['YEARBUILT'] => 1996 ['YEARBUILTDESC'] => Preowned ['ZIPCODE'] => 75205-1429





*/
?>