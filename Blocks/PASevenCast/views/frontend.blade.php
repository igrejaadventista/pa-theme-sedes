@if (is_admin())
    <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PASevenCast/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else 
    <div class="pa-widget pa-w-7cast col-12 col-md-4 mb-5">
		@notempty($title)
			<h2 class="mb-4">{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
			@if(is_array($items))
				@foreach($items as $item)
					<div class="card mb-2 mb-xl-4 border-0">
						<a href="{{ $item['link']['url'] }}" href="{{ $item['link']['target'] }}">
							<div class="row">
								@notempty($item['featured_media_url'])
									<div class="col-4">
										<div class="ratio ratio-1x1">
											<figure class="figure m-xl-0">
												<img
													class="figure-img img-fluid rounded m-0" 
													src="{{ $item['featured_media_url']['pa_block_render'] }}" 
													alt="{{ $item['title']['rendered'] }}"
												/>
											</figure>
										</div>
									</div>
								@endnotempty

								<div class="col-8">
									<div class="card-body p-0">
										<i class="fas fa-microphone my-1"></i>

										@notempty($item['title'])
											<h3 class="card-title h6 fw-bolder m-0">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty	

										@notempty($item['excerpt'])
											<p class="pa-truncate-2">{!! $item['excerpt']['rendered'] !!}</p>
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
				class="pa-all-content mt-2"
			>
				{!! $link['title'] !!}
			</a>
		@endnotempty
    </div>
@endif
