@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PACarouselDownloads/preview.png" alt='{{ __('Illustrative image of the front end of the block.', 'iasd') }}'/>
@else  
	<div class="pa-widget pa-carousel-download col-12 mb-5">
		<div class="pa-glide-downloads">
			@notempty($title)
				<div class="d-flex mb-4">
					<h2 class="flex-grow-1">{!! $title !!}</h2>	
				</div>
			@endnotempty

			@notempty($items)
				<div class="glide__track" data-glide-el="track">
					<div class="glide__slides">
						@foreach($items as $item)
							<div class="glide__slide">
								<div class="card shadow-sm border-0">
									<figure class="ratio ratio-16x9 bg-light rounded-bottom overflow-hidden">
										@notempty($item['featured_media_url'])
											<img 
												class="card-img-top"	
												src="{{ $item['featured_media_url']['pa_block_render'] }}"  
												alt="{{ $item['title']['rendered'] }}" 
											/>
										@endnotempty
									</figure>

									<div class="card-body pt-0">
										@if(!empty($item['file_format']) || !empty($item['file_size']))
											<div class="mb-3">
												@notempty($item['file_format'])
													<span class="pa-tag text-uppercase me-1 rounded">{{ $item['file_format'] }}</span>
												@endnotempty
												
												@notempty($item['file_size'])
													<span class="pa-tag text-uppercase rounded">{{ $item['file_size'] }}</span>
												@endnotempty
											</div>
										@endif

										@notempty($item['title'])
											<h3 class="card-title fw-bold h6 mb-4">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty
										
										<a 
											class="border border-1 px-4 py-2 rounded-pill btn-outline-primary"
											href="{{ is_array($item['link']) ? $item['link']['url'] : $item['link'] }}" 
											target="{{ is_array($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
										>
											<i class="fas fa-arrow-circle-down me-2"></i> Baixar
										</a>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				</div>
			@endnotempty
		</div>
	</div>
@endif
