(function($, undefined) {
	var Field = acf.Field.extend({
		type: 'remote_data',
		events: {
			'keypress [data-filter]': 				 'onKeypressFilter',
			'change [data-filter]': 				 'onChangeFilter',
			'keyup [data-filter]': 					 'onChangeFilter',
			'click [data-action="sticky"]': 		 'onClickSticky',
			'click [data-action="clear"]': 			 'onClickClear',
			'click .choices-list li': 				 'onClickAdd',
			'click .-taxonomies button': 			 'onClickToggleTaxonomies',
			'click [data-action="refresh"]': 		 'fetch',
			'click [data-action="add-taxonomy"]': 	 'onClickAddTaxonomy',
			'click [data-action="remove-taxonomy"]': 'onClickRemoveTaxonomy',
		},
		
		/**
		 * Get jQuery control object
		 *
		 * @return {jQuery} jQuery control object
		 */
		$control() {
			return this.$('.acf-remote-data');
		},

		/**
		 * Get jQuery sticky input object
		 *
		 * @return {jQuery} jQuery sticky input object
		 */
		$stickyInput() {
			return this.$control().find('[data-sticky]');
		},

		/**
		 * Get jQuery search input object
		 *
		 * @return {jQuery} jQuery search input object
		 */
		$searchInput() {
			return this.$control().find('[data-filter="s"]');
		},

		/**
		 * Get jQuery limit input object
		 *
		 * @return {jQuery} jQuery limit input object
		 */
		$limitInput() {
			return this.$control().find('[data-limit]');
		},

		/**
		 * Get jQuery values input object
		 *
		 * @return {jQuery} jQuery values input object
		 */
		$valuesInput() {
			return this.$control().find('[data-values]');
		},

		/**
		 * Get jQuery button clear object
		 *
		 * @return {jQuery} jQuery button clear object
		 */
		$buttonClear() {
			return this.$control().find('.button-clear');
		},
		
		/**
		 * Get jQuery choices object
		 *
		 * @return {jQuery} jQuery choices object
		 */
		$choices() {
			return this.$('.choices');
		},

		/**
		 * Get jQuery choices list object
		 *
		 * @return {jQuery} jQuery choices list object
		 */
		$choicesList() {
			return this.$choices().find('.choices-list');
		},

		/**
		 * Get jQuery sticky list object
		 *
		 * @return {jQuery} jQuery sticky list object
		 */
		$stickyList() {
			return this.$('.sticky-list');
		},

		/**
		 * Get jQuery values list object
		 *
		 * @return {jQuery} jQuery values list object
		 */
		$valuesList() {
			return this.$('.values-list');
		},
		
		/**
		 * Get jQuery list items object
		 *
		 * @return {jQuery} jQuery list items object
		 */
		$listItems() {
			return this.$valuesList().find('.acf-rel-item');
		},
		
		/**
		 * Get jQuery item object by id
		 *
		 * @param {number} id The item id
		 * @return {jQuery} jQuery item object
		 */
		$listItem(id) {
			return this.$valuesList().find('.acf-rel-item[data-id="' + id + '"]');
		},

		/**
		 * Get jQuery search loading object
		 *
		 * @return {jQuery} jQuery search loading object
		 */
		$searchLoading() {
			return this.$control().find('.-search .acf-loading');
		},

		/**
		 * Get jQuery taxonomies selection container object
		 *
		 * @return {jQuery} jQuery taxonomies selection container object
		 */
		$taxonomiesSelection() {
			return this.$control().find('.taxonomies-selection');
		},

		/**
		 * Get jQuery taxonomy row object
		 *
		 * @return {jQuery} jQuery taxonomy row object
		 */
		$taxonomyRow() {
			return this.$control().find('.taxonomy-row');
		},

		/**
		 * Get jQuery button to add taxonomy object
		 *
		 * @return {jQuery} jQuery button to add taxonomy object
		 */
		$buttonAddTaxonomy() {
			return this.$control().find('[data-action="add-taxonomy"]');
		},

		/**
		 * Get sticky items array
		 *
		 * @return {Array} Sticky items array
		 */
		stickyItems() {
			return this.$stickyInput().val().split(',');
		},

		/**
		 * Get taxonomies list
		 *
		 * @return {string} Taxonomies array
		 */
		taxonomies() {
			return this.$control().find('.taxonomies-selection').data('taxonomies');
		},
		
		initialize() {
			// Define valores de limite e sticky
			this.set('limit', this.$limitInput().val());
			this.set('sticky', this.$stickyInput().val());

			// Limpa campo de busca
			this.$searchInput().val('');

			// Adiciona sortable
			this.$stickyList().sortable({
				items:					'li',
				forceHelperSize:		true,
				forcePlaceholderSize:	true,
				scroll:					true,
				update:	this.proxy(() => this.sortValues())
			});

			// Delay initialization until "interacted with" or "in view".
			var delayed = this.proxy(acf.once(function() {
				// Avoid browser remembering old scroll position.
				this.$valuesList('choices').scrollTop(0);
				
				// Fetch choices.
				this.fetch();

				this.$taxonomyRow().not(':first').each((index) => {
					var $row = $(this.$taxonomyRow().get(index + 1));

					this.initializeTaxonomyFilters($row);
				});

				this.checkTaxonomyFilters();
			}));
			
			// Bind "interacted with".
			this.$el.one('mouseover', delayed);
			this.$el.one('focus', 'input', delayed);
			
			// Bind "in view".
			acf.onceInView(this.$el, delayed);
		},
		
		onKeypressFilter(e, $el) {
			// don't submit form
			if(e.which == 13)
				e.preventDefault();
		},
		
		onChangeFilter(e, $el) {
			// vars
			var val = $el.val().trim();
			var filter = $el.data('filter');
				
			// Bail early if filter has not changed
			if(this.get(filter) === val || val == '')
				return;
			
			// update attr
			this.set(filter, val);

			// search must go through timeout
			this.maybeFetch(filter);
		},
		
		onClickSticky(e, $el) {
			// Prevent default here because generic handler wont be triggered.
			e.preventDefault();
			
			// vars
			var $span = $el.parent();
			var $li = $span.parent();
			var sticky = $li.parent().get(0) == this.$valuesList().get(0);

			if(this.$stickyInput().val() == 0)
				this.$stickyInput().val('');

			if(sticky) {
				$li.appendTo(this.$stickyList());
				this.sortValues();
			}
			else {
				$li.remove();
				this.sortValues();
				this.fetch();
			}
		},
		
		maybeFetch(filter) {	
			// vars
			var timeout = this.get('timeout');
			
			// abort timeout
			if(timeout)
				clearTimeout(timeout);
			
		    // fetch
		    timeout = this.setTimeout(filter == 's' ? this.search : this.fetch, 300);
		    this.set('timeout', timeout);
		},
		
		getAjaxData() {
			// load data based on element attributes
			var ajaxData = this.$control().data();

			for(var name in ajaxData)
				ajaxData[name] = this.get(name);

			this.saveTaxonomyFilters();
			
			// extra
			ajaxData.action = 'acf/fields/remote_data/query';
			ajaxData.field_key = this.get('key');
			ajaxData.sticky = this.get('sticky');
			ajaxData.limit = this.get('limit');
			ajaxData.taxonomies = this.get('taxonomies');
			ajaxData.terms = this.get('terms');
			
			// Filter.
			ajaxData = acf.applyFilters('remote_data_ajax_data', ajaxData, this);
			
			// return
			return ajaxData;
		},
		
		fetch() {
			// abort XHR if this field is already loading AJAX data
			var xhr = this.get('xhr');
			if(xhr)
				xhr.abort();
			
			// add to this.o
			var ajaxData = this.getAjaxData();
			
			// clear html if is new query
			var $list = this.$valuesList();
			$list.html('');
			
			// loading
			var $loading = $('<li class="-loading"><i class="acf-loading"></i> ' + acf.__('Loading') + '</li>');
			$list.append($loading);
			this.set('loading', true);
			
			// callback
			var onComplete = function() {
				this.set('loading', false);
				$loading.remove();
			};
			
			var onSuccess = function(json) {
				// no results
				if(!json || !json.results || !json.results.length) {
					// add message
					this.$valuesList().append('<li>' + acf.__('No matches found') + '</li>');
	
					// return
					return;
				}

				// get new results
				var html = this.walkChoices(json.results);
				
				// append
				this.$stickyList().html('');
				this.$stickyList().append(html.stickyList);
				$list.append(html.list);
				this.$valuesInput().val(json.data);
				this.sortList();
			};
			
			// get results
		    var xhr = $.ajax({
		    	url:		acf.get('ajaxurl'),
				dataType:	'json',
				type:		'post',
				data:		acf.prepareForAjax(ajaxData),
				context:	this,
				success:	onSuccess,
				complete:	onComplete,
			});
			
			// set
			this.set('xhr', xhr);
		},

		getSearchData() {
			// load data based on element attributes
			var ajaxData = this.$control().data();

			for(var name in ajaxData)
				ajaxData[name] = this.get(name);
			
			// extra
			ajaxData.action = 'acf/fields/remote_data/search';
			ajaxData.field_key = this.get('key');
			ajaxData.exclude = [];

			this.$valuesList().find('li').each((_, element) => ajaxData.exclude.push(element.dataset.id));
			
			// Filter.
			ajaxData = acf.applyFilters('remote_data_search_data', ajaxData, this);
			
			// return
			return ajaxData;
		},

		search() {
			// abort XHR if this field is already loading AJAX data
			var xhr = this.get('xhr');
			if(xhr)
				xhr.abort();
			
			// add to this.o
			var ajaxData = this.getSearchData();
			
			// clear html if is new query
			var $list = this.$choicesList();
			$list.html('');
			
			// loading
			this.$searchLoading().addClass('active');
			this.$buttonClear().removeClass('active');
			this.set('loading', true);
			
			// callback
			var onComplete = function() {
				this.set('loading', false);
				this.$searchLoading().removeClass('active');
				this.$choices().addClass('active');
				this.$buttonClear().addClass('active');
			};
			
			var onSuccess = function(json) {
				// no results
				if(!json || !json.results || !json.results.length) {
					// add message
					this.$choicesList().append('<li>' + acf.__('No matches found') + '</li>');
	
					// return
					return;
				}

				// get new results
				var html = this.walkChoices(json.results, false);
				
				// append
				$list.append(html.list);
				this.set('results', json.results);
			};
			
			// get results
		    var xhr = $.ajax({
		    	url:		acf.get('ajaxurl'),
				dataType:	'json',
				type:		'post',
				data:		acf.prepareForAjax(ajaxData),
				context:	this,
				success:	onSuccess,
				complete:	onComplete,
			});
			
			// set
			this.set('xhr', xhr);
		},
		
		walkChoices(data, sticky = true) {
			// vars
			var stickyItems = this.stickyItems();
			var list = '';
			var stickyList = '';
			
			data.forEach(element => {
				var content = '<li data-id="' + acf.escAttr(element.id) + '" data-date="' + acf.escAttr(element.date) + '"><span class="acf-rel-item">';

				if(sticky)
					content += '<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>';

				if(element.hasOwnProperty('featured_media_url')) {
					if(element.featured_media_url.hasOwnProperty('small'))
						content += `<img src="${element.featured_media_url.small}" />`;
				}
				
				content += acf.escHtml(element.title.rendered) + '</span></li>';

				if(stickyItems.includes(element.id.toString()))
					stickyList += content;
				else
					list += content;
			});
			
			return {
				list: list,
				stickyList: stickyList,
			};
		},

		onClickClear() {
			this.$searchInput().val('');
			this.$choices().removeClass('active');
			this.$buttonClear().removeClass('active');
			this.set('s', '');

			setTimeout(() => this.$choicesList().html(''), 400);
		},

		onClickAdd(e, $el) {		
			// can be added?
			if($el.hasClass('disabled'))
				return false;

			var limit = this.get('limit');
			
			// validate
			if(this.stickyItems().length == limit) {
				// add notice
				this.showNotice({
					text: `Limite máximo de ${limit} ite${limit == 1 ? 'm' : 'ns' } alcançado`,
					type: 'warning'
				});

				return false;
			}
			
			// disable
			$el.addClass('disabled');
			
			// add
			var html = this.newValue({
				id: $el.data('id'),
				date: $el.data('date'),
				text: $el.find('.acf-rel-item').html(),
			});

			this.$stickyList().append(html);
			this.sortValues();
			this.fetch();
		},

		onClickToggleTaxonomies(e, $el) {		
			$el.toggleClass('active')
			this.$taxonomiesSelection().slideToggle();
		},

		newValue(props) {
			return $([
			'<li data-id="' + props.id + '" data-date="' + props.date + '" data-from-search>',
				'<span class="acf-rel-item">' + props.text,
					'<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>',
				'</span>',
			'</li>'
			].join(''));
		},

		sortList() {
			this.$valuesList().find('li').sort(function(a, b) {
				return new Date(b.dataset.date) - new Date(a.dataset.date);
			})
			.appendTo(this.$valuesList());
		},

		sortValues() {
			var results = this.get('results');
			var values = JSON.parse(this.$valuesInput().val());
			var sortedValues = [];

			this.$stickyInput().val('');

			this.$stickyList().find('li').each((_, element) => {
				var elementValue;

				if(typeof element.dataset.fromSearch != 'undefined')
					elementValue = results.find(value => value.id == element.dataset.id);
				else
					elementValue = values.find(value => value.id == element.dataset.id);

				if(elementValue) {
					sortedValues.push(elementValue);
					this.$stickyInput().val(`${this.$stickyInput().val()},${elementValue.id}`);
				}
			});

			this.$valuesList().find('li').each((_, element) => sortedValues.push(values.find(value => value.id == element.dataset.id)));

			this.$valuesInput().val(JSON.stringify(sortedValues));
			this.$stickyInput().val(this.$stickyInput().val().replace(/(^\,+|\,+$)/mg, ''));
			this.set('sticky', this.$stickyInput().val());
		},

		onClickAddTaxonomy(e, $el) {	
			if(Object.keys(this.taxonomies()).length == this.$taxonomyRow().not(':first').length)
				return;

			var $row = this.$taxonomyRow().first().clone();
			
			$row.insertBefore($el.parent());
			$row.slideDown();

			this.initializeTaxonomyFilters($row, true);
			this.checkTaxonomyFilters();
		},

		onClickRemoveTaxonomy(e, $el) {		
			$el.parent().slideUp(() => { 
				$el.parent().remove(); 

				this.$taxonomyRow().not(':first').each((index) => {
					var $row = $(this.$taxonomyRow().get(index + 1));

					var $selectTaxonomy = $row.find('[data-taxonomy]');
					var $selectTerms = $row.find('[data-terms]');

					if($selectTaxonomy.length)
						$selectTaxonomy.attr('name', `acf[${this.get('key')}][taxonomies][${index}]`);
					if($selectTerms.length)
						$selectTerms.attr('name', `acf[${this.get('key')}][terms][${index}][]`);
				});

				this.fetch();
				this.checkTaxonomyFilters();
			});
		},

		initializeTaxonomyFilters($row, isNew = false) {
			const $selectTaxonomy = $row.find('[data-taxonomy]');
			const $selectTerms = $row.find('[data-terms]');

			if(!$selectTaxonomy.length)
				return;

			$selectTaxonomy.attr('name', `acf[${this.get('key')}][taxonomies][${this.$taxonomyRow().length - 2}]`);
			$selectTerms.attr('name', `acf[${this.get('key')}][terms][${this.$taxonomyRow().length - 2}][]`);

			if(isNew) {
				var $selects = this.$taxonomyRow().not(':first').not(':last').find('[data-taxonomy]');
				var values = [];

				$selects.map(function() {
					values.push($(this).val());
				});

				values = values.reduce(function(a, b) {
					if(a.indexOf(b) < 0)
						a.push(b);

					return a;
				}, []);

				$.each(this.taxonomies(), function(key, value) {
					$selectTaxonomy.append($('<option>', { 
						value: key,
						text : value.label,
						disabled: values.includes(key),
					}));
				});
			}

			$selectTaxonomy.on('change', () => {
				$selectTerms.find('option[value]').remove();
				
				$.each(this.taxonomies()[$selectTaxonomy.val()].terms, function (key, value) {
					$selectTerms.append($('<option>', { 
						value: key,
						text : value, 
					}));
				});
				
				$selectTaxonomy.find(`option[value="${$selectTaxonomy.val()}"]`).attr('selected', true);
				$selectTerms.val('').trigger('change');
				this.checkTaxonomyFilters();
			});

			$selectTerms.on('change', () => this.fetch());

			if(isNew)
				$selectTaxonomy.trigger('change');

			$selectTaxonomy.select2();
			$selectTerms.select2();	
		},

		checkTaxonomyFilters() {
			// Habilita/desabilita botão de acordo com a quantidade de taxonomias disponíveis
			this.$buttonAddTaxonomy().toggleClass('disabled', Object.keys(this.taxonomies()).length == this.$taxonomyRow().not(':first').length);

			const $selects = this.$taxonomyRow().not(':first').find('[data-taxonomy]');
			let values = [];

			// Coleta valores em uso
			$selects.map((_, element) => values.push($(element).val()));

			// Remove valores duplicados
			values = values.reduce((a, b) => {
				if(a.indexOf(b) < 0)
					a.push(b);

				return a;
			}, []);

			// Habilita todas opções e em seguida desabilita opções em uso
			$selects.each((_, element) => {
				const $element = $(element);
				const elementValue = $element.val();

				$element.find('option').remove();

				$.each(this.taxonomies(), function(key, value) {
					$element.append($('<option>', { 
						value: key,
						text : value.label,
						selected: elementValue == key,
					}));
				});
			});

			$.each(values, (_, value) => $selects.find(`[value="${value}"]`).not(':selected').remove());

			// Atualiza instância do select2
			$selects.select2();
		},

		saveTaxonomyFilters() {
			const $rows = this.$taxonomyRow().not(':first');
			const $selectTaxonomy = $rows.find('[data-taxonomy]');
			const $selectTerms = $rows.find('[data-terms]');

			let taxonomies = [];
			let terms = [];

			// Coleta valores selecionados
			$selectTaxonomy.each((index) => taxonomies.push($($selectTaxonomy.get(index)).val()));
			$selectTerms.each((index) => terms.push($($selectTerms.get(index)).val()));

			// Atribui os valores em uso
			this.set('taxonomies', taxonomies);
			this.set('terms', terms);
		},
		
	});
	
	acf.registerFieldType(Field);
})(jQuery);
