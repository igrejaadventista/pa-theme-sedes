@if(is_admin())
	<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PACarouselKits/preview.png" alt='{{ __('Illustrative image of the front end of the block.', 'iasd') }}'/>
@else  
	<div class="pa-widget pa-carousel-download col-12 mb-5">
		<div class="pa-glide-downloads"
         data-autoplay="{{ $active_autoplay }}"
         data-format="{{ $display_format }}">
			
      @notempty($title)
				<div class="d-flex mb-4">
					<h2 class="flex-grow-1">{!! $title !!}</h2>	
				</div>
			@endnotempty

			@notempty($items)
				<div class="glide__track" data-glide-el="track">
					<div class="glide__slides">
					@if(is_array($items))
						@foreach($items as $item)
							<div class="glide__slide">
								<div class="card shadow-sm border-0">
									<figure class="ratio ratio-16x9 bg-light rounded-bottom overflow-hidden">
										@notempty($item['featured_media_url'])
											<img 
												class="card-img-top"	
												src="{{ $item['featured_media_url']['pa_block_render'] }}"  
												alt="{{ $item['title']['rendered'] }}" 
											/>
										@endnotempty
									</figure>

									<div class="card-body pt-0">
										@notempty($item['title'])
                    <a 
											class="stretched-link"
											href="{{ is_array($item['link']) ? $item['link']['url'] : $item['link'] }}" 
											target="{{ is_array($item['link']) && !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}"
										>
											<h3 class="card-title fw-bold h6">{!! $item['title']['rendered'] !!}</h3>
                    </a>
										@endnotempty										
									</div>
								</div>
							</div>
						@endforeach
						@endif
					</div>
				</div>
			@endnotempty
      
      @if( ! is_null($nav_position) and count($items) > 1)
        <div class="pa-slider-controle d-flex justify-content-between {{ ! $nav_position ? 'justify-content-xl-center' : '' }} align-items-center">
          <div data-glide-el="controls" class="{{ $nav_position }}">
            <span class="fa-stack" data-glide-dir="&lt;">
              <i class="fas fa-circle fa-stack-2x"></i>
              <i class="icon fas fa-arrow-left fa-stack-1x"></i>
            </span>
          </div>
          <div class="mx-2 pa-slider-bullet" data-glide-el="controls[nav]">
            @foreach($items as $item)
              @notempty($item['featured_media_url'])
              <i class="fas fa-circle fa-xs mx-1" data-glide-dir="={{ $loop->index }}"></i>
              @endnotempty
            @endforeach
          </div >
          <div data-glide-el="controls" class="{{ $nav_position }}">
            <span class="fa-stack" data-glide-dir="&gt;">
              <i class="fas fa-circle fa-stack-2x"></i>
              <i class="icon fas fa-arrow-right fa-stack-1x"></i>
            </span>
          </div>
        </div>
      @endif
      
		</div>
	</div>
@endif
