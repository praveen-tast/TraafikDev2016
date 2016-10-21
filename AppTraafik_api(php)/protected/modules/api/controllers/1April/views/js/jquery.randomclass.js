/*
 * RandomClass - 	A jQuery plugin to add a random class from a selection of classes to an element.
 * 
 * Copyright (c) 2010 Fredi Bach
 * www.fredibach.ch
 *
 * Usage:

	$("p span").randomClass( [ 'color1','color2','color3' ] );
 
 * Or with options:

	$("p span").randomClass( [ 'color1','color2','color3' ], { randomness: 'pattern', removeClasses: true } );

 * Plugin page: http://fredibach.ch/jquery-plugins/randomclass.php
 *
 */
(function($) {
	
	$.fn.randomClass=function(classes,settings){
		var defaults = {
			randomness: 'default',
			removeClasses: false
		};
		var s = $.extend(defaults, settings);
		
		if (s.randomness == 'pattern'){
			classes = shuffle(classes);
		}
		
		var p = -1;
		var cnt = 0;
		
		this.each( function() {
			if (s.removeClasses){
				for (c in classes){
					var cn = classes[c];
					if ( $(this).hasClass(cn) ){
						$(this).removeClass(cn);
					}
				}
			}
			if (s.randomness == 'pattern'){
				cnt++;
				$(this).addClass(classes[cnt%classes.length]);
			} else {
				do {
					var r = Math.floor(Math.random() * classes.length);
				} while (p == r && s.randomness == 'successive');
				
				$(this).addClass(classes[r]);
				p = r;
			}
		});
		
		shuffle = function(o){
			for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
			return o;
		};
		
		return this;
	};
	
})(jQuery);