<?php
	$campo = get_info_sedes();
	$lang = get_info_lang();
	$adress = get_info_adress();
	$telephone = get_info_telephone();
	$facebook = get_info_facebook();
	$twitter = get_info_twitter();
	$youtube = get_info_youtube();
	$instagram = get_info_instagram();
?>

<section class="pa-footer pt-5 mt-5">
	<div class="container">
		<footer class="row">
			<div class="col d-flex flex-column justify-content-xl-between">
				<div class="d-flex flex-column align-items-center align-items-xl-start px-5 px-xl-0">
					<div class="pa-brand">
						<a href="/" title="<?= $campo->name ?>"><img src="<?= get_template_directory_uri() . "/assets/sedes/" . $lang . "/logo-iasd-vertical.svg" ?>" alt="<?= $campo->name ?>" title="<?= $campo->name ?>" class="img-fluid"></a>
						<span class="d-block mt-4"><?= $campo->name ?></span>
					</div>
					<hr class="mt-4 mb-4">
					<div class="pa-contact">
						<?php if ($adress) {?><span class="pa-adress d-block text-center text-md-start lh-lg"><?= $adress ?></span><?php } ?>
						<?php if ($telephone) {?><span class="pa-telephone d-block text-center text-md-start mt-4"><?= $telephone ?></span><?php } ?>
					</div>
				</div>
				<?php if ($facebook || $twitter || $youtube || $instagram){ ?>
				<div class="pa-social-network align-items-end d-none d-xl-block">
					<span><?php _e('Nossas redes sociais', 'iasd'); ?></span>
					<div class="icons mt-3">
						<?php if ($facebook) {?><a href="<?= $facebook ?>" title="Facebook"><i class="fab fa-facebook-f me-4"></i></a><?php } ?>
						<?php if ($twitter) {?><a href="<?= $twitter ?>" title="Twitter"><i class="fab fa-twitter me-4"></i></a><?php } ?>
						<?php if ($youtube) {?><a href="<?= $youtube ?>" title="Youtube"><i class="fab fa-youtube me-4"></i></a><?php } ?>
						<?php if ($instagram) {?><a href="<?= $instagram ?>" title="Instagram"><i class="fab fa-instagram-square"></i></a><?php } ?>
					</div>
				</div>

				<?php } ?>
			</div>
			<div class="col-9 d-none d-xl-block">
				<div class="pa-about-us pb-4 mb-4">
					<h2>Sobre Nós</h2>
					<ul class="list-unstyled pa-split-column-3">
						<li class="item-menu"><a href="https://www.adventistas.org/pt/institucional/" title="Os Adventistas" target="">Os Adventistas</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/institucional/crencas/" title="Nossas Crenças" target="">Nossas Crenças</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/institucional/missao-e-servico" title="Missão &amp; Serviço" target="">Missão &amp; Serviço</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/institucional/organizacao/" title="Organização" target="">Organização</a></li>
					</ul>
				</div>
				<div class="pa-deptos pb-4 mb-4">
					<h2>Departamentos</h2>
					<ul class="list-unstyled pa-split-column-3">
						<li class="item-menu"><a href="https://www.adventistas.org/pt/afam/" title="AFAM" target="">AFAM</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/asa/" title="ASA" target="">ASA</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/associacaoministerial/" title="Associação Ministerial" target="">Associação Ministerial</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/aventureiros/" title="Aventureiros" target="">Aventureiros</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/comunicacao" title="Comunicação" target="">Comunicação</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/desbravadores" title="Desbravadores" target="">Desbravadores</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/educacao" title="Educação" target="">Educação</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/escolasabatina" title="Escola Sabatina" target="">Escola Sabatina</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/espiritodeprofecia/" title="Espírito de Profecia" target="">Espírito de Profecia</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/evangelismo" title="Evangelismo" target="">Evangelismo</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/liberdadereligiosa" title="Liberdade Religiosa" target="">Liberdade Religiosa</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/criancas" title="Ministério da Criança" target="">Ministério da Criança</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/familia" title="Ministério da Família" target="">Ministério da Família</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/mulher" title="Ministério da Mulher" target="">Ministério da Mulher</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/musica" title="Ministério da Música" target="">Ministério da Música</a></li>
						<li class="item-menu"><a href="http://surdos.adventistas.org/" title="Ministério de Surdos" target="">Ministério de Surdos</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/adolescentes" title="Ministério do Adolescente" target="">Ministério do Adolescente</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/jovens" title="Ministério Jovem" target="">Ministério Jovem</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/ministeriopessoal" title="Ministério Pessoal" target="">Ministério Pessoal</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/missaoglobal" title="Missão Global" target="">Missão Global</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/mordomiacrista" title="Mordomia Cristã" target="">Mordomia Cristã</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/publicacoes" title="Publicações" target="">Publicações</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/saude" title="Saúde" target="">Saúde</a></li>
						<li class="item-menu"><a href="https://www.adventistas.org/pt/voluntarios/" title="Serviço Voluntário Adventista" target="">Serviço Voluntário Adventista</a></li>
					</ul>
				</div>
				<div class="pa-headquarters">
					<h2>Sedes Regionais</h2>
					<ul class="list-unstyled pa-split-column-3">
						<li class="item-menu"><a href="http://ua.adventistas.org" title="União Argentina">União Argentina</a></li>
						<li class="item-menu"><a href="http://ub.adventistas.org" title="União Boliviana">União Boliviana</a></li>
						<li class="item-menu"><a href="http://ucb.adventistas.org" title="União Central Brasileira">União Central Brasileira</a></li>
						<li class="item-menu"><a href="http://ucob.adventistas.org" title="União Centro-Oeste Brasileira">União Centro-Oeste Brasileira</a></li>
						<li class="item-menu"><a href="http://uch.adventistas.org" title="União Chilena">União Chilena</a></li>
						<li class="item-menu"><a href="http://ue.adventistas.org" title="União Ecuatoriana">União Ecuatoriana</a></li>
						<li class="item-menu"><a href="http://ulb.adventistas.org" title="União Leste Brasileira">União Leste Brasileira</a></li>
						<li class="item-menu"><a href="http://uneb.adventistas.org" title="União Nordeste Brasileira">União Nordeste Brasileira</a></li>
						<li class="item-menu"><a href="http://unob.adventistas.org" title="União Noroeste Brasileira">União Noroeste Brasileira</a></li>
						<li class="item-menu"><a href="http://unb.adventistas.org" title="União Norte Brasileira">União Norte Brasileira</a></li>
						<li class="item-menu"><a href="http://up.adventistas.org" title="União Paraguaya">União Paraguaya</a></li>
						<li class="item-menu"><a href="http://upn.adventistas.org" title="União Peruana do Norte">União Peruana do Norte</a></li>
						<li class="item-menu"><a href="http://upsur.adventistas.org" title="União Peruana do Sul">União Peruana do Sul</a></li>
						<li class="item-menu"><a href="http://useb.adventistas.org" title="União Sudeste Brasileira">União Sudeste Brasileira</a></li>
						<li class="item-menu"><a href="http://usb.adventistas.org" title="União Sul Brasileira">União Sul Brasileira</a></li>
						<li class="item-menu"><a href="http://uu.adventistas.org" title="União Uruguaya">União Uruguaya</a></li>
					</ul>
				</div>
			</div>
			<div class="pa-copyright mt-5 py-2 d-flex flex-xl-row justify-content-xl-between flex-column align-items-center">
				<span class="py-2"><?php _e('Igreja Adventista do Sétimo Dia', 'iasd'); ?></span>
				<span class="py-2">Coryright © 2013-<?= date("Y") ?></span>
			</div>
			<div class="col mb-5 mt-3 text-center pa-go-back-top d-xl-none">
				<a href="#topo" class="btn btn-sm"><i class="fas fa-arrow-up me-2"></i><?php _e('Voltar para o topo', 'iasd'); ?></a>
			</div>

			
			

		</footer>
	</div>
</section>