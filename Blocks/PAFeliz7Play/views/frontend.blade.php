@if (is_admin())
    <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAFeliz7Play/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else 
	<div class="pa-widget pa-w-feliz7play py-4 col-12 position-relative bg-light mb-5">
		<div class="pa-slider-header mb-4">
			<div class="d-flex justify-content-between align-items-center">
				<img src="{{ get_template_directory_uri() }}/Blocks/PAFeliz7Play/assets/images/f7p-logo.svg" alt="{{ __('Feliz7Play', 'iasd') }}" title="{{ __('Feliz7Play', 'iasd') }}" class="img-fluid">

				<a 
					href="https://www.feliz7play.com" 
					target="_blank"
					class="btn btn-primary"
          rel="noopener"
				>
					{{ __('Access the website', 'iasd')}}
				</a>
			</div>
		</div>
    
    {{-- Slide --}}
		@notempty($items)
			<div class="row">
				<div class="col">
					<div class="pa-glide-feliz7play" 
               data-autoplay="{{ $active_autoplay }}"
               data-format="{{ $display_format }}">
						<div class="glide__track" data-glide-el="track">
							<div class="glide__slides">
								@foreach($items as $item)
									@notempty($item['featured_media_url'])
										<a
											href="{{ $item['link']['url'] ?? '#' }}" 
											target="{{ $item['link']['target'] ?? '_self' }}"
										>
											<div class="ratio ratio-16x9">	
												<img 
													class="glide__slide rounded" 
													src="{{ $item['featured_media_url']['pa_block_render'] }}" 
													alt="{{ $item['title']['rendered'] }}" 
												/>
											</div>	
										</a>
									@endnotempty
								@endforeach
							</div>
						</div>
						
						@if(count($items) > 1)
							<div class="pa-slider-controle d-flex justify-content-between {{ ! $nav_position ? 'justify-content-xl-center' : '' }} align-items-center mt-4">
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
			</div>
		@endnotempty
    
	</div>
@endif
