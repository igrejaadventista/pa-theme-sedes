@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAApps/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else
	<div class="pa-widget pa-w-apps col col-md-4 mb-5">
		@notempty($title)
			<h2>{!! $title !!}</h2>
		@endnotempty

		<div class="pa-w-apps rounded p-4 mt-4 bg-light">
			<span class="fa-stack fa-3x">
				<i class="icon fas fa-circle fa-stack-2x"></i>

				<i class="icon fas fa-mobile-alt fa-stack-1x fa-inverse"></i>
			</span>

			<h3 class="mt-4 h5"><b>{{ __('Apps', 'iasd') }}</b></h3>

			@notempty($description)
				<p class="mt-3">{!! $description !!}</p>
			@endnotempty

			<span class="pt-3 d-block"><b>{{ __('Apps available for:', 'iasd') }}</b></span>

			<div class="pa-stores row gx-3 mt-3">
				<div class="col-12 col-md-6 my-2">
					<div class="pa-store d-flex align-items-center justify-content-center rounded py-2 px-3">
						<i class="fab fa-apple"></i>

						<span class="fw-bolder ms-2">{{ __('Apple Store', 'iasd') }}</span>
					</div>
				</div>

				<div class="col-12 my-2 col-md-6">
					<div class="pa-store d-flex align-items-center justify-content-center rounded py-2 px-3 ">
						<i class="fab fa-google-play"></i>

						<span class="fw-bolder ms-2">{{ __('Google Play', 'iasd') }}</span>
					</div>
				</div>
			</div>

			@notempty($link)
				@notempty($link['title'])
					<a 
						href="{{ $link['url'] ?? '#' }}" 
						target="{{ $link['target'] ?? '_self' }}"
						class="btn btn-primary btn-block mt-4"
					>
						{!! $link['title'] !!}
					</a>
				@endnotempty
			@endnotempty
		</div>
	</div>
@endif
