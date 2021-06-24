@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PALatestNewsFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-news">
		<h2>{{ $title ?? 'Widget - List - News' }}</h2>

		<div class="mt-4">
			@foreach($custom_news as $new)
				<div class="card mb-5 mb-xl-4 border-0">
					<a href="{{ $new['link']['url'] }}" target="{{ $new['link']['target'] }}">
						<div class="row">
							<div class="col-12 col-md-5">
								<div class="ratio ratio-16x9">
									<figure class="figure m-xl-0">
										<img src="{{ $new['thumbnail']['url'] }}"
											 class="figure-img img-fluid rounded m-0 h-100" alt="...">
										<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">
											{{ $new['title'] }}
										</figcaption>
									</figure>
								</div>
							</div>
							<div class="col-12 col-md-7">
								<div class="card-body p-0">
									<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">{{ $new['postType'] }}</span>
									<h3 class="card-title fw-bold h5 mt-xl-2 pa-truncate-2">{{ $new['header'] }}</h3>
									<p class="card-text pa-truncate-3">{{ $new['excerpt'] }}</p>
								</div>
							</div>
						</div>
					</a>
				</div>
			@endforeach
		</div>
		<a href="" class="pa-all-content">Ver todas as notícias</a>
	</div>
@endif