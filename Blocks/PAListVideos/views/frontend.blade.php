@if(is_admin())
	@if($block_format == '2/3')
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListVideos/preview-2-3.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd')}}"/>
	@else
		<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListVideos/preview-1-3.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd')}}"/>
	@endif
@else
	<div class="pa-widget pa-w-list-videos col-12 mb-5 {{ $block_format == '2/3' ? 'col-md-8' : 'col-md-4' }}">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="row row-cols-1 mt-4 mb-0 {{ $block_format == '2/3' ? 'row-cols-md-2' : 'row-cols-md-1' }}">
			@if(is_array($items))	
				@foreach($items as $item)
					@if($loop->index == 0)
						<div class="col">
							<div class="card mb-5 border-0">
								<a href="{{ is_array($item['link']) ? $item['link']['title'] : $item['link'] }}">
									<div class="ratio ratio-16x9">
										<figure class="figure bg-light rounded overflow-hidden">
											@notempty($item['featured_media_url'])
												<img 
													class="figure-img img-fluid m-0"	
													src="{{ $item['featured_media_url']['pa_block_render'] }}"  
													alt="{{ $item['title']['rendered'] }}" 
												/>
											@endnotempty

											<div class="figure-caption position-absolute w-100 h-100 d-block">
												<i class="pa-play far fa-play-circle position-absolute"></i>

												@notempty($item['acf']['video_length'])
													<span class="pa-video-time position-absolute px-2 rounded-1"><i class="far fa-clock me-1"></i> {{ date('i:s', mktime(0, 0, $item['acf']['video_length'])) }}</span>
												@endnotempty
											</div>
										</figure>
									</div>

									<div class="card-body p-0 mt-3">
										@notempty($item['title'])
											<h3 class="card-text h5 fw-bold pa-truncate-2">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty
										
										@notempty($item['excerpt'])
											@if($block_format == '2/3')
												<p class="card-text d-none d-xl-block pa-truncate-3">{{ wp_strip_all_tags($item['excerpt']['rendered']) }}</p>
											@endif
										@endnotempty
									</div>
								</a>
							</div>
						</div>
					@else
						@if($loop->index == 1)
							<div class="col">
						@endif

						<div class="card mb-2 mb-xl-4 border-0">
							<a href="{{ $item['link'] }}">
								<div class="row">
									<div class="col">
										<div class="ratio ratio-16x9">
											<figure class="figure m-xl-0 bg-light rounded overflow-hidden">
												@notempty($item['featured_media_url'])
													<img 
														class="figure-img img-fluid m-0"	
														src="{{ $item['featured_media_url']['pa_block_render'] }}"  
														alt="{{ $item['title']['rendered'] }}" 
													/>
												@endnotempty

												@notempty($item['acf']['video_length'])
													<div class="figure-caption position-absolute w-100 h-100 d-block">
														<span class="pa-video-time position-absolute px-2 rounded-1"><i class="far fa-clock me-1"></i>{{ date('i:s', mktime(0, 0, $item['acf']['video_length'])) }}</span>
													</div>
												@endnotempty
											</figure>
										</div>	
									</div>

									@notempty($item['title'])
										<div class="col">
											<div class="card-body p-0">
												<h3 class="card-title h6 pa-truncate-3">{!! $item['title']['rendered'] !!}</h3>
											</div>
										</div>
									@endnotempty
								</div>
							</a>
						</div>

						@if($loop->last)
							</div>
						@endif
					@endif
				@endforeach
			@endif

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
		@endnotempty
	</div>
@endif
