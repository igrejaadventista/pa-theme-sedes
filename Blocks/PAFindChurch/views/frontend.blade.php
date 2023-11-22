@if(is_admin())
<img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PAFindChurch/preview.png" alt="{{ __('Illustrative image of the front end of the block.', 'iasd') }}" />
@else
<div class="pa-widget pa-find-church col-12 mb-5 position-relative">
  <div class="row py-5 px-3 px-xl-5">
    <div class="col-md-5 text-center text-md-start">
      <h1>{{ __('Finding a church', 'iasd') }}</h1>
      <p>{{ __('Adventist churches that are located in the South American Division.', 'iasd') }}</p>

      <form class="pt-4 pt-xl-3 d-flex flex-column align-items-stretch" method="GET" target="_blank" action="https://igrejas.adventistas.org/{{ LANG }}/Mapa">
        <div class="mb-3">
          <label for="find-church-input" class="form-label">{{ __('Church search', 'iasd') }}</label>

          <input id="find-church-input" name="q" type="search" class="form-control" <?= "placeholder='" . __('Search by Postcode, city, neighborhood.', 'iasd') . "'" ?> required />
        </div>

        <button type="submit" class="btn btn-primary align-self-xl-start ">{{ __('Search', 'iasd') }}</button>
      </form>
    </div>

    @notempty($quick_access)
    <div class="col d-flex flex-column justify-content-center offset-md-2 pt-5 pt-xl-0">
      @foreach($quick_access as $item)
      @notempty($item['link'])
      <a href="{{ $item['link']['url'] }}" target="{{ !empty($item['link']['target']) ? $item['link']['target'] : '_self' }}" class="d-flex pt-3">
        @endnotempty

        @notempty($item['icon'])
        <div>
          <span class="fa-stack fa-2x">
            <i class="icon fas fa-circle fa-stack-2x"></i>
            <i class="icon fa-stack-1x fa-inverse {{ $item['icon'] }}"></i>
          </span>
        </div>
        @endnotempty

        <div class="ms-4">
          @notempty($item['title'])
          <h2>{{ $item['title'] }}</h2>
          @endnotempty

          @notempty($item['description'])
          <p>{{ $item['description'] }}</p>
          @endnotempty
        </div>

        @notempty($item['link'])
      </a>
      @endnotempty
      @endforeach
    </div>
    @endnotempty
  </div>
</div>
@endif