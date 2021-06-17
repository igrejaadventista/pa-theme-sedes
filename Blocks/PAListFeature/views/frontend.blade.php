@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAListFeature/preview.png"/>
@else
	<div class="pa-widget pa-w-list-buttons">
		<h2><?php echo $title ? $title : 'Widget - List - Buttons'; ?></h2>
		<ul class="list-unstyled mt-4">
			@foreach($items as $item)
				<li class="pa-widget-button h-25 mb-4">
					<a href="{{ $item['link']['url'] }}" class="d-block d-flex px-4 align-items-center rounded fw-bold">
						<i class="pa-icon far fa-file-alt me-4 fa-2x"></i>
						<span class="my-4">{{ $item['link']['title'] }}</span>
						<i class="fas fa-chevron-right ms-auto"></i>
					</a>
				</li>
			@endforeach
		</ul>
		@if(!empty($checkContent))
			<a href="{{ $contents['url'] ?? '#' }}" class="pa-all-content"
			   target="{{ $contents['target'] ?? '_self' }}">{{ $contents['title'] }}</a>
		@endif
	</div>
@endif