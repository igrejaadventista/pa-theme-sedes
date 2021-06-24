@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PARelatedVideosFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-posts col col-md-8 mb-5">
		<h2>{{ $title ?? 'Widget - Relacionados - Videos' }}</h2>
		<div class="row mt-4">
			@foreach($videos as $video)
				<div class="col-4">
					<div class="card mb-2 mb-xl-4 border-0">
						<a href="{{ $video['link']['url'] }}" target="{{ $video['link']['target'] }}">
							<figure class="figure position-relative">
								<img src="{{ $video['thumbnail']['url'] }}"
									 class="figure-img img-fluid rounded m-0" alt="...">
							</figure>
							<div class="card-body p-0">
								<h3 class="card-title h6">{{ $video['title'] }}</h3>
							</div>
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif