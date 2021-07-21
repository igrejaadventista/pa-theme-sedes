@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAMagazines/preview.png"/>
@else
	<div class="pa-widget pa-w-carousel-magazines col col-md-4 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4 p-4 bg-light">
				<div class="position-relative p-4">
					<div class="pa-slider-magazines d-flex align-items-center ">
						<div class="glide__track" data-glide-el="track">
							<div class="glide__slides">
								@foreach($items as $item)
									<div class="glide__slide">
										<a 
											href="{{ isset($item['link']) ? $item['link']['url'] : get_permalink($item['id']) }}"
											target="{{ isset($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
										>
											<img
												src="{{ isset($item['featured_media_url']) ? $item['featured_media_url']['pa_block_render'] : get_the_post_thumbnail_url($item['id'], 'medium') }}"
												alt="{{ $item['title']['rendered'] }}" 
												class="rounded img-fluid" 
											/>
										</a>
									</div>
								@endforeach
							</div>
						</div>

						@if(count($items) > 1)
							<div class="pa-slider-controle pa-controle-left" data-glide-el="controls">
								<div data-glide-dir="&lt;">
									<i class="fas fa-angle-left fa-3x"></i>
								</div>
							</div>

							<div class="pa-slider-controle pa-controle-right" data-glide-el="controls">
								<div data-glide-dir="&gt;">
									<i class="fas fa-angle-right fa-3x"></i>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		@endnotempty
	</div>
@endif