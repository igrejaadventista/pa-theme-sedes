@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PATwitter/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else
	<div class="pa-widget pa-w-twitter col-12 col-md-4 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		@notempty($url)
			<div class="mt-4 mh-50">
				<a class="twitter-timeline" data-height="500" href="{{ $url }}"></a>
			</div>
		@endnotempty
	</div>
@endif
