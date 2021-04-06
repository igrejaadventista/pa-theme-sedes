@empty(!$slides)
	<div class="pa-widget pa-w-carousel-feature col col-md-4 mb-5">
		<h2>{{ $title ?? 'Widget - Carousel - Feature' }}</h2>
		<div class="mt-4">
			<div class="pa-glide-destaques">
				<div class="glide__track" data-glide-el="track">
					<div class="glide__slides">
						@foreach($slides as $slide)
							<div class="glide__slide">
								@empty(!$slide['thumbnail'])
									<img class="rounded img-fluid" src="{{ $slide['thumbnail']['url'] }}" alt="{{ $slide['thumbnail']['alt'] ?: 'Imagem do slide ' . $loop->iteration }}" />	
								@endempty
								
								@empty(!$slide['title'])
									<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">{!! $slide['title'] !!}</h3>	
								@endempty
								
								@empty(!$slide['excerpt'])
									<p class="card-text pa-truncate-2">{!! $slide['excerpt'] !!}</p>
								@endempty

								@empty(!$slide['link'])
									<a href="{{ $slide['link']['url'] }}" target="{{ $slide['link']['target'] ?: '_self' }}" class="stretched-link">
										<span class="visually-hidden">{!! $slide['title'] ?: 'Link do slide' . $loop->iteration !!}</span>
									</a>
								@endempty
							</div>
						@endforeach
						{{-- <div class="glide__slide">
							<img class="rounded img-fluid" src="https://picsum.photos/336/390.webp?random=1"  alt="" >
							<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">Fim de semana da família</h3>
							<p class="card-text pa-truncate-2">Mais de 15 mil líderes e servidores da Igreja acompanharam a programação em diversas regiões do Planeta</p>
						</div>
						<div class="glide__slide">
							<img class="rounded img-fluid" src="https://picsum.photos/336/390.webp?random=2"  alt="" >
							<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">Fim de semana da família</h3>
							<p class="card-text pa-truncate-2">Com o auxílio da ADRA e outras instituições, os refugiados recebem oportunidades para conquistar autonomia financeira e oportunidade</p>
						</div>
						<div class="glide__slide">
							<img class="rounded img-fluid" src="https://picsum.photos/336/390.webp?random=3"  alt="" >
							<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">Fim de semana da família</h3>
							<p class="card-text pa-truncate-2">Novo livro busca na observação da natureza a base para o diálogo entre as duas áreas</p>
						</div>
						<div class="glide__slide">
							<img class="rounded img-fluid" src="https://picsum.photos/336/390.webp?random=4"  alt="" >
							<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">Fim de semana da família</h3>
							<p class="card-text pa-truncate-2">Teólogo Elias Brasil de Souza, que dirige o Instituto de Pesquisas Bíblicas da Igreja Adventista do Sétimo Dia, explica  conceitos</p>
						</div>
						<div class="glide__slide">
							<img class="rounded img-fluid" src="https://picsum.photos/336/390.webp?random=5"  alt="" >
							<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">Fim de semana da família</h3>
							<p class="card-text pa-truncate-2">Presidente mundial da denominação pede orações por todas as pessoas afetadas pela tragédia</p>
						</div>				 --}}
					</div>
				</div>
				<div class="pa-slider-controle d-flex justify-content-between justify-content-xl-start align-items-center mt-4">
					<div data-glide-el="controls">
						<span class="fa-stack" data-glide-dir="&lt;">
							<i class="fas fa-circle fa-stack-2x"></i>
							<i class="icon fas fa-arrow-left fa-stack-1x"></i>
						</span>
					</div>	
				
					<div class="mx-2 pa-slider-bullet" data-glide-el="controls[nav]">
						@foreach($slides as $slide)
							<i class="fas fa-circle fa-xs mx-1" data-glide-dir="={{ $loop->index }}"></i>
						@endforeach
					</div>

					<div data-glide-el="controls">
						<span class="fa-stack" data-glide-dir="&gt;">
							<i class="fas fa-circle fa-stack-2x"></i>
							<i class="icon fas fa-arrow-right fa-stack-1x"></i>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
@endempty