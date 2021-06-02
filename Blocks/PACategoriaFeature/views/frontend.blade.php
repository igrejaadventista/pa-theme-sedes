<div class="pa-widget pa-w-categories-feature col col-md-4 mb-5">
	<h2>{{ $title ?? 'Widget - Categoria - Feature' }}</h2>
	@notempty($categories)
	<ul class="list-unstyled mt-4">
		@foreach($categories as $category)
			<li class="pa-widget-button h-25 mb-4">
				<a href="//{{ $category['url'] }}" class="d-block d-flex px-4 align-items-center rounded fw-bold"
				   	@if ($category['targetLink'] == 1)
				   		target="_blank"
					@endif
				>
					<i class="{{ $category['icon'] }} me-4 fa-2x"></i>
					<span class="my-4">{{ $category['itemTitle'] }}</span>
					<i class="fas fa-chevron-right ms-auto"></i>
				</a>
			</li>
		@endforeach
	</ul>
	@endnotempty
</div>