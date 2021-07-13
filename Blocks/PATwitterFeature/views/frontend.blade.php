@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PATwitterFeature/preview.png" />
@else
	<div class="pa-widget pa-w-twitter-feature">
		<h2>{{ $title ?? 'Widget - Twitter - Feature' }}</h2>
		<div class="mt-4 mh-50">
			<a class="twitter-timeline" data-height="500" href="{{ $url }}"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
	</div>
@endif