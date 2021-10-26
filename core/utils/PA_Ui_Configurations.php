<?php
function taxonomy_config()
{
    register_setting(
        'group_config_taxonomies',
        'PA_Taxonomy_Host',
        array(
            'sanitize_callback' => function ($value) {
                if (!preg_match('%^((https?://)|(www\.))([a-z0-9-].?)+(:[0-9]+)?(/.*)?$%i', $value)) {
                    add_settings_error(
                        'PA_Taxonomy_Host',
                        esc_attr('PA_Taxonomy_Host_erro'),
                        'Servidor de taxonomia inválido.',
                        'error'
                    );
                    return get_option('PA_Taxonomy_Host');
                }
                return $value;
            },
        )
    );

    add_settings_section(
        'taxonomias',
        'Configuração',
        function ($args) {
            echo '<p>Configure o servidor de taxonomias.</p>';
        },
        'group_config_taxonomies'
    );

    add_settings_field(
        'PA_Taxonomy_Host',
        'Servidor:',
        function ($args) {
            $options = get_option('PA_Taxonomy_Host');
?>
        <input type="text" id="<?php echo esc_attr($args['label_for']); ?>" name="PA_Taxonomy_Host" value="<?php echo esc_attr($options); ?>">
    <?php
        },
        'group_config_taxonomies',
        'taxonomias',
        [
            'label_for' => 'PA_Taxonomy_Host_html_id',
            'class'     => 'classe-html-tr',
        ]
    );
}
add_action('admin_init', 'taxonomy_config');

function PA_Taxonomy_Host_Menu()
{
    add_options_page(
        'Taxonomias',
        'Taxonomias',
        'manage_options',
        'minhas-configuracoes',
        'taxonomy_config_html'
    );
}
add_action('admin_menu', 'PA_Taxonomy_Host_Menu');

function taxonomy_config_html()
{
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('group_config_taxonomies');
            do_settings_sections('group_config_taxonomies');
            submit_button();
            ?>
        </form>
    </div>
<?php
}
