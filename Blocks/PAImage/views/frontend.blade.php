@if(is_admin())
  <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAImage/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else
	<div class="pa-widget pa-w-image col-12 mb-5 {{ $block_format == '1/3' ? 'col-md-4' : ($block_format == '2/3' ? 'col-md-8' : '') }}">
    @notempty($link)
      <a 
        href="{{ $link['url'] }}"
        target="{{ !empty($link['target']) ? $link['target'] : '_self' }}"
      >
    @endnotempty
		
    @notempty($image)
      <img 
        class="w-100 h-auto" 
        src="{{ wp_get_attachment_image_url($image, 'full') }}"
        alt="{{ !empty($alt = get_post_meta($image, '_wp_attachment_image_alt', true)) ? $alt : get_the_title($image) }}"
      />
		@endnotempty
    
    @notempty($link)
      </a>
    @endnotempty
	</div>
@endif

