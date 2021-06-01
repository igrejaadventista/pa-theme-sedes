<div class="pa-widget pa-w-categories-feature col col-md-4 mb-5">
	<h2>{{ $title ?? 'Widget - Categoria - Feature' }}</h2>
	@notempty($categories)
	<div class="mt-4">
		@foreach($categories as $category)
			<h3>{{ $category['name'] }} </h3>
			{{--				@notempty($category['icon'])--}}
			{{--				<img class="rounded img-fluid" src="{{ $slide['thumbnail']['url'] }}"--}}
			{{--					 alt="{{ $slide['thumbnail']['alt'] ?: 'Imagem do slide ' . $loop->iteration }}"/>--}}
			{{--				@endnotempty--}}

			{{--				@notempty($category['title'])--}}
			{{--				<h3 class="card-title font-weight-bold h5 mt-4 pa-truncate-1">{!! $slide['title'] !!}</h3>--}}
			{{--				@endnotempty--}}
		@endforeach
	</div>
	@endnotempty
</div>
