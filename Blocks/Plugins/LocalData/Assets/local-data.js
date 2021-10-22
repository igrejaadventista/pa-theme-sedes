(function($, undefined) {
	var Field = acf.Field.extend({
		type: 'localposts_data',
		events: {
			'keypress [data-filter]': 				 	'onKeypressFilter',
			'change [data-filter="post_type"]':			'onChangeFilter',
			'change [data-filter="limit"]': 			'onChangeFilter',
			'keyup [data-filter]': 					 	'onChangeFilter',
			'click [data-action="sticky"]': 		 	'onClickSticky',
			'click [data-action="clear"]': 			 	'onClickClear',
			'click .choices-list li': 				 	'onClickAdd',
      'click .-taxonomies button': 			 	'onClickToggleTaxonomies',
			'click [data-action="refresh"]': 		 	'fetch',
      'click [data-action="add-taxonomy"]': 	 	'onClickAddTaxonomy',
			'click [data-action="remove-taxonomy"]': 	'onClickRemoveTaxonomy',
			'click [data-action="manual-new-post"]': 	'onClickAddManualPost',
			'click [data-action="edit-manual"]': 		'onEditManual',
		},

		/**
		 * Get jQuery control object
		 *
		 * @return {jQuery} jQuery control object
		 */
		$control() {
			return this.$('.acf-local-data');
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
		 * Get jQuery values input object
		 *
		 * @return {jQuery} jQuery values input object
		 */
		$manualInput() {
			return this.$control().find('[data-manual]');
		},

		/**
		 * Get jquery manual item new action button
		 *
		 * @return {jQuery} jQuery values input object
		 */
		$manualAddActionButton() {
			return this.$('[data-action="manual-new-post"]');
		},

		/**
		 * Search for ACF fields using custom parameters
		 *
		 * @param {*} slug name of field slug
		 * @param {*} el dom elements
		 *
		 * @returns {string}
		 */
		$acfInputName(slug, el = 'input') {
			return this.$control().find('.acf-fields').find('[data-name=' + slug + ']').find(el);
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
		 * Disable add manual item button if matches
		 */
		$isExceeded(value) {
			this.$manualAddActionButton()
				.toggleClass('disabled', value)
				.attr('disabled', (_, attr) => value ? 'disabled' : null)
				.text(value ? 'Limite atingido!' : 'Adicionar');
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
		 * Get taxonomies list
		 *
		 * @return {string} Taxonomies array
		 */
		taxonomies() {
			return this.$control().find('.taxonomies-selection').data('taxonomies');
		},

    /**
		 * Get jQuery taxonomies hidden input object
		 *
		 * @return {jQuery} jQuery taxonomies hidden input
		 */
		$taxonomiesInputValue() {
			return this.$control().find('[data-taxonomies-value]');
		},

    /**
		 * Get jQuery tems hidden input object
		 *
		 * @return {jQuery} jQuery tems hidden input
		 */
		$termsInputValue() {
			return this.$control().find('[data-terms-value]');
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
		 * Get current post type value
		 */
		getPostType() {
			return this.$control().find('[data-filter="post_type"]').val();
		},

		/**
		 * Get sticky items array
		 *
		 * @return {Array} Sticky items array
		 */
		stickyItems() {
			return this.empty(this.$stickyInput().val()) ? [] : this.$stickyInput().val().split(',');
		},

		empty(data) {
			if(typeof(data) == 'boolean') 
				return !data; 
			if(typeof(data) == 'number') 
				return data == 0; 
			if(typeof(data) === 'undefined' || data === null)
				return true; 
			if(typeof(data.length) != 'undefined')
				return data.length == 0;

			var count = 0;
			for(var i in data) {
				if(data.hasOwnProperty(i))
					count ++;
			}

			return count == 0;
		},

		/**
		 * Initialize plugin
		 */
		initialize() {
			// Set limit and sticky values
			this.set('limit', this.$limitInput().val());
			this.set('sticky', this.$stickyInput().val());
			this.set('canSticky', parseInt(this.$control().get(0).dataset.can_sticky));

			// Clear search field
			this.$searchInput().val('');

			// Add sortable
			this.$stickyList().sortable({
				items:					'li',
				forceHelperSize:		true,
				forcePlaceholderSize:	true,
				scroll:					true,
				update:	this.proxy(() => this.sortValues())
			});

			// Delay initialization until "interacted with" or "in view"
			const delayed = this.proxy(acf.once(() => {
				// Avoid browser remembering old scroll position
				this.$valuesList('choices').scrollTop(0);

				// Fetch choices
				this.fetch();
        this.$taxonomyRow().not(':first').each((index) => this.initializeTaxonomyFilters($(this.$taxonomyRow().get(index + 1))));
				this.checkTaxonomyFilters();
			}));

			// Bind "interacted with"
			this.$el.one('mouseover', delayed);
			this.$el.one('focus', 'input', delayed);

			// Bind "in view"
			acf.onceInView(this.$el, delayed);
			this.$limitInput().on('change', () => {
				if(this.$limitInput().val() < this.stickyItems().length)
					this.$limitInput().val(this.stickyItems().length);
			});
		},

		/**
		 * Don't submit form
		 */
		onKeypressFilter(e, $el) {
			if(e.which == 13)
				e.preventDefault();
		},

		/**
		 * On changes on filters
		 */
		onChangeFilter(e, $el) {
			const val = $el.val().trim();
			const filter = $el.data('filter');

			if(this.empty(val)) {
				if(filter == 's')
					this.onClickClear();
				return;
			}

			if(this.get(filter) == val)
				return;

			// Update attr
			this.set(filter, val);

			// Search must go through timeout
			this.maybeFetch(filter);
		},

		/**
		 * On sticky items
		 */
		onClickSticky(e, $el) {
			// Prevent default here because generic handler wont be triggered
			e.preventDefault();

			const $span = $el.parent();
			const $li = $span.parent();
			const sticky = $li.parent().get(0) == this.$valuesList().get(0);

			if(this.$stickyInput().val() == 0)
				this.$stickyInput().val('').trigger('change');

			if(sticky) {
				$li.appendTo(this.$stickyList());

				// Update the list to validate the allowed quantity of items
				if(e.type === 'click')
					this.$isExceeded((this.stickyItems().length + 1) >= parseInt(this.$limitInput().val()));

				this.sortValues();
				// Update the list to validate the allowed quantity of items
				this.fetch(); // update data list on sticky item
			} 
			else {
				if($li[0].hasAttribute('data-manual')) {
					const manualAttr = JSON.parse(this.$manualInput().val());
					// get sticky item id
					const manualId = $li.data('id');
					const manualFilterId = manualAttr.filter(obj => obj.id != manualId);

					this.$manualInput().val(JSON.stringify(manualFilterId)).trigger('change');
				}

				this.$choicesList().find(`[data-id="${$li.data('id')}"]`).removeClass('disabled');
				$li.remove();
				this.sortValues();
				this.fetch();
			}
		},

		/**
		 * Check if can fetch data
		 */
		maybeFetch(filter) {
			let timeout = this.get('timeout');

			// Abort timeout
			if(timeout)
				clearTimeout(timeout);

		    // Fetch
		    timeout = this.setTimeout(filter == 's' ? this.search : this.fetch, 300);
		    this.set('timeout', timeout);
		},

		/**
		 * Load fetch data
		 */
		getAjaxData() {
			// Load data based on element attributes
			let ajaxData = this.$control().data();

			for(let name in ajaxData)
				ajaxData[name] = this.get(name);

      this.saveTaxonomyFilters();

			// get current filter state value
			let currSelectedPostType = this.getPostType();
			let selectedPostType = currSelectedPostType !== "" ?
			currSelectedPostType : this.get('post_type');

			// Extra
			ajaxData.action = 'acf/fields/localposts_data/query';
			ajaxData.post_type = selectedPostType;
			ajaxData.field_key = this.get('key');
			ajaxData.sticky = this.get('sticky');
			ajaxData.limit = this.get('limit') < this.stickyItems().length ? this.stickyItems().length : this.get('limit');
      ajaxData.taxonomies = this.get('taxonomies');
      ajaxData.terms = this.get('terms');

			return acf.applyFilters('localposts_data_ajax_data', ajaxData, this);
		},

		/**
		 * Fetch results
		 */
		fetch() {
			// Abort XHR if this field is already loading AJAX data
			let xhr = this.get('xhr');
			if(xhr)
				xhr.abort();

			const ajaxData = this.getAjaxData();

			// Clear html if is new query
			const $list = this.$valuesList();
			$list.empty();

			// Loading
			const $loading = $(`<li class="-loading"><i class="acf-loading"></i>${acf.__('Loading')}</li>`);
			$list.append($loading);
			this.set('loading', true);

			const onComplete = () => {
				this.set('loading', false);
				$loading.remove();

				// check if has manual values
				let hasManualData = this.$manualInput().val() !== '' ? JSON.parse(this.$manualInput().val()) : [];
				// add edit button to manual lists
				if(hasManualData.length)
					this.$stickyList().find('li[data-manual] > .acf-rel-item').append('<button class="editManualButton acf-js-tooltip" type="button" data-action="edit-manual" aria-label="Editar" title="Editar"><svg viewBox="0 0 24 24" width="10" height="10" stroke="currentColor" aria-label="hidden" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></button>');
			};

			const onSuccess = (json) => {
				// Stop if No (local cpt data) results
				if(!json || !json.results || !json.results.length)
					// Add message
					this.$valuesList().append(`<li>${acf.__('No matches found')}</li>`);

				// Get new results
				const html = this.walkChoices(json.results);

				// Append
				this.$stickyList().empty().append(html.stickyList);
				$list.append(html.list);

				// this.sortList();
				this.sortValues();
			};

			// Get results
		    xhr = $.ajax({
		    	url:		acf.get('ajaxurl'),
				dataType:	'json',
				type:		'post',
				data:		acf.prepareForAjax(ajaxData),
				context:	this,
				success:	onSuccess,
				complete:	onComplete,
			});

			this.set('xhr', xhr);
		},

		/**
		 * Parse data and remove unnecessary properties
		 *
		 * @return {string} Parsed data
		 */
		parseData(data) {
			data = JSON.parse(data);

			if(!Array.isArray(data))
				return JSON.stringify(data);

			$.each(data, (_, element) => {
				if(element.hasOwnProperty('featured_media_url')) {
					// Delete all except pa-block-render
					Object.keys(element.featured_media_url).forEach((item) => {
						if(item != 'pa_block_render')
							delete element.featured_media_url[item];
					});
				}
			});

			return JSON.stringify(data);
		},

		/**
		 * Load search data
		 */
		getSearchData() {
			// Load data based on element attributes
			let ajaxData = this.$control().data();

			for(let name in ajaxData)
				ajaxData[name] = this.get(name);

			// Extra
			ajaxData.action = 'acf/fields/localposts_data/search';
			ajaxData.field_key = this.get('key');
			// posts to show
			ajaxData.limit = 20;
			ajaxData.exclude = [];

			this.$valuesList().find('li').each((_, element) => ajaxData.exclude.push(element.dataset.id));

			return acf.applyFilters('localposts_data_ajax_data', ajaxData, this);
		},

		/**
		 * Make search
		 */
		search() {
			// Abort XHR if this field is already loading AJAX data
			let xhr = this.get('xhr');
			if(xhr)
				xhr.abort();

			// Add to this.o
			const ajaxData = this.getSearchData();

			// Clear html content if is new query
			const $list = this.$choicesList();
			$list.empty();

			// Loading
			this.$searchLoading().addClass('active');
			this.$buttonClear().removeClass('active');
			this.set('loading', true);

			const onComplete = () => {
				this.set('loading', false);
				this.$searchLoading().removeClass('active');
				this.$choices().addClass('active');
				this.$buttonClear().addClass('active');
			};

			const onSuccess = (json) => {
				// No results
				if(!json || !json.results || !json.results.length)
					// Add message
					return this.$choicesList().append(`<li>${acf.__('No matches found')}</li>`);

				// Get new results
				const html = this.walkChoices(json.results, false);

				// Append
				$list.append(html.list);
				this.set('results', json.results);
			};

			// Get results
		    xhr = $.ajax({
		    	url:		acf.get('ajaxurl'),
				dataType:	'json',
				type:		'post',
				data:		acf.prepareForAjax(ajaxData),
				context:	this,
				success:	onSuccess,
				complete:	onComplete,
			});
			
			this.set('xhr', xhr);
		},

		/**
		 * Walk results and create html
		 */
		walkChoices(data, sticky = true) {
			const stickyItems = this.stickyItems();

			let list = '';
			let stickyList = '';

			// check if manual input has values
			const stickyManual = this.$manualInput().val().length ? JSON.parse(this.$manualInput().val()) : [];
			// merge data from api and manual data
			let mergeItems = [].concat(data, stickyManual);

			let stickyOrder = [];
			stickyItems.forEach(elms => {
				const item = mergeItems.find(item => item.id == elms);

				mergeItems = mergeItems.filter((value) => {
					return value != item;
				});

				// check if array sticky input value is not empty
				if(stickyItems[0] !== "" && typeof item !== 'undefined')
					stickyOrder.push(item);
			});

			// merge data objects if sticky values exists on input
			let mergedData = stickyOrder.length ? [].concat(stickyOrder, mergeItems) : mergeItems;

			mergedData.forEach(element => {
				// results has empty
				if(Object.values(element).includes("0"))
					return this.$valuesList().append(`<li>${acf.__('No matches found')}</li>`);

				// html
				let content = `<li data-id="${acf.escAttr(element.id)}" data-date="${acf.escAttr(element.date)}" title="${acf.escAttr(element.title.rendered)}"`;
					content += `${element.id.toString().startsWith('m') ? ' data-manual' : ''}><span class="acf-rel-item">`;

				if(sticky && !this.empty(this.get('canSticky')) ||
					sticky && this.empty(this.get('canSticky')) && stickyItems.includes(element.id.toString()))
					content += '<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>';

				if(element.hasOwnProperty('featured_media_url')) {
					if(element.featured_media_url.hasOwnProperty('pa-block-preview'))
						content += this.empty(element.featured_media_url['pa-block-preview']) ? '<div class="thumb"></div>' : `<img src="${element.featured_media_url['pa-block-preview']}" alt="Thumbnail" />`;
					else if(element.featured_media_url.hasOwnProperty('pa_block_render'))
						content += this.empty(element.featured_media_url['pa_block_render']) ? '<div class="thumb"></div>' : `<img src="${element.featured_media_url['pa_block_render']}" alt="Thumbnail" />`;
				}
				else
					content += '<div class="thumb"></div>';

				content += `<div class="walker__item">`;
					content += `<div>${acf.escHtml(element.title.rendered)}</div>`;
					content += `${element.id.toString().startsWith('m') ? '' : `<div class="badge__pill">${element.cpt_label.rendered}</div>`}`;
				content += `</div>`;

				content += `</span></li>`;

				if(stickyItems.includes(element.id.toString()))
					stickyList += content;
				else
					list += content;
			});

			// check if limit filter exceeds
			let validateLimit = true;
			let currFilterLimit = parseInt(this.$limitInput().val());
			let exceedLimit = stickyItems.length >= currFilterLimit ? true : false;
				validateLimit = exceedLimit;

			this.$isExceeded(validateLimit);

			// validate on qtd change
			this.$limitInput().change((e) => this.$isExceeded(stickyItems.length >= e.target.value));

			return {
				list: list,
				stickyList: stickyList,
			};
		},

		/**
		 * Clear and close search
		 */
		onClickClear() {
			this.$searchInput().val('');
			this.$choices().removeClass('active');
			this.$valuesList().addClass('active');
			this.$buttonClear().removeClass('active');
			this.set('s', '');

			setTimeout(() => this.$choicesList().html(''), 400);
		},

		/**
		 * Add search result as sticky item
		 */
		onClickAdd(e, $el) {
			// Can be added?
			if($el.hasClass('disabled'))
				return false;

			const limit = this.get('limit');

			// Validate
			if(this.stickyItems().length == limit) {
				// Add notice
				this.showNotice({
					text: `Limite máximo de ${limit} ite${limit == 1 ? 'm' : 'ns' } atingido`,
					type: 'warning',
				});

				return false;
			}

			$el.addClass('disabled');

			// Add
			var html = this.newValue({
				id: $el.data('id'),
				date: $el.data('date'),
				text: $el.find('.acf-rel-item').html(),
			});

			this.$stickyList().append(html);
			this.sortValues();
			this.fetch();	
		},

		/**
		 * Create item html
		 *
		 * @param {object} props The item data
		 * @return {string} Item html
		 */
		newValue(props) {
			return $([
			`<li data-id="${props.id}" data-date="${props.date}" data-from-search>`,
				`<span class="acf-rel-item">${props.text}`,
					'<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>',
				'</span>',
			'</li>'
			].join(''));
		},

		/**
		 * Sort list by date
		 */
		sortList() {
			this.$valuesList().find('li').sort((a, b) => {
				return new Date(b.dataset.date) - new Date(a.dataset.date);
			})
			.appendTo(this.$valuesList());
		},

		/**
		 * Sort sticky items
		 */
		sortValues() {
			// clean sticky input
			this.$stickyInput().val('');

			this.$stickyList().find('li').each((_, element) => this.$stickyInput().val(`${this.$stickyInput().val()},${element.dataset.id}`));

			// remove first comma from sticky items
			this.$stickyInput().val(this.$stickyInput().val().replace(/(^\,+|\,+$)/mg, '')).trigger('change');
			this.set('sticky', this.$stickyInput().val());
		},

    /**
		 * Show/hide taxonomies filters
		 */
		onClickToggleTaxonomies(e, $el) {
			$el.toggleClass('active')
			this.$taxonomiesSelection().slideToggle();
		},

    /**
		 * Add taxonomy row
		 */
		onClickAddTaxonomy(e, $el) {
			if(Object.keys(this.taxonomies()).length == this.$taxonomyRow().not(':first').length)
				return;

			const $row = this.$taxonomyRow().first().clone();

			$row.insertBefore($el.parent()).slideDown();

			this.initializeTaxonomyFilters($row, true);
			this.checkTaxonomyFilters();
		},

		/**
		 * Remove taxonomy row
		 */
		onClickRemoveTaxonomy(e, $el) {
			$el.parent().slideUp(() => {
				$el.parent().remove();

				this.$taxonomyRow().not(':first').each((index) => {
					const $row = $(this.$taxonomyRow().get(index + 1));

					const $selectTaxonomy = $row.find('[data-taxonomy]');
					const $selectTerms = $row.find('[data-terms]');

					if($selectTaxonomy.length)
						$selectTaxonomy.attr('name', `acf[${this.get('key')}][taxonomies][${index}]`);
					if($selectTerms.length)
						$selectTerms.attr('name', `acf[${this.get('key')}][terms][${index}][]`);
				});

				this.fetch();
				this.checkTaxonomyFilters();
			});
		},

    /**
		 * Initialize taxonomies filters
		 */
		initializeTaxonomyFilters($row, isNew = false) {
			const $selectTaxonomy = $row.find('[data-taxonomy]');
			const $selectTerms = $row.find('[data-terms]');

			if(!$selectTaxonomy.length)
				return;

			$selectTaxonomy.attr('name', `acf[${this.get('key')}][taxonomies][${this.$taxonomyRow().length - 2}]`);
			$selectTerms.attr('name', `acf[${this.get('key')}][terms][${this.$taxonomyRow().length - 2}][]`);

			if(isNew) {
				const $selects = this.$taxonomyRow().not(':first').not(':last').find('[data-taxonomy]');
				let values = [];

				$selects.map((_, element) => values.push($(element).val()));

				values = values.reduce((a, b) => {
					if(a.indexOf(b) < 0)
						a.push(b);

					return a;
				}, []);

				$.each(this.taxonomies(), (key, value) => {
					$selectTaxonomy.append($('<option>', {
						value: key,
						text : value.label,
						disabled: values.includes(key),
					}));
				});
			}

			$selectTaxonomy.on('change', () => {
				$selectTerms.find('option[value]').remove();

				$.each(this.taxonomies()[$selectTaxonomy.val()].terms, (key, value) => {
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

		/**
		 * Check taxonomies filters on row added/removed
		 */
		checkTaxonomyFilters() {
			if(!this.$buttonAddTaxonomy().length)
				return;
			// Enable/disable button
			this.$buttonAddTaxonomy().toggleClass('disabled', Object.keys(this.taxonomies()).length == this.$taxonomyRow().not(':first').length);

			const $selects = this.$taxonomyRow().not(':first').find('[data-taxonomy]');
			let values = [];

			// Get options in use
			$selects.map((_, element) => values.push($(element).val()));

			// Remove duplicate values
			values = values.reduce((a, b) => {
				if(a.indexOf(b) < 0)
					a.push(b);

				return a;
			}, []);

			// Remove options in use
			$selects.each((_, element) => {
				const $element = $(element);
				const elementValue = $element.val();

				$element.find('option').remove();

				$.each(this.taxonomies(), (key, value) => {
					$element.append($('<option>', {
						value: key,
						text : value.label,
						selected: elementValue == key,
					}));
				});
			});

			$.each(values, (_, value) => $selects.find(`[value="${value}"]`).not(':selected').remove());

			// Refresh select2
			// $selects.select2();
		},

		/**
		 * Save taxonomies filters
		 */
		saveTaxonomyFilters() {
			const $rows = this.$taxonomyRow().not(':first');
			const $selectTaxonomy = $rows.find('[data-taxonomy]');
			const $selectTerms = $rows.find('[data-terms]');

			let taxonomies = [];
			let terms = [];

			// Get selected values
			$selectTaxonomy.each((index) => taxonomies.push($($selectTaxonomy.get(index)).val()));
			$selectTerms.each((index) => terms.push($($selectTerms.get(index)).val()));

			this.set('taxonomies', taxonomies);
			this.set('terms', terms);

      this.$taxonomiesInputValue().val(JSON.stringify(taxonomies));
      this.$termsInputValue().val(JSON.stringify(terms));
		},

		/**
		 * Parse fields and collect data
		 *
		 * @param {jQuery} $modal The modal element
		 * @param {string} data Values on edit data
		 */
		modalContent($modal, data = null) {
			const $modalContent = $modal.find('.widgets-acf-modal-content');
			const $loading = $(`<span class="-loading"><i class="acf-loading"></i>${acf.__('Loading')}</span>`);

			$modalContent.empty();
			$modalContent.append($loading);
			this.set('loading', true);

			const ajaxData = {
				action: 'acf/fields/localposts_data/modal',
				field_key: this.get('key'),
			};

			if(data)
				ajaxData.data = data;

			const onComplete = () => {
				$loading.remove();
				this.set('loading', false);
			};

			const onSuccess = (data) => {
				// No results
				$modalContent.html(data);
				acf.do_action('append', $modalContent);

				$modalContent.find('[data-name="link"] [data-name="add"], [data-name="link"] [data-name="edit"]').on('click', () => $('#wp-link-wrap').addClass('-no-label'));
				$('#wp-link-close, #wp-link-submit, #wp-link-cancel button, #wp-link-backdrop').on('click', () => $('#wp-link-wrap').removeClass('-no-label'));
			};

			// Get results
			$.ajax({
				url:		acf.get('ajaxurl'),
				type:		'post',
				data:		acf.prepareForAjax(ajaxData),
				context:	this,
				success:	onSuccess,
				complete:	onComplete,
			});
		},

		/**
		 * Parse fields and collect data
		 *
		 * @param {jQuery} $modal The modal element
		 * @param {string} id ID on edit data
		 *
		 * @return {object} Object with data values
		 */
		parseModalFields($modal, id = null) {
			const $fields = $modal.find('.acf-field');
			let values = {};
			let hasInvalid = false;

			$fields.each((_, element) => {
				const field = acf.getField($(element));

				if(this.empty(field.getValue()) && element.dataset.required == 1) {
					hasInvalid = true;
					field.showError('Campo obrigatório');
				}

				if(field.data.name == 'featured_media_url')
					values[field.data.name] = {
						id: field.getValue(),
						url: $(element).find('img').attr('src'),
					};
				else
					values[field.data.name] = field.getValue();
			});

			if(hasInvalid)
				return null;

			const $date = new Date();

			if(!id)
				id = `m${$date.getUTCMilliseconds()}`;

			let createNewFields = {
				id: id,
				date: $date.toISOString(),
				title: {
					rendered: values.title,
				},
				link: values.link,
			};

			delete values.title;
			delete values.link;

			if(values.hasOwnProperty('featured_media_url')) {
				createNewFields.featured_media_url = {
					id: values.featured_media_url.id,
					pa_block_render: values.featured_media_url.url,
				};

				delete values.featured_media_url;
			}

			if(values.hasOwnProperty('excerpt')) {
				createNewFields.excerpt = {
					rendered: values.excerpt,
				};

				delete values.excerpt;
			}
		
			return $.extend(createNewFields, values);
		},

		/**
		 * Add manual (local) items
		 */
		onClickAddManualPost() {
			const $modal = this.$control().find('.widgets-acf-modal.-fields');

			// Open modal
			this.modal.open($modal, {
				title: 'Adicionar item',
				onOpen: () => {
					let modalHeader = $modal.find('.widgets-acf-modal-title');
					modalHeader.append('<button class="button button-primary button-sticky-add" data-name="manualSubmit">Adicionar</button>');
					let buttonAdd = modalHeader.find('[data-name="manualSubmit"]');

					this.modalContent($modal);

					// get existing input value data
					let currentData = this.$manualInput().val();
					// check if value has length
					let newData = currentData.length ? JSON.parse(currentData) : [];
					let existingSticky = this.$stickyInput();

					buttonAdd.click(() => {
						const values = this.parseModalFields($modal);

						if(!values)
							return;

						newData.push(values);

						// append updated values to input
						this.$manualInput().val(JSON.stringify(newData)).trigger('change');

						// get current values and add new one
						existingSticky.val(`${existingSticky.val()},${values.id}`);

						// remove first comma from sticky items
						this.$stickyInput().val(this.$stickyInput().val().replace(/(^\,+|\,+$)/mg, '')).trigger('change');

						this.set('sticky', this.$stickyInput().val());

						this.fetch();

						this.modal.close();
					});
				}
			});
		},

		/**
		 * Edit manual (local) items
		 *
		 * @param {*} e
		 * @param {*} $el
		 */
		onEditManual(e, $el) {
			const $modal = this.$control().find('.widgets-acf-modal.-fields');

			// get current item id
			const item_ID = $el.parent().parent().attr('data-id');

			this.modal.open($modal, {
				title: 'Editar',
				onOpen: () => {
					// add header button action
					let modalHeader = $modal.find('.widgets-acf-modal-title');
					modalHeader.append('<button class="button button-primary button-sticky-add" data-name="editSubmit">Conlcuir</button>');
					let buttonEdit = modalHeader.find('[data-name="editSubmit"]');
					// get original data
					let originalData = JSON.parse(this.$manualInput().val());
					// get current item object by id
					let editData = JSON.parse(this.$manualInput().val());

					editData, editIndex = editData.findIndex(obj => obj.id == item_ID);

					this.modalContent($modal, editData[editIndex]);

					buttonEdit.click(() => {
						const values = this.parseModalFields($modal, item_ID);

						if(!values)
							return;

						// update fields
						editData[editIndex] = values;

						let updatedData = editData;

						// check if objects is iqual
						const objectsEqual = (oldValue, newValue) => {
							return typeof oldValue === 'object' && Object.keys(oldValue).length > 0
							? Object.keys(oldValue).length === Object.keys(newValue).length
							&& Object.keys(oldValue).every(p => objectsEqual(oldValue[p], newValue[p])) : oldValue === newValue;
						}

						let compare = objectsEqual(originalData, updatedData);
						if(!compare) {
							// append updated values to input
							this.$manualInput().val(JSON.stringify(updatedData)).trigger('change');
							this.fetch();
							this.modal.close();
						};

						this.modal.close();
					});
				}
			});
		},

		// Widgets Modal
		modal: {
			current: null,

			// Open
			open: ($target, args) => {
				const modal = acf.getFieldType('localposts_data').prototype.modal;

				args = acf.parseArgs(args, {
					title: '',
					destroy: false,
					onOpen: false,
					onClose: false,
				});

				$target.addClass('-open');

				if(!$target.find('> .widgets-acf-modal-wrapper').length)
					$target.wrapInner('<div class="widgets-acf-modal-wrapper" />');

				if(!$target.find('> .widgets-acf-modal-wrapper > .widgets-acf-modal-content').length)
					$target.find('> .widgets-acf-modal-wrapper').wrapInner('<div class="widgets-acf-modal-content" />');

				$target.find('> .widgets-acf-modal-wrapper').prepend('<div class="widgets-acf-modal-wrapper-overlay"></div><div class="widgets-acf-modal-title"><span class="title">' + args.title + '</span><button class="button button-secondary button-close">Cancelar</button></div>');

				$target.find('.widgets-acf-modal-title .button-close').click((e) => {
					e.preventDefault();
					modal.close(args);
				});

				modal.current = $target;

				modal.onOpen($target, args);

				return $target;
			},

			// Close
			close: (args) => {
				const modal = acf.getFieldType('localposts_data').prototype.modal;

				args = acf.parseArgs(args, {
					destroy: false,
					onClose: false,
				});

				if(modal.current) {
					modal.current.find('.widgets-acf-modal-title').remove();
					modal.current.removeAttr('style');
					modal.current.removeClass('-open');

					if(args.destroy)
						modal.current.remove();
				}

				modal.onClose(modal.current, args);
			},

			onOpen: ($target, args) => {
				if(!args.onOpen || !(args.onOpen instanceof Function))
					return;

				args.onOpen($target);
			},

			onClose: ($target, args) => {
				if(!args.onClose || !(args.onClose instanceof Function))
					return;

				args.onClose($target);
			},
		},

	});

	acf.registerFieldType(Field);
})(jQuery);
