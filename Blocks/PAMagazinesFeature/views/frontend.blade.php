@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAMagazinesFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-carousel-magazines">
		<h2>{{ $title ? $title : 'Widget - Carousel - Magazines' }}</h2>
		<div class="mt-4 p-4 bg-light">
			<div class="position-relative p-4">
				<div class="pa-slider-magazines d-flex align-items-center ">
					<div class="glide__track" data-glide-el="track">
						<div class="glide__slides">
							@foreach($items as $item)
								<div class="glide__slide">
									<a href="//{{ $item['url'] }}" target="_blank">
										<img class="rounded img-fluid" src="{{ $item['thumbnail']['url'] }}"
											 alt="{{ $item['thumbnail']['alt'] ?: 'Imagem do slide ' . $loop->iteration }}"/>
									</a>
								</div>
							@endforeach
						</div>
					</div>

					<div class="pa-slider-controle pa-controle-left" data-glide-el="controls">
						<div data-glide-dir="<">
							<i class="fas fa-angle-left fa-3x"></i>
						</div>
					</div>

					<div class="pa-slider-controle pa-controle-right" data-glide-el="controls">
						<div data-glide-dir=">">
							<i class="fas fa-angle-right fa-3x"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif