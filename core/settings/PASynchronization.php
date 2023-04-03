<?php

namespace Core\Settings;

class PASynchronization {

  public function __construct() {
    add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'));
    add_action('admin_menu',            array($this, 'createMenu'));
    add_action('admin_bar_menu',        array($this, 'addToolbar'), 999);
  }
  
  /**
   * enqueueAdminAssets Enqueues scripts for admin
   *
   * @return void
   */
  function enqueueAdminAssets(): void {
    wp_enqueue_script('sync-admin-script', get_template_directory_uri() . '/core/assets/scripts/admin.js', array('jquery'));
  }
  
  /**
   * createMenu Create a new menu item
   *
   * @return void
   */
  function createMenu(): void {
    add_options_page(
      __('Synchronization', 'iasd'),
      __('Synchronization', 'iasd'),
      'manage_options',
      'synchronization',
      array($this, 'renderPage')
    );
  }
  
  /**
   * renderPage Render the page
   *
   * @return void
   */
  function renderPage(): void {
    ?>
    <div class="wrap">
      <h1><?= __('Synchronization', 'iasd') ?></h1>
      <p><?= __('Sync site data', 'iasd') ?></p>

      <h2><?= __('Blocks', 'iasd') ?></h2>
      <p><?= __('Sync blocks data', 'iasd') ?></p>
      <button class="button button-primary" onclick="syncBlocks(event)"><?= __('Sync', 'iasd') ?></button>

      <h2><?= __('Taxonomies', 'iasd') ?></h2>
      <p><?= __('Sync taxonomies data', 'iasd') ?></p>
      <button class="button button-primary" onclick="syncTaxonomies(event)"><?= __('Sync', 'iasd') ?></button>
    </div>
    <?php
  }
  
  /**
   * addToolbar Adds a toolbar tom run synchronization
   *
   * @param  object $wp_admin_bar The toolbar object
   * 
   * @return void
   */
  function addToolbar(object $wp_admin_bar): void {
    $wp_admin_bar->add_node([
        'id'    => 'sync_remote_data',
        'title' => __('Sync data', 'iasd'),
        'href'  => '#',
        'meta'  => [
            'onclick' => 'syncRemoteData(event)',
        ],
    ]);

    $wp_admin_bar->add_node([
      'id'     => 'sync_blocks',
      'title'  => __('Sync blocks', 'iasd'),
      'parent' => 'sync_remote_data',
      'href'   => '#',
      'meta'   => [
          'onclick' => 'syncBlocks(event)',
      ],
    ]);

    $wp_admin_bar->add_node([
      'id'     => 'sync_taxonomies',
      'title'  => __('Sync taxonomies', 'iasd'),
      'parent' => 'sync_remote_data',
      'href'   => '#',
      'meta'   => [
          'onclick' => 'syncTaxonomies(event)',
      ],
    ]);
  }

}

new PASynchronization;
