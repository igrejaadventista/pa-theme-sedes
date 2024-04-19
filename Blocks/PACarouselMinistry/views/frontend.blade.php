@if (is_admin())
    <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PACarouselMinistry/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else
	<div class="pa-widget pa-w-carousel-ministry col-12 col-md-8 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
				<div class="pa-destaque-deptos-sliders"
             data-autoplay="{{ $autoplay }}" >
					<div class="glide__track" data-glide-el="track">
						<div class="glide__slides">
						@if(is_array($items))
							@foreach($items as $item)
								<div class="glide__slide">
									<a 
										href="{{ isset($item['link']) ? $item['link']['url'] : get_permalink($item['id']) }}"
										target="{{ isset($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
										class="d-block"
									>
										<div class="ratio ratio-16x9">
											<figure class="figure m-xl-0 rounded overflow-hidden">
													<img class="figure-img img-fluid m-0"
														src="{{ isset($item['featured_media_url']) ? $item['featured_media_url']['pa_block_render'] : get_the_post_thumbnail_url($item['id'], 'medium') }}"
														alt="{{ $item['title']['rendered'] }}" 
													/>
												
												<figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
													@notempty($item['tag'])
														<span class="pa-tag rounded-sm mb-2">{{ $item['tag'] }}</span>
													@endnotempty

													@notempty($item['title'])
														<h3 class="h4 pt-2">{!! $item['title']['rendered'] !!}</h3>
													@endnotempty
												</figcaption>
											</figure>
										</div>
									</a>
								</div>
							@endforeach
						@endif
						</div>
					</div>

					@if(count($items) > 1)
						<div class="pa-slider-controle d-flex justify-content-between justify-content-xl-start align-items-center mt-4">
							<div data-glide-el="controls">
								<span class="fa-stack" data-glide-dir="&lt;">
									<i class="fas fa-circle fa-stack-2x"></i>
									<i class="icon fas fa-arrow-left fa-stack-1x"></i>
								</span>
							</div>

							<div class="mx-2 pa-slider-bullet" data-glide-el="controls[nav]">
							@if(is_array($items))
								@foreach($items as $item)
									<i class="fas fa-circle fa-xs mx-1" data-glide-dir="={{ $loop->index }}"></i>
								@endforeach
								@endif
							</div>

							<div data-glide-el="controls">
								<span class="fa-stack" data-glide-dir="&gt;">
									<i class="fas fa-circle fa-stack-2x"></i>
									<i class="icon fas fa-arrow-right fa-stack-1x"></i>
								</span>
							</div>
						</div>
					@endif
				</div>
			</div>
		@endnotempty
	</div>
@endif
