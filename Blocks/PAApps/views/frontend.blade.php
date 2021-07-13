@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAApps/preview.png" />
@else
	<div class="pa-widget pa-w-apps">
		<h2>{!! $title ?? 'Widget - APPs' !!}</h2>

		<div class="pa-w-apps rounded p-4 mt-4 bg-light">
			<span class="fa-stack fa-3x">
				<i class="icon fas fa-circle fa-stack-2x"></i>

				<i class="icon fas fa-mobile-alt fa-stack-1x fa-inverse"></i>
			</span>

			<h3 class="mt-4 h5"><b>Aplicativos</b></h3>

			@notempty($description)
				<p class="mt-3">{!! $description !!}</p>
			@endnotempty

			<span class="pt-3 d-block"><b>Aplicativos disponíveis para:</b></span>

			<div class="pa-stores row gx-3 mt-3">
				<div class="col-12 col-md-6 my-2">
					<div class="pa-store d-flex align-items-center justify-content-center rounded py-2 px-3">
						<i class="fab fa-apple"></i>

						<span class="fw-bolder ms-2">Apple Store</span>
					</div>
				</div>

				<div class="col-12 my-2 col-md-6">
					<div class="pa-store d-flex align-items-center justify-content-center rounded py-2 px-3 ">
						<i class="fab fa-google-play"></i>

						<span class="fw-bolder ms-2">Google Play</span>
					</div>
				</div>
			</div>

			<a 
				href="{{ $link['url'] ?? '#' }}" 
				target="{{ $link['target'] ?? '_self' }}"
				class="btn btn-primary btn-block mt-4"
			>
				{!! $link['title'] !!}
			</a>
		</div>
	</div>
@endif