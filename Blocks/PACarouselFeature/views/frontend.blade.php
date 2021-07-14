@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PACarouselFeature/preview.png" />
@else
	<div class="pa-widget pa-w-carousel-feature mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
				<div class="pa-glide-destaques">
					<div class="glide__track" data-glide-el="track">
						<div class="glide__slides">
							@foreach($items as $item)
								<div class="glide__slide position-relative">
									<img 
										class="rounded img-fluid"
										src="{{ isset($item['featured_media_url']) ? $item['featured_media_url']['pa_block_render'] : get_the_post_thumbnail_url($item['id'], 'medium') }}"
										alt="{{ $item['title']['rendered'] }}" 
									/>

									@notempty($item['title'])
										<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">{!! $item['title']['rendered'] !!}</h3>
									@endnotempty

									@notempty($item['content'])
										<p class="card-text pa-truncate-2">{{ wp_strip_all_tags($item['content']['rendered']) }}</p>
									@endnotempty

									@notempty($item['link'])
										<a 
											href="{{ isset($item['link']) ? $item['link']['url'] : get_permalink($item['id']) }}"
											target="{{ isset($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}" 
											class="stretched-link"
										>
											<span class="visually-hidden">{!! $item['title'] ?: 'Link do slide' . $loop->iteration !!}</span>
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
							@foreach($items as $item)
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
		@endnotempty
	</div>
@endif