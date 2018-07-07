
$(document).ready(function(e) {
    
	$("#pic_right").click(function (){
		
	
		$("#pic_right").attr('src','images/sale-1.png');
		$("#pic_left").attr('src','images/rent-1.png');
		});
	$("#pic_left").click(function (){
		
		$("#pic_left").attr('src','images/sale-2.png');
		$("#pic_right").attr('src','images/rent-2.png');
		});	
	
});