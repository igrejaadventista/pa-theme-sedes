jQuery(function() {
    acf.add_filter('select2_args', function(args, $select, settings, field, instance) {
        // do something to args
        if(field.hasClass('acf-field-setting-fields'))
            args.tags = true;
    
        // return
        return args;
    });  
});