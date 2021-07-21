@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PASideNewsFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-posts">
		<h2>{{ $title ?? 'Widget - List - Posts' }}</h2>
		<div class="mt-4">
			@foreach($custom_news as $new)
				<div class="card mb-2 mb-xl-4 border-0">
					<a href="{{ $new['link']['url'] }}" target="{{ $new['link']['target'] }}">
						<div class="row">
							<div class="col-6">
								<div class="ratio ratio-16x9">
									<figure class="figure m-xl-0">
										<img src="{{ $new['thumbnail']['url'] }}"
											 class="figure-img img-fluid rounded m-0 h-100" alt="...">									
									</figure>
								</div>
							</div>
							<div class="col-6">
								<div class="card-body p-0">
									<h3 class="card-title h6">{{ $new['title'] }}</h3>
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