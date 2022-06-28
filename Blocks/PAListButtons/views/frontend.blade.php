@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListButtons/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}"/>
@else
	<div class="pa-widget pa-w-list-buttons col-12 col-md-4 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($items)
			<ul class="list-unstyled mt-4">
				@foreach($items as $item)
					<li class="pa-widget-button h-25 mb-4">
						<a
							href="{{ isset($item['link']) ? $item['link']['url'] : get_permalink($item['id']) }}"
							target="{{ isset($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
							class="d-block d-flex px-4 align-items-center rounded fw-bold"
						>
							<i class="pa-icon far fa-file-alt me-4 fa-2x"></i>
							<span class="my-4">{!! $item['title']['rendered'] !!}</span>
							<i class="fas fa-chevron-right ms-auto"></i>
						</a>
					</li>
				@endforeach
			</ul>
		@endnotempty

		@notempty($enable_link)
			<a
				href="{{ $link['url'] ?? '#' }}"
				target="{{ $link['target'] ?? '_self' }}"
				class="pa-all-content"
			>
				{!! $link['title'] !!}
			</a>
		@endnotempty
	</div>
@endif
