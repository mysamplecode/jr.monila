	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Real Estate Search</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="results.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<table class="style">
<form class="style" id="MLSform" name="MLSform" method="get" action="Search_Results.php">
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
        <option value="RES">All</option>
        <option value="S">Single Family</option>
        <option value="LSE">Residential Lease</option>
      </select>
    </td>
    <td colspan="2">
		<select name="city" tabindex="6" class="form-select" id="area" >
        <option value="0">Any</option>
        <option value="10">Addison/Far North Dallas</option>
        <option value="51">Allen</option>
        <option value="22">Carrollton</option>
        <option value="123">Colleyville</option>
        <option value="21">Coppell</option>
        <option value="12">East Dallas</option>
        <option value="55">Frisco</option>
        <option value="24">Garland</option>
        <option value="124">Grapevine</option>
        <option value="25">Highland Park/University Park</option>
        <option value="26">Irving</option>
        <option value="17">Knox/Henderson</option>
        <option value="53">McKinney</option>
        <option value="11">North Dallas</option>
        <option value="14">North Oak Cliff</option>
        <option value="18">Northeast Dallas</option>
        <option value="16">Northwest Dallas</option>
        <option value="17">Oak Lawn Area</option>
        <option value="20">Plano</option>
        <option value="23">Richardson</option>
        <option value="34">Rockwall</option>
        <option value="8">Rowlett</option>
        <option value="13">Southeast Dallas</option>
        <option value="125">Southlake</option>
        <option value="9">The Colony</option>
        <option value="132">West Lake Area</option>
        <option value="17">Turtle Creek</option>
        <option value="17">Uptown/Downtown</option>
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
        <option value="0">Any</option>
        <option value="1">1+</option>
        <option value="2">2+</option>
        <option value="3">3+</option>
        <option value="4">4+</option>
        <option value="5">5+</option>
        <option value="6">6+</option>
        <option value="7">7+</option>
        <option value="8">8+</option>
      </select>
    </td>
    <td>
      <select name="baths" tabindex="3" class="form-select" id="baths2" >
        <option value="0">Any</option>
        <option value="1">1+</option>
        <option value="2">2+</option>
        <option value="3">3+</option>
        <option value="4">4+</option>
        <option value="5">5+</option>
        <option value="6">6+</option>
        <option value="7">7+</option>
        <option value="8">8+</option>
      </select>
    </td>
    <td>
      <select name="lowest_price" tabindex="4" class="form-select" id="lowest_price" >
        <option value="0">No min.</option>
        <option value="1000">$1,000</option>
        <option value="3000">$3,000</option>
        <option value="5000">$5,000</option>
        <option value="25000">$25,000</option>
        <option value="50000">$50,000</option>
        <option value="75000">$75,000</option>
        <option value="100000">$100,000</option>
        <option value="125000">$125,000</option>
        <option value="150000">$150,000</option>
        <option value="175000">$175,000</option>
        <option value="200000">$200,000</option>
        <option value="225000">$225,000</option>
        <option value="250000">$250,000</option>
        <option value="275000">$275,000</option>
        <option value="300000">$300,000</option>
        <option value="325000">$325,000</option>
        <option value="350000">$350,000</option>
        <option value="400000">$400,000</option>
        <option value="425000">$425,000</option>
        <option value="450000">$450,000</option>
        <option value="475000">$475,000</option>
        <option value="500000">$500,000</option>
        <option value="550000">$550,000</option>
        <option value="600000">$600,000</option>
        <option value="650000">$650,000</option>
        <option value="700000">$700,000</option>
        <option value="750000">$750,000</option>
        <option value="800000">$800,000</option>
        <option value="850000">$850,000</option>
        <option value="900000">$900,000</option>
        <option value="950000">$950,000</option>
        <option value="1000000">$1 mil</option>
        <option value="1500000">$1.5 mil</option>
        <option value="2000000">$2 mil</option>
        <option value="2500000">$2.5 mil</option>
        <option value="3000000">$3 mil</option>
        <option value="3500000">$3.5 mil</option>
        <option value="4000000">$4 mil</option>
        <option value="4500000">$4.5 mil</option>
        <option value="5000000">$5 mil</option>
        <option value="5000001">$5 mil+</option>
      </select>
    </td>
    <td>
      
        <select name="highest_price" tabindex="5" class="form-select" id="highest_price" >
          <option value="0">No max.</option>
          <option value="1000">$1,000</option>
          <option value="3000">$3,000</option>
          <option value="5000">$5,000</option>
          <option value="25000">$25,000</option>
          <option value="50000">$50,000</option>
          <option value="75000">$75,000</option>
          <option value="100000">$100,000</option>
          <option value="125000">$125,000</option>
          <option value="150000">$150,000</option>
          <option value="175000">$175,000</option>
          <option value="200000">$200,000</option>
          <option value="225000">$225,000</option>
          <option value="250000">$250,000</option>
          <option value="275000">$275,000</option>
          <option value="300000">$300,000</option>
          <option value="325000">$325,000</option>
          <option value="350000">$350,000</option>
          <option value="400000">$400,000</option>
          <option value="425000">$425,000</option>
          <option value="450000">$450,000</option>
          <option value="475000">$475,000</option>
          <option value="500000">$500,000</option>
          <option value="550000">$550,000</option>
          <option value="600000">$600,000</option>
          <option value="650000">$650,000</option>
          <option value="700000">$700,000</option>
          <option value="750000">$750,000</option>
          <option value="800000">$800,000</option>
          <option value="850000">$850,000</option>
          <option value="900000">$900,000</option>
          <option value="950000">$950,000</option>
          <option value="1000000">$1 mil</option>
          <option value="1500000">$1.5 mil</option>
          <option value="2000000">$2 mil</option>
          <option value="2500000">$2.5 mil</option>
          <option value="3000000">$3 mil</option>
          <option value="3500000">$3.5 mil</option>
          <option value="4000000">$4 mil</option>
          <option value="4500000">$4.5 mil</option>
          <option value="5000000">$5 mil</option>
          <option value="no_limit">$5 mil+</option>
        </select>
      </td>
    </tr>
  </form>
</table>
</html>
