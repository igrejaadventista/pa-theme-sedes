@if(is_admin())
	@if($block_format == '2/3')
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListNews/preview-2-3.png" alt="Imagem ilustrativa do front-end da widgets PA List News"/>
	@else
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListNews/preview-1-3.png"/>
	@endif
@else
	<div class="pa-widget pa-w-list-news col mb-5 {{ $block_format == '2/3' ? 'col-md-8' : 'col-md-4' }}">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
				@foreach($items as $item)
					<div class="card mb-5 mb-xl-4 border-0">
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
												{{-- TODO: Obter dados da editoria --}}
												@if(($block_format == '2/3' && isset($item['editorial']) && !empty($editorial = $item['editorial'])) ||
													$block_format == '2/3' && !empty($editorial = get_the_terms($item['id'], 'xtt-pa-editorias')))
													<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none d-xl-block pa-truncate-3">
														{{ is_array($editorial) ? $editorial[0]->name : $editorial }}
													</figcaption>
												@endif
											</figure>
										</div>
									@endnotempty
								</div>
								
								<div class="col-12 col-md-7">
									<div class="card-body p-0">
										{{-- TODO: Obter dados de formato de post --}}
										@notempty($item['post_format'])
											<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">{{ $item['post_format'] }}</span>
										@endnotempty

										@notempty($item['title'])
											<h3 class="card-title mt-xl-2 {{ $block_format == '2/3' ? 'fw-bold h5' : 'h6' }}">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty

										@notempty($item['excerpt'])
											@if($block_format == '2/3')
												<p class="card-text d-none d-xl-block pa-truncate-3">{{ wp_strip_all_tags($item['excerpt']['rendered']) }}</p>
											@endif
										@endnotempty
									</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
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
