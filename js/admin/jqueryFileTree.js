if(jQuery) (function(jQuery){
	
	jQuery.extend(jQuery.fn, {
		fileTree: function(o, h) {
			// Defaults
			if( !o ) var o = {};
			if( o.root == undefined ) o.root = null;
			if( o.postData == undefined ) o.postData = {};
			if( o.script == undefined ) o.script = 'jqueryFileTree.php';
			if( o.branchExpandEvent == undefined ) o.branchExpandEvent = 'click';
			if( o.branchEvent == undefined ) o.branchEvent = 'click';
			if( o.leafEvent == undefined ) o.leafEvent = 'click';
			if( o.expandSpeed == undefined ) o.expandSpeed= 500;
			if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
			if( o.expandEasing == undefined ) o.expandEasing = null;
			if( o.collapseEasing == undefined ) o.collapseEasing = null;
			if( o.multiFolder == undefined ) o.multiFolder = true;
			if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';
			
			jQuery(this).each( function() {
				
				function showTree(c, t) {
					jQuery(c).addClass('wait');
					jQuery(".jqueryFileTree.start").remove();
					o.postData.id = t;
					jQuery.post(o.script, o.postData, function(data) {
						jQuery(c).find('.start').html('');
						jQuery(c).removeClass('wait').append(data);
						if(data == ''){
							jQuery(c).find('.expander').hide();
						}
						if( o.root == t ){
							jQuery(c).find('UL:hidden').show();
						}else{
							jQuery(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
						}
						bindTree(c);
					});
				}
				
				function bindTree(t) {
					jQuery(t).find('LI.branch .text').bind(o.branchEvent, function() {	
						eval('var attributes=' + jQuery(this).parent().attr('rel'));
						h(attributes);
					});
					jQuery(t).find('LI.branch .expander').bind(o.branchExpandEvent, function() {
						if( jQuery(this).parent().hasClass('collapsed') ) {
							// Expand
							if( !o.multiFolder ) {
								jQuery(this).parent().parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
								jQuery(this).parent().parent().find('LI.branch').removeClass('expanded').addClass('collapsed');
							}
							jQuery(this).parent().find('UL').remove(); // cleanup
							eval('var attributes=' + jQuery(this).parent().attr('rel'));
							showTree( jQuery(this).parent(), escape(attributes.id) );
							jQuery(this).parent().removeClass('collapsed').addClass('expanded');
						} else {
							// Collapse
							jQuery(this).parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
							jQuery(this).parent().removeClass('expanded').addClass('collapsed');
						}
						return false;
					});
					
					jQuery(t).find('LI.leaf A').bind(o.branchEvent, function() {	
						h(jQuery(this).attr('rel'));
					});
							
					// Prevent A from triggering the # on non-click events
					if( o.branchExpandEvent.toLowerCase != 'click' ) jQuery(t).find('LI A').bind('click', function() { return false; });
				}
				// Loading message
				jQuery(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
				// Get the initial file list
				showTree( jQuery(this), escape(o.root) );
			});
		}
	});
	
})(jQuery);