@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAOtherSlidesFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-projects">
		<h2>{{ $title ?? 'Widget - List - Projects' }}</h2>
		<div class="mt-4">
			@foreach($items as $item)
				<div class="project mb-2 mb-xl-4 border-0">
					<div class="row">
						<div class="col">
							<a href="{{ $item['link']['url'] }}" target="{{ $item['link']['target'] ?? '_self' }}">
								<figure class="figure m-xl-0">
									<img src="{{ $item['thumbnail']['url'] }}" class="figure-img img-fluid rounded m-0"
										 alt="...">
								</figure>
							</a>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		@if(!empty($checkContent))
			<a href="{{ $contents['url'] ?? '#' }}" class="pa-all-content"
			   target="{{ $contents['target'] ?? '_self' }}">{{ $contents['title'] }}</a>
		@endif
	</div>
@endif