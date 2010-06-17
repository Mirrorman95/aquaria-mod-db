$(function() {
	var headerMenuHomeLink = $('#menu li a').first();
	
	if($('#menu li.current').length) {
		var headerMenuHighlightDefaultCSS = {
				backgroundPositionX: $('#menu li.current').first().find('a').css('backgroundPositionX'),
				width: $('#menu li.current').first().find('a').width(),
				left: $('#menu li.current').first().find('a').offset().left-$("#menu").offset().left
			};
	} else {
		var headerMenuHighlightDefaultCSS = {backgroundPositionX: 0, width: 0, left: 0};
	}
	
	var headerMenuHighlight = $('<li></li>')
		.css({
				position: 'absolute',
				backgroundPositionY: 50, height: 50, top: 0,
				backgroundImage: $(headerMenuHomeLink).css('backgroundImage')
			}).css(headerMenuHighlightDefaultCSS).prependTo('#menu');
	
	$('#header h1 a').hover(function() {
		$(headerMenuHomeLink).mouseenter();
	}, function() {
		$(headerMenuHomeLink).mouseleave();
	});
	
	$('#menu li a').hover(function() {
		$(this).stop(true).animate({color: '#abb4eb'}, {duration: 'fast'});
		$(headerMenuHighlight).stop(true).animate({
				backgroundPositionX: $(this).css('backgroundPositionX'),
				height: 50, width: $(this).width(),
				left: $(this).offset().left-$("#menu").offset().left
			}, {duration: 'normal', easing: 'easeOutBack'});
	}, function() {
		$(this).stop(true).animate({color: '#727fd8'}, {duration: 'slow'});
		$(headerMenuHighlight).stop(true).animate(headerMenuHighlightDefaultCSS, {duration: 'slow', easing: 'easeOutBounce'});
	});
});