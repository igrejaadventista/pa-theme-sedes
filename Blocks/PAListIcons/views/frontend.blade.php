@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListIcons/preview.png"/>
@else
	<div class="pa-widget pa-w-list-buttons pa-w-list-buttons-icons mb-5">
		<h2>{{ $title ?? 'Widget - List icons' }}</h2>

		@notempty($items)
			<ul class="list-unstyled mt-4">
				@foreach($items as $item)
					<li class="pa-widget-button h-25 mb-4">
						<a 
							href="{{ $item['link']['url'] ?? '#' }}" 
							target="{{ $item['link']['target'] ?? '_self' }}"
							class="d-block d-flex px-4 align-items-center rounded fw-bold" 
						>
							<i class="{{ $item['icon'] }} me-4 fa-2x"></i>

							<span class="my-4">{{ $item['link']['title'] }}</span>

							<i class="fas fa-chevron-right ms-auto"></i>
						</a>
					</li>
				@endforeach
			</ul>
		@endnotempty
	</div>
@endif