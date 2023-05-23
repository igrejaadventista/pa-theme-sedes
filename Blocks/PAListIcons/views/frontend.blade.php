@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListIcons/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
	<div class="pa-widget pa-w-list-buttons pa-w-list-buttons-icons col col-md-4 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<ul class="list-unstyled mt-4">
			@if(is_array($items))
				@foreach($items as $item)
					@notempty($item['link'])
						<li class="pa-widget-button h-25 mb-4">
							<a 
								href="{{ $item['link']['url'] ?? '#' }}" 
								target="{{ $item['link']['target'] ?? '_self' }}"
								class="d-block d-flex px-4 align-items-center rounded fw-bold" 
							>
								@notempty($item['icon'])
									<i class="{{ $item['icon'] }} me-4 fa-2x"></i>
								@endnotempty

								<span class="my-4">{{ $item['link']['title'] }}</span>

								<i class="fas fa-chevron-right ms-auto"></i>
							</a>
						</li>
					@endnotempty
				@endforeach
			@endif
			</ul>
		@endnotempty
	</div>
@endif
