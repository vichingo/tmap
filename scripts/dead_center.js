/**
 * @author milo
 */
$(function(){
	
	var coffin 		= $('#deadCenterBox');
	
	//get the heights
	var w_height 	= $(document).height();
	var box_height 	= coffin.height();
	
	console.log(w_height+ ', ' +box_height);
	
	//get the widths
	var w_width		= $(document).width();
	var box_width	= coffin.width();
		
	console.log(w_width+ ', ' +box_width);
	
	coffin.css({
		'position'	:'relative',
		'top'		: (w_height/2) - (box_height/2),
		'left'		: (w_width/2) - (box_width/2)
	});
});
