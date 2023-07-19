<?php

use IASD\Core\Settings\Modules;

if(Modules::isActiveModule('headertitle')): ?>
  <section class="pa-header py-3">
    <header class="container">
      <div class="row">
        <div class="col py-5">
        <?php if (!is_home() || !is_front_page()){ ?>
          <span class="pa-tag rounded-1 px-3 py-1 d-table-cell"><?php $PA_Header_Title = new PaHeaderTitle('tag'); ?></span>
        <?php }?>
          <h1 class="mt-2"><?php $PA_Header_Title = new PaHeaderTitle('title'); ?></h1>
        </div>
      </div>
    </header>
  </section>
<?php endif; ?>
