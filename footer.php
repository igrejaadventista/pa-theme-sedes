		<?php

use IASD\Core\Settings\Modules;

 require(get_template_directory() . '/components/menu/footer.php'); ?>
		</div>

    <?php if(Modules::isActiveModule('seventhcolumn')): ?>
      <div class="pa-sabbath-column d-none d-xl-block">
        <div class="h-100 d-flex justify-content-center align-items-start">
          <img src="<?= get_template_directory_uri() . "/assets/imgs/logo-symbol-white.svg" ?>" alt="<?= _e('Seventh-day Adventist Church', 'iasd'); ?>" title="<?= _e('Seventh-day Adventist Church', 'iasd'); ?>" class="pa-grid-logo position-sticky img-fluid p-6">
        </div>
      </div> 
    <?php endif; ?>
	</div>

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <?php wp_footer(); ?>

</body>
</html>
 