@if(is_admin())
	@if($block_format == '2/3')
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListNews/preview-2-3.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
	@else
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListNews/preview-1-3.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
	@endif
@else
	<div class="pa-widget pa-w-list-news col-12 mb-5 {{ $block_format == '2/3' ? 'col-md-8' : 'col-md-4' }}">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
			@if(is_array($items))
				@foreach($items as $item)
					<div class="card mb-4 mb-xl-4 border-0">
						<a 
							href="{{ isset($item['link']) ? (is_array($item['link']) ? $item['link']['url'] : $item['link']) : get_permalink($item['id']) }}"
							target="{{ isset($item['link']) && is_array($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}" 
						>
							<div class="row">
								<div class="col-12 col-md-5">
									@notempty($item['featured_media_url'])
										<div class="ratio ratio-16x9">
											<figure class="figure m-xl-0">
												<img 
													class="figure-img img-fluid rounded m-0"
													src="{{ isset($item['featured_media_url']) ? $item['featured_media_url']['pa_block_render'] : get_the_post_thumbnail_url($item['id'], 'medium') }}"
													alt="{{ $item['title']['rendered'] }}" 
												/>
												{{-- @if(($block_format == '2/3' && isset($item['terms']['editorial']) && !empty($editorial = $item['terms']['editorial'])) ||
													$block_format == '2/3' && !empty($editorial = get_the_terms($item['id'], 'xtt-pa-editorias')))
													<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right pa-truncate-3">
														{{ is_array($editorial) ? $editorial[0]->name : $editorial }}
													</figcaption>
												@endif --}}

                        @if((isset($item['terms']['editorial']) && !empty($editorial = $item['terms']['editorial'])) || !empty($editorial = get_the_terms($item['id'], 'xtt-pa-editorias')))
													<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right {{ ($block_format == '1/3') ? 'd-md-none' : '' }}">
														{{ is_array($editorial) ? $editorial[0]->name : $editorial }}
													</figcaption>
												@endif

											</figure>
										</div>
									@endnotempty
								</div>
								
								<div class="col-12 col-md-7">
									<div class="card-body p-0">

										@notempty($item['terms']['format'])

                      @if (sanitize_title($item['terms']['format']) == 'video')
                        <span class="pa-tag-icon d-inline-block pag-tag-icon-video"><i class="fas fa-play"></i></span>
                      @endif
  
                      @if (sanitize_title($item['terms']['format']) == 'audio')
                        <span class="pa-tag-icon d-inline-block pag-tag-icon-audio"><i class="fas fa-headphones-alt"></i></span>
                      @endif
                    
											<span class="pa-tag text-uppercase d-inline-block rounded-1 px-2">{{ $item['terms']['format'] }}</span>
										@endnotempty

										@notempty($item['title'])
											<h3 class="card-title mt-2 h5 pa-truncate-3 {{ $block_format == '2/3' ? 'fw-bold' : 'fw-normal' }}">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty

										@notempty($item['excerpt'])
											
											<p class="card-text d-block {{ $block_format == '2/3' ? 'pa-truncate-3' : 'd-md-none' }}">{{ wp_strip_all_tags($item['excerpt']['rendered']) }}</p>
											
										@endnotempty
									</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
				@endif
			</div>
		@endnotempty

		@notempty($enable_link)
			<a 
				href="{{ $link['url'] ?? '#' }}" 
				target="{{ $link['target'] ?? '_self' }}"
				class="pa-all-content"
			>
				{!! $link['title'] !!}
			</a>
		@endnotempty
	</div>
@endif
