<div class="col-auto d-flex align-items-center pa-header-logo">
    <a href="<?= get_home_url(); ?>" class="py-3 w-auto h-100">
        <img src="<?= get_template_directory_uri() . "/assets/sedes/" . LANG . "/" . $args['campo']->slug . ".svg" ?>" alt="<?= !empty($args['campo']->name) ? $args['campo']->name : '' ?>" title="<?= !empty($args['campo']->name) ? $args['campo']->name : '' ?>" class="h-100 w-auto">
    </a>
</div>