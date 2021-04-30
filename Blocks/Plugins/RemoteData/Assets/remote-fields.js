(function($) {
    acf.add_filter('select2_args', function(args, $select, settings, field, instance) {
        // do something to args
        if(field.data('name') == 'fields')
            args.tags = true;
    
        // return
        return args;
    });  
})(jQuery);