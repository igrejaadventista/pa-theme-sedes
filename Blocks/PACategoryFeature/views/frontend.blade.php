@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PACategoryFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-categories-feature mb-5">
		<h2>{{ $title ?? 'Widget - Category - Feature' }}</h2>
		@notempty($categories)
		<ul class="list-unstyled mt-4">
			@foreach($categories as $category)
				<li class="pa-widget-button h-25 mb-4">
					<a href="//{{ $category['link']['url'] }}" class="d-block d-flex px-4 align-items-center rounded fw-bold"
					   	target="{{ $category['link']['target'] }}" 
					>
						<i class="{{ $category['icon'] }} me-4 fa-2x"></i>
						<span class="my-4">{{ $category['link']['title'] }}</span>
						<i class="fas fa-chevron-right ms-auto"></i>
					</a>
				</li>
			@endforeach
		</ul>
		@endnotempty
	</div>
@endif