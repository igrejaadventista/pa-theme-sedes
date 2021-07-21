@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAVideosFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-videos">
		<h2>{{ $title ?? 'Widget - List - Videos' }}</h2>
		<div class="row row-cols-auto">
			<div class="col">
				<div class="card mb-4 border-0">
					<a href="{{ $videos[0]['link']['url'] }}" target="{{ $videos[0]['link']['target'] }}">
						<div class="ratio ratio-16x9">
							<figure class="figure">
								<img src="{{ $videos[0]['thumbnail']['url'] }}"
									 class="figure-img img-fluid rounded m-0" alt="...">
								<div class="figure-caption position-absolute w-100 h-100 d-block">
									<i class="pa-play far fa-play-circle position-absolute"></i>
									<span class="pa-video-time position-absolute px-2 rounded-sm"><i
											class="far fa-clock me-1"></i>{{ $videos[0]['time'] }}</span>
								</div>
							</figure>
						</div>
						<div class="card-body p-0 mt-4">
							<h3 class="card-text h5 fw-bold pa-truncate-1">{{  $videos[0]['title'] }}</h3>
							<p class="card-text d-none">{{  $videos[0]['excerpt'] }}</p>
						</div>
					</a>
				</div>
			</div>
			<div class="col">
				@foreach($videos as $k => $video)
					@if ($k == 0)
						@continue
					@endif
					<div class="card mb-2 mb-xl-4 border-0">
						<a href="{{ $video['link']['url'] }}" target="{{ $video['link']['target'] }}">
							<div class="row">
								<div class="col">
									<div class="ratio ratio-16x9">
										<figure class="figure m-xl-0">
											<img src="{{ $video['thumbnail']['url'] }}"
												 class="figure-img img-fluid rounded m-0" alt="...">
											<div class="figure-caption position-absolute w-100 h-100 d-block">
											<span class="pa-video-time position-absolute px-2 rounded-sm"><i
													class="far fa-clock me-1"></i>{{ $video['time'] }}</span>
											</div>
										</figure>
									</div>
								</div>
								<div class="col">
									<div class="card-body p-0">
										<h3 class="card-title h6 pa-truncate-3">{{ $video['title'] }}</h3>
									</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endif