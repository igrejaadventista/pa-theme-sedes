@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PADownloads/preview.png"/>
@else
	<div class="pa-widget pa-w-list-downloads">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<div class="mt-4">
				@foreach($items as $item)
					<div class="card mb-2 mb-xl-4 border-0">
						<a href="{{ $file['url'] }}" target="_blank">
							<div class="row">
								<div class="col-4">
									<div class="ratio ratio-16x9">
										<figure class="figure m-xl-0">
											<img src="{{ $file['thumbnail']['url'] }}"
												class="figure-img img-fluid rounded m-0" alt="...">
										</figure>
									</div>
								</div>
								<div class="col-8">
									<div class="card-body p-0">
										<span class="pa-tag text-uppercase me-1 rounded">{{ $file['link']['extension'] }}</span>
										<span class="pa-tag text-uppercase rounded">{{ $file['link']['size'] }}</span>

										@notempty($item['title'])
											<h3 class="card-title h6 m-0 pa-truncate-1">{!! $item['title']['rendered'] !!}</h3>
										@endnotempty
									</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		@endnotempty
	</div>
@endif