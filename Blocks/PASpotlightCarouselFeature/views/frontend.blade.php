@if (is_admin())
    <img class="img-preview" src="{{ get_template_directory_uri() }}/Blocks/PASpotlightCarouselFeature/preview.png" />
@else
    @notempty($slides)
    <div class="pa-widget pa-w-carousel-ministry col col-md-8 mb-5">
        <h2>{{ $title ?? 'Widget - Carousel - Feature' }}</h2>
        <div class="mt-4">
            <div class="pa-destaque-deptos-sliders">
                <div class="glide__track" data-glide-el="track">
                    <div class="glide__slides">
                        @foreach ($slides as $slide)
                            <div class="glide__slide">
                                <a href="{{ isset($slide['link']) ? $slide['link']['url'] : get_permalink($slide['id']) }}"
                                    target="{{ isset($slide['link']) && !empty($slide['link']['target']) ? $slide['link']['target'] : '_self' }}"
                                    class="d-block">
                                    <div class="ratio ratio-16x9">
                                        <figure class="figure m-xl-0">
                                            @notempty($slide['featured_media_url'])
                                            <img class="figure-img img-fluid m-0 rounded"
                                                src="{{ $slide['featured_media_url']['pa_block_render'] }}"
                                                alt="{{ $slide['title']['rendered'] ?: 'Imagem do slide ' . $loop->iteration }}" />
                                            @endnotempty
                                            <figcaption
                                                class="figure-caption position-absolute w-100 p-3 rounded-bottom">
                                                @if (!empty($slide['cpt_label']))
                                                    <span class="pa-tag rounded-sm mb-2">{!! $slide['cpt_label']['rendered'] !!}</span>
                                                @endif
                                                <h3 class="h4 pt-2">{!! $slide['title']['rendered'] !!}</h3>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div
                    class="pa-slider-controle d-flex justify-content-between justify-content-xl-start align-items-center mt-4">
                    <div data-glide-el="controls">
                        <span class="fa-stack" data-glide-dir="<">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="icon fas fa-arrow-left fa-stack-1x"></i>
                        </span>
                    </div>

                    <div class="mx-2 pa-slider-bullet" data-glide-el="controls[nav]">
                        @foreach ($slides as $slide)
                            <i class="fas fa-circle fa-xs mx-1" data-glide-dir="={{ $loop->index }}"></i>
                        @endforeach
                    </div>

                    <div data-glide-el="controls">
                        <span class="fa-stack" data-glide-dir=">">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="icon fas fa-arrow-right fa-stack-1x"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endnotempty
@endif
