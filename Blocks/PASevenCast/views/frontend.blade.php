@if (is_admin())
    <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PASevenCast/preview.png" />
@else
    <div class="pa-widget pa-7cast pa-w-list-feature mb-5">
		@notempty($title)
			<h2 class="mb-4">{!! $title !!}</h2>
		@endnotempty

        @foreach($items as $item)
            <div class="card border-0 mb-3">
                <div class="d-flex flex-row align-items-center">
					@notempty($item['featured_media_url'])
						<div class="me-4">
							<img 
								src="{{ $item['featured_media_url']['pa_block_render'] }}" 
								class="rounded"
								style="min-width: 100px;border-radius: 4px" 
								alt="Thumbnail"
							/>
						</div>
					@endnotempty

					@notempty($item['link'])
						<a class="fw-normal text-decoration-none" href="{{ $item['link'] }}" href="{{ $item['target'] }}">
							<div class="card-body p-0">
								<svg viewBox="0 0 24 24" width="20" height="20" stroke="var(--bs-success)"
									stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"
									class="mb-2" aria-hidden="true"
								>
									<path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path>
									<path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
									<line x1="12" y1="19" x2="12" y2="23"></line>
									<line x1="8" y1="23" x2="16" y2="23"></line>
								</svg>

								@notempty($item['title'])
									<h6 class="card-title text-dark fw-bold mb-1">{!! $item['title'] !!}</h6>
								@endnotempty	

								@notempty($item['content'])
									<p class="card-text text-muted mb-0" style="line-height: 1.2">{!! $item['content'] !!}</p>
								@endnotempty
							</div>
						</a>
					@endnotempty
                </div>
            </div>
        @endforeach

		@notempty($enable_link)
			<a 
				href="{{ $link['url'] ?? '#' }}" 
				target="{{ $link['target'] ?? '_self' }}"
				class="fw-normal text-success text-decoration-none"
			>
				{!! $link['title'] !!}
			</a>
		@endnotempty

        {{-- @if($enable_link)
            <a 
				class="fw-normal text-success text-decoration-none" 
				href="{{ $link['url'] ?? '#' }}"
                target="{{ $link['target'] ?? '_self' }}">Ver mais podcasts <svg viewBox="0 0 24 24" width="18"
                    height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg></a>
        @endif --}}

    </div>
@endif
