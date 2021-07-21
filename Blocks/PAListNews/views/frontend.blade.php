@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListNews/preview.png"/>
@else
	<div class="pa-widget pa-w-list-news col col-md-8 mb-5 ">
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
												<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">
													{!! $item['title']['rendered'] !!}
												</figcaption>
											</figure>
										</div>
									@endnotempty
								</div>
								
								<div class="col-12 col-md-7">
									<div class="card-body p-0">
										{{-- <span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">{{ $new['postType'] }}</span> --}}
										@notempty($item['title'])
											<h3 class="card-title fw-bold h5 mt-xl-2 pa-truncate-2">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty

										@notempty($item['excerpt'])
											<p class="card-text pa-truncate-3">{{ wp_strip_all_tags($item['excerpt']['rendered']) }}</p>
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