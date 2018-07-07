function strcmp(a, b)
{
    if ((typeof a === 'undefined' || a === null) || (typeof b === 'undefined' || b === null))
    {
        return null;
    }
    a = a.toString(), b = b.toString();
    for (var i = 0, n = Math.max(a.length, b.length); i < n && a.charAt(i) === b.charAt(i); ++i)
        ;
    if (i === n)
        return 0;
    return a.charAt(i) > b.charAt(i) ? -1 : 1;
}
function strpos(haystack, needle, offset) {
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

function change_value(id_val, matchstring, firstchng, secchng, fshow, fhide) {
    var element = $(id_val);
    if (strcmp(element.val(), matchstring) === 0) {
        element.val(firstchng);
        $(fshow).show();
        $(fhide).hide();
    }
    else
    {
        element.val(secchng);
        $(fhide).show();
        $(fshow).hide();
    }
}
function hideshow_child(id_val) {
    var element = $(id_val);
    if (element.css('display') === 'none') {
        element.show();
    }
    else
    {
        element.hide();
    }
}
function search_types(id, propval, zero, one, show, hideclick, childclick, hidevalues) {
    $(id).click(function() {
        change_value(propval, zero, one, zero, show, id);
    });
    $(hideclick).click(function() {
        change_value(propval, zero, one, zero, show, id);
    });
    $(childclick).click(function() {
        hideshow_child(hidevalues);
    });
}
function single_range_slider(id, minvalue, maxvalue, inputid, hinput, textshow) {

    jQuery(id).slider({
        range: "min",
        value: $(hinput).val(),
        min: parseInt($(minvalue).val()),
        max: parseInt($(maxvalue).val()),
        slide: function(event, ui) {
            var maxval = addCommas(ui.value);
            $(inputid).val(maxval);
            jQuery(textshow).text(maxval);
        }
    });
    jQuery(inputid).val(addCommas($(id).slider("values", 0)));
    jQuery(textshow).text(addCommas($(id).slider("values", 0)));
}

function val_in_one_range_slider(id, hminval, hmaxval, curr_min, hcurr, textshow) {
    var a;
    var b = $(hcurr).val();
    if (strpos(b, '-') !== false) {
        c = b.split('-');
        a = [parseInt(c[0]), parseInt(c[1])];
    } else {
        a = [parseInt($(hminval).val()), parseInt($(hmaxval).val())];
    }
    jQuery(id).slider({
        range: true,
        min: parseInt($(hminval).val()),
        max: parseInt($(hmaxval).val()),
        values: a,
        slide: function(event, ui) {
            var maxval = addCommas(ui.values[0]);
            var maxval1 = addCommas(ui.values[1]);
            $(curr_min).val(maxval + "-" + maxval1);
            //$(curr_max).val(maxval1);
            jQuery(textshow).text(maxval + " - " + maxval1);
        }
    });
    jQuery(curr_min).val(addCommas($(id).slider("values", 0)) + "-" + addCommas($(id).slider("values", 1)));
    //jQuery(curr_max).val(addCommas($(id).slider("values", 1)));
    jQuery(textshow).text(addCommas($(id).slider("values", 0)) + " - " + addCommas($(id).slider("values", 1)));
}

function double_range_slider(id, hminval, hmaxval, curr_min, hcurr_min, curr_max, hcurr_max, textshow) {
    var mins = parseInt($(hminval).val());
    var maxs = parseInt($(hmaxval).val());
    var a;
    var b = $(hcurr_min).val();
    var d;
    var e;
    var c = $(hcurr_max).val();
    if (strpos(b, ',') !== false && strpos(c, ',') !== false) {
        d = b.replace(',', '');
        e = c.replace(',', '');
        a = [parseInt(d), parseInt(e)];
        console.log(a);
    } else {
        a = [parseInt($(hcurr_min).val()), parseInt($(hcurr_max).val())];
    }
    jQuery(id).slider({
        range: true,
        min: mins,
        max: maxs,
        values: a,
        slide: function(event, ui) {
            var maxval = addCommas(ui.values[0]);
            var maxval1 = addCommas(ui.values[1]);
            $(curr_min).val(maxval);
            $(curr_max).val(maxval1);
            jQuery(textshow).text(maxval + " - " + maxval1);
        }
    });
    jQuery(curr_min).val(addCommas($(id).slider("values", 0)));
    jQuery(curr_max).val(addCommas($(id).slider("values", 1)));
    jQuery(textshow).text(addCommas($(id).slider("values", 0)) + " - " + addCommas($(id).slider("values", 1)));
}
function unique_double_range_slider(id, hminval, hmaxval, curr_min, hcurr_min, curr_max, hcurr_max, textshow) {
    jQuery(id).slider({
        range: true,
        min: parseInt($(hminval).val()),
        max: parseInt($(hmaxval).val()),
        values: [parseInt(hcurr_min), parseInt(hcurr_max)],
        slide: function(event, ui) {
            var maxval = addCommas(ui.values[0]);
            var maxval1 = addCommas(ui.values[1]);
            $(curr_min).val(maxval);
            $(curr_max).val(maxval1);
            jQuery(textshow).text(maxval + " - " + maxval1);
        }
    });
    jQuery(curr_min).val(addCommas($(id).slider("values", 0)));
    jQuery(curr_max).val(addCommas($(id).slider("values", 1)));
    jQuery(textshow).text(addCommas($(id).slider("values", 0)) + " - " + addCommas($(id).slider("values", 1)));
}

function double_range_slider_woc(id, hminval, hmaxval, curr_min, hcurr_min, curr_max, hcurr_max, textshow) {
    jQuery(id).slider({
        range: true,
        min: parseInt($(hminval).val()),
        max: parseInt($(hmaxval).val()),
        values: [parseInt($(hcurr_min).val()), parseInt($(hcurr_max).val())],
        slide: function(event, ui) {
            var maxval = ui.values[0];
            var maxval1 = ui.values[1];
            $(curr_min).val(maxval);
            $(curr_max).val(maxval1);
            jQuery(textshow).text(maxval + " - " + maxval1);
        }
    });
    jQuery(curr_min).val($(id).slider("values", 0));
    jQuery(curr_max).val($(id).slider("values", 1));
    jQuery(textshow).text($(id).slider("values", 0) + " - " + $(id).slider("values", 1));
}

function addCommas(str) {
    var amount = new String(str);
    amount = amount.split("").reverse();

    var output = "";
    for (var i = 0; i <= amount.length - 1; i++) {
        output = amount[i] + output;
        if ((i + 1) % 3 === 0 && (amount.length - 1) !== i)
            output = ',' + output;
    }
    return output;
}
function text_create(val, str, ht) {
    var a;

    if ($(ht).val() > 0) {
        a = $(ht).val();
    } else {
        a = 0;
    }
    //$(str).text("(" + a + ")");
    $(val).click(function() {
        if ($(this).is(':checked')) {
            a = a + 1;
            $(str).text("(" + a + ")");
        }
        else {
            if (a > 0) {
                a = a - 1;
                $(str).text("(" + a + ")");
            }
        }
    });
}
function radio_checked(val, str) {
    $(val).on("click", function() {
        $(str).html(ucfirst($(this).val()));
    });
}
function ucfirst(str) {
    str += '';
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}
function showValues(u, str, id, curr1, curr2)
{
    if (str === "")
    {
        double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', '#hminprice', '#maxprice', '#hmaxprice', '#values_clone_price');
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            a = JSON.parse(xmlhttp.responseText);
            if (a[0] !== null && a[1] !== null) {
                unique_double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', a[0], '#maxprice', a[1], '#values_clone_price');
                //           unique_double_range_slider(id, a[0], a[1], curr1, curr2);
            }
            else {
                alert('No record found.');
                //$('#errorfound').show('slow').delay(3000).fadeOut('slow');
                buy();
                double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', '#hminprice', '#maxprice', '#hmaxprice', '#values_clone_price');
            }
        }
    }
    xmlhttp.open("GET", u + str, true);
    xmlhttp.send();
}

function showValuesButton(u, str, id, curr1, curr2)
{
    if (str === "")
    {
        double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', '#hminprice', '#maxprice', '#hmaxprice', '#values_clone_price');
        return;
    }
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
        {
            a = JSON.parse(xmlhttp.responseText);
            if (a[0] !== null && a[1] !== null) {
                unique_double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', a[0], '#maxprice', a[1], '#values_clone_price');
                //           unique_double_range_slider(id, a[0], a[1], curr1, curr2);
            }
            else {
                alert('No result found.');
                double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', '#hminprice', '#maxprice', '#hmaxprice', '#values_clone_price');
            }
        }
    }
    xmlhttp.open("GET", u + str, true);
    xmlhttp.send();
}

function val_status(getid, showid, defaultid) {
    if ($(getid).val() !== '') {
        $(showid).html(ucfirst($(getid).val()));
    }
    radio_checked(defaultid, showid);

}

function tex_status(getid, showid) {
    if ($(getid).val() !== '') {
        $(showid).html("(" + $(getid).val() + ")");
    }

}
//functions end

$(window).load(function() {
    $('.onloadhide').hide();
    $('#mainslider').show();
    if ($('#citi_val').val() === "1") {
        $('#citi_show').show();
        $('#citis').hide();
    }
    if ($('#buylease_val').val() === "1") {
        $('#buylease_show').show();
        $('#buylease').hide();
    }
    if ($('#homesize_val').val() === "1") {
        $('#homesize_show').show();
        $('#homesize').hide();
    }
    if ($('#bedandbaths_val').val() === "1") {
        $('#bedandbaths_show').show();
        $('#bedandbaths').hide();
    }
    if ($('#price_val').val() === "1") {
        $('#price_show').show();
        $('#price').hide();
    }
    if ($('#lotsizes_val').val() === "1") {
        $('#lotsizes_show').show();
        $('#lotsizes').hide();
    }
    if ($('#yearbuilt_val').val() === "1") {
        $('#yearbuilt_show').show();
        $('#yearbuilt').hide();
    }
    if ($('#proptypes_val').val() === "1") {
        $('#proptypes_show').show();
        $('#proptypes').hide();
    }
    if ($('#price_val').val() === "1") {
        $('#price_show').show();
        $('#price').hide();
    }
    if ($('#parking_val').val() === "1") {
        $('#parking_show').show();
        $('#parking').hide();
    }
    if ($('#property_status_val').val() === "1") {
        $('#property_status_show').show();
        $('#property_status').hide();
    }
    if ($('#photos_count_val').val() === "1") {
        $('#photos_count_show').show();
        $('#photos_count').hide();
    }
    if ($('#openhouse_val').val() === "1") {
        $('#openhouse_show').show();
        $('#openhouse').hide();
    }



});
function buy() {
    $("#pic_right").attr('src', 'packages/jrmhtml/images/sale-1.png');
    $("#pic_left").css("height", '39px');
    $("#pic_left").css("margin-top", '0px');
    $("#pic_left").attr('src', 'packages/jrmhtml/images/rent-1.png');
    $('#buyorlease').val('buy');
    $("#city").val('');
    $("#search").val('');
    $('#citydiv').show('slow');
    $('#zipdiv').show('slow');
}
function lease() {
    $("#pic_left").attr('src', 'packages/jrmhtml/images/rent-2.png');
    $("#pic_left").css("height", '36px');
    $("#pic_left").css("margin-top", '1px');
    $("#pic_right").attr('src', 'packages/jrmhtml/images/sale-2.png');
    $('#buyorlease').val('lease');
    $("#city").val('');
    $("#search").val('');
    $('#citydiv').show('slow');
    $('#zipdiv').show('slow');
}
showValues("?r=JRMCities&buyorlease=", 'RES');
$(document).ready(function() {
    $('.onloadhide').hide();
    $('#buyorlease').val('buy');
    $("#pic_right").click(function() {
        buy();
        showValues("?r=JRMCities&buyorlease=", 'RES');
    });
    $("#pic_left").click(function() {
        lease();
        showValues("?r=JRMCities&buyorlease=", 'Residential Lease');
    });
    $("#accordion").accordion({
        collapsible: true,
        active: 'none'
    });
    //Add Aditional Criteria
    search_types("#buylease", "#buylease_val", '0', '1', '#buylease_show', "#buylease_hide", "#buylease1", '#buylease_values');
    search_types("#homesize", "#homesize_val", '0', '1', '#homesize_show', "#homesize_hide", "#homesize1", '#homesize_values');
    search_types("#bedandbaths", "#bedandbaths_val", '0', '1', '#bedandbaths_show', "#bedandbaths_hide", "#bedandbaths1", '#bedandbaths_values');
    search_types("#lotsizes", "#lotsizes_val", '0', '1', '#lotsizes_show', "#lotsizes_hide", "#lotsizes1", '#lotsizes_values');
    search_types("#dayslisted", "#dayslisted_val", '0', '1', '#dayslisted_show', "#dayslisted_hide", "#dayslisted1", '#dayslisted_values');
    search_types("#yearbuilt", "#yearbuilt_val", '0', '1', '#yearbuilt_show', "#yearbuilt_hide", "#yearbuilt1", '#yearbuilt_values');
    search_types("#pricedrops", "#pricedrops_val", '0', '1', '#pricedrops_show', "#pricedrops_hide", "#pricedrops1", '#pricedrops_values');
    search_types("#proptypes", "#proptypes_val", '0', '1', '#proptypes_show', "#proptypes_hide", "#proptypes1", '#proptypes_values');
    search_types("#price", "#price_val", '0', '1', '#price_show', "#price_hide", "#price1", '#price_values');
    search_types("#features", "#features_val", '0', '1', '#features_show', "#features_hide", "#features1", '#features_values');
    search_types("#schoolsdist", "#schoolsdist_val", '0', '1', '#schoolsdist_show', "#schoolsdist_hide", "#schoolsdist1", '#schoolsdist_values');
    search_types("#foreclosures", "#foreclosures_val", '0', '1', '#foreclosures_show', "#foreclosures_hide", "#foreclosures1", '#foreclosures_values');
    search_types("#parking", "#parking_val", '0', '1', '#parking_show', "#parking_hide", "#parking1", '#parking_values');
    search_types("#property_status", "#property_status_val", '0', '1', '#property_status_show', "#property_status_hide", "#property_status1", '#property_status_values');
    search_types("#photos_count", "#photos_count_val", '0', '1', '#photos_count_show', "#photos_count_hide", "#photos_count1", '#photos_count_values');
    search_types("#openhouse", "#openhouse_val", '0', '1', '#openhouse_show', "#openhouse_hide", "#openhouse1", '#openhouse_values');
    search_types("#citis", "#citi_val", '0', '1', '#citi_show', "#citi_hide", "#citi1", '#citi_values');
    //single range slider
    //single_range_slider("#slider-range-1", '#hminbed_min', '#hminbed_max', '#minbed', '#hminbed', '#values_clone_bed');
    //single_range_slider("#slider-range-2", '#hminbath_min', '#hminbath_max', '#minbath', '#hminbath', '#values_clone_baths');
    single_range_slider("#slider-range-maxgaragespaces", '#hminmaxgaragespaces_min', '#hminmaxgaragespaces_max', '#maxgaragespaces', '#hminmaxgaragespaces');
    single_range_slider("#slider-range-totalspaces", '#hmintotalspaces_min', '#hmintotalspaces_max', '#totalspaces', '#hmintotalspaces');
    val_in_one_range_slider("#slider-range-1", '#hminbed_min', '#hminbed_max', '#minbed', '#hminbed', '#values_clone_bed');
    val_in_one_range_slider("#slider-range-2", '#hminbath_min', '#hminbath_max', '#minbath', '#hminbath', '#values_clone_baths');
    //double range slider
    double_range_slider('#slider-range-price', '#hminprice_min', '#hmaxprice_max', '#minprice', '#hminprice', '#maxprice', '#hmaxprice', '#values_clone_price');
    double_range_slider('#slider-range-homesize', '#hminhomesize_min', '#hmaxhomesize_max', '#minhomesize', '#hminhomesize', '#maxhomesize', '#hmaxhomesize', '#values_clone_home');
    double_range_slider('#slider-range-lotsize', '#hminlotsize_min', '#hmaxlotsize_max', '#minlotsize', '#hminlotsize', '#maxlotsize', '#hmaxlotsize', '#values_clone_lotsizes');
    double_range_slider_woc('#slider-range-yearbuilt', '#hminyearbuilt_min', '#hmaxyearbuilt_max', '#minyearbuilt', '#hminyearbuilt', '#maxyearbuilt', '#hmaxyearbuilt', '#values_clone_yearbuilt');

    //text for search page
    text_create('.property_checked', '#values_clone_proptypes', '#totalselectedprops');
    text_create('.checkedstatus', '#values_clone_property_status', '#totalselectedstatus');
    //radio texts
    val_status('#text_status', '#values_clone_openhouse', '.radio_checked');
    val_status('#buyvalstatus', '#values_clone_buylease', '.clicked');
    //
    tex_status('#totalselectedstatus', '#values_clone_property_status');
    tex_status('#totalselectedprops', '#values_clone_proptypes');
    $('#values_clone_citi').html($('#citivalues').val());
    $('#citi').change(function() {
        $('#values_clone_citi').html($('#citi').val());
    });
    //form submit search page
    $('#totalresults, #submit_form').click(function() {
        var checkif01 = $('#citi_val').val();
        var checkif0 = $('#buylease_val').val();
        var checkif1 = $('#homesize_val').val();
        var checkif2 = $('#bedandbaths_val').val();
        var checkif3 = $('#lotsizes_val').val();
        var checkif4 = $('#dayslisted_val').val();
        var checkif5 = $('#yearbuilt_val').val();
        var checkif6 = $('#pricedrops_val').val();
        var checkif8 = $('#proptypes_val').val();
        var checkif9 = $('#mlsno_search').val();
        var checkif10 = $('#price_val').val();
        var checkif11 = $('#features_val').val();
        var checkif12 = $('#schoolsdist_val').val();
        var checkif13 = $('#foreclosures_val').val();
        var checkif14 = $('#parking_val').val();
        var checkif15 = $('#property_status_val').val();
        var checkif16 = $('#photos_count_val').val();
        var checkif17 = $('#openhouse_val').val();
        if (checkif01 === '1' || checkif0 === '1' || checkif1 === '1' || checkif2 === '1' || checkif3 === '1' || checkif4 === '1' || checkif5 === '1' || checkif6 === '1' || checkif8 === '1'
                || checkif10 === '1' || checkif11 === '1' || checkif12 === '1' || checkif13 === '1' || checkif14 === '1' || checkif15 === '1' || checkif16 === '1' || checkif17 === '1')
        {
            $('#adv_search').submit();
        } else if (checkif9 !== "") {
            $('#adv_search').submit();
        } else {
            $('#errorfound').show('slow').delay(3000).fadeOut('slow');
        }

    });
    $('#resetform').click(function() {
        $('.resetvalue').val(0);
        $('.closeall').hide();
        $('.showall').show();
    });
    $('#saveform').click(function() {
        window.open();
    });
    $('#citi').val($('#citivalues').val());

    //home page

    $('#search').on('click change keyup', function() {
        var sval = $('#search').val();
        var citydiv = $('#citydiv');
        if (sval !== "")
        {
            citydiv.hide('slow');
            // $('.hie').hide();
        } else
        {
            citydiv.show('slow');
            //    $('.hie').show();
        }
    });
    $('#city').on('click change keyup', function() {
        var cval = $('#city').val();
        var zipdiv = $('#zipdiv');
        if (cval !== "")
        {
            zipdiv.hide('slow');
            //  $('.hie').hide();
        } else
        {
            zipdiv.show('slow');
            // $('.hie').show();
        }
    });
    $('#city').change(function() {
        var a = 'RES';
        if ($('#buyorlease').val() === 'buy') {
            a = 'RES';
        } else {
            a = 'Residential Lease';
        }
        showValues("?r=JRMCities&city=", $('#city').val() + "&buyorlease=" + a, '#slider-range-price', '#minprice', '#maxprice');
    });
    $('#search').change(function() {
        var a = 'RES';
        if ($('#buyorlease').val() === 'buy') {
            a = 'RES';
        } else {
            a = 'Residential Lease';
        }
        showValues("?r=JRMCities&zip=", $('#search').val() + "&buyorlease=" + a, '#slider-range-price', '#minprice', '#maxprice');
    });

    if ($('.communityLandingItemWrapper').length > 0) {

        $('.communityLandingItemWrapper').hover(function() {
            $(this).find('.overlay p').stop(true, true).show();
        }, function() {
            $(this).find('.overlay p').stop(true, true).hide();
        });
    }
    var dallas = $('.thumbview');
    var suburbs = $('.thumbview1');
    var newlisting = $('.thumbview12');
    var recentlyreduced = $('.thumbview123');
    suburbs.hide();
    newlisting.hide();
    recentlyreduced.hide();
    $('.urbandallas').click(function() {
        dallas.show();
        suburbs.hide();
        newlisting.hide();
        recentlyreduced.hide();
    });
    $('.urbansuburbs').click(function() {
        dallas.hide();
        suburbs.show();
        newlisting.hide();
        recentlyreduced.hide();
    });
    $('.new_listing').click(function() {
        dallas.hide();
        suburbs.hide();
        newlisting.show();
        recentlyreduced.hide();
    });
    $('.recentlyreduced').click(function() {
        dallas.hide();
        suburbs.hide();
        newlisting.hide();
        recentlyreduced.show();
    });
    $('#photos_show').hide();
    $('#propertydetails').click(function() {
        $('#propertydetails_show').show();
        $('#photos_show').hide();
    });
    $('#photos').click(function() {
        $('#photos_show').show();
        $('#propertydetails_show').hide();
    });

    var currentPosition = 0;
    var slideTop = 494;
    var slides = $('.slide');
    var numberOfSlides = slides.length;

    // Remove scrollbar in JS
    $('#slidesContainer').css('overflow', 'hidden');

    // Wrap all .slides with #slideInner div
    slides
            .wrapAll('<div id="slideInner"></div>')
            // Float left to display horizontally, readjust .slides width
            .css({
                'float': 'top',
                'height': slideTop
            });

    // Set #slideInner width equal to total width of all slides
    $('#slideInner').css('height', slideTop * numberOfSlides);

    // Insert controls in the DOM
    $('#slideshow')
            .prepend('<div class="up_arrow_outer control" id="leftControl"><a id="testhideshow" href="javascript:void(0)"><img src="packages/jrmhtml/images/arrow_up.png" /></a></div>')
            .append('<div class="up_arrow_outer control" id="rightControl"><a id="testhideshow1" href="javascript:void(0)"><img src="packages/jrmhtml/images/arrow_down.png" /></a></div>');

    // Hide left arrow control on first load
    manageControls(currentPosition);

    // Create event listeners for .controls clicks
    $('.control')
            .bind('click', function() {
                // Determine new position
                currentPosition = ($(this).attr('id') === 'rightControl') ? currentPosition + 1 : currentPosition - 1;

                // Hide / show controls
                manageControls(currentPosition);
                // Move slideInner using margin-left
                $('#slideInner').animate({
                    'marginTop': slideTop * (-currentPosition)
                });
            });

    // manageControls: Hides and Shows controls depending on currentPosition
    function manageControls(position) {
        // Hide left arrow if position is first slide
        if (position === 0) {
            $('#leftControl').hide();
        } else {
            $('#leftControl').show();
        }
        // Hide right arrow if position is last slide
        if (position === numberOfSlides - 1) {
            $('#rightControl').hide();
        } else {
            $('#rightControl').show();
        }
    }

    $('.grow').on('mouseenter', function() {
        var div = $(this);
        div.stop(true, true).animate({
            margin: -30,
            width: "+=60",
            height: "+=60"
        }, 'fast');

    }).on('mouseleave', function() {
        var div = $(this);
        div.stop(true, true).animate({
            margin: 0,
            width: "-=60",
            height: "-=60"
        }, 'fast');
    });
});
jQuery(document).ready(function() {
    $('.onloadhide').hide();
    if ($('#citi_val').val() === "1") {
        $('#citi_show').show();
        $('#citis').hide();
    }
    if ($('#buylease_val').val() === "1") {
        $('#buylease_show').show();
        $('#buylease').hide();
    }
    if ($('#homesize_val').val() === "1") {
        $('#homesize_show').show();
        $('#homesize').hide();
    }
    if ($('#bedandbaths_val').val() === "1") {
        $('#bedandbaths_show').show();
        $('#bedandbaths').hide();
    }
    if ($('#price_val').val() === "1") {
        $('#price_show').show();
        $('#price').hide();
    }
    if ($('#lotsizes_val').val() === "1") {
        $('#lotsizes_show').show();
        $('#lotsizes').hide();
    }
    if ($('#yearbuilt_val').val() === "1") {
        $('#yearbuilt_show').show();
        $('#yearbuilt').hide();
    }
    if ($('#proptypes_val').val() === "1") {
        $('#proptypes_show').show();
        $('#proptypes').hide();
    }
    if ($('#price_val').val() === "1") {
        $('#price_show').show();
        $('#price').hide();
    }
    if ($('#parking_val').val() === "1") {
        $('#parking_show').show();
        $('#parking').hide();
    }
    if ($('#property_status_val').val() === "1") {
        $('#property_status_show').show();
        $('#property_status').hide();
    }
    if ($('#photos_count_val').val() === "1") {
        $('#photos_count_show').show();
        $('#photos_count').hide();
    }
    if ($('#openhouse_val').val() === "1") {
        $('#openhouse_show').show();
        $('#openhouse').hide();
    }
    jQuery('#tabs').removeClass('onloadhide');
    jQuery('#tabs').show();
});
