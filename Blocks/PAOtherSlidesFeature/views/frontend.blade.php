@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAOtherSlidesFeature/preview.png" />
@else
	@notempty($items)
		<div class="pa-widget pa-w-carousel-feature">
			<h2>{{ $title ?? 'Widget - Carousel - Feature' }}</h2>
			<div class="mt-4">
				<div class="pa-glide-destaques">
					<div class="glide__track" data-glide-el="track">
						<div class="glide__slides">
							@foreach($slides as $slide)
								<div class="glide__slide position-relative">
									@notempty($slide['thumbnail'])
										<img class="rounded img-fluid" src="{{ $slide['thumbnail']['url'] }}" alt="{{ $slide['thumbnail']['alt'] ?: 'Imagem do slide ' . $loop->iteration }}" />	
									@endnotempty
									
									@notempty($slide['title'])
										<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">{!! $slide['title'] !!}</h3>	
									@endnotempty
									
									@notempty($slide['excerpt'])
										<p class="card-text pa-truncate-2">{!! $slide['excerpt'] !!}</p>
									@endnotempty

									@notempty($slide['link'])
										<a href="{{ $slide['link']['url'] }}" target="{{ $slide['link']['target'] ?: '_self' }}" class="stretched-link">
											<span class="visually-hidden">{!! $slide['title'] ?: 'Link do slide' . $loop->iteration !!}</span>
										</a>
									@endnotempty
								</div>
							@endforeach
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
	@endnotempty
@endif