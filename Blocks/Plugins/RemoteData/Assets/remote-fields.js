(function($) {
	if(typeof acf == 'undefined')
		return;
	
    acf.add_filter('select2_args', function(args, $select, settings, field, instance) {
        // do something to args
        if(field.data('name') == 'fields' || field.data('name') == 'endpoints')
            args.tags = true;
    
        // return
        return args;
    });  
})(jQuery);
