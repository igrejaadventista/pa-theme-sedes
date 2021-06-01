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
			'click [data-action="manual-new-post"]': 'onClickAddManualPost',
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
		 * Get jQuery values input object
		 *
		 * @return {jQuery} jQuery values input object
		 */
		$manualInput() {
			return this.$control().find('[data-manual]');
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
		
		/**
		 * Initialize plugin
		 */
		initialize() {
			// Set limit and sticky values
			this.set('limit', this.$limitInput().val());
			this.set('sticky', this.$stickyInput().val());

			// Clear searc field
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
				
			// Bail early if filter has not changed
			if(this.get(filter) === val || val == '')
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
				this.$stickyInput().val('');

			if(sticky) {
				$li.appendTo(this.$stickyList());
				this.sortValues();
			}
			else {
				if ($li[0].hasAttribute('data-manual')) {
					const manualAttr = JSON.parse(this.$manualInput().val());
					const manualId = $li.data('id');
					const manualFilterId = manualAttr.filter(obj => obj.id !== manualId);

					this.$manualInput().val(JSON.stringify(manualFilterId));
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
			
			// Extra
			ajaxData.action = 'acf/fields/remote_data/query';
			ajaxData.field_key = this.get('key');
			ajaxData.sticky = this.get('sticky');
			ajaxData.limit = this.get('limit');
			ajaxData.taxonomies = this.get('taxonomies');
			ajaxData.terms = this.get('terms');
			
			return acf.applyFilters('remote_data_ajax_data', ajaxData, this);
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
			};
			
			const onSuccess = (json) => {
				// No results
				if(!json || !json.results || !json.results.length) {
					// Add message
					return this.$valuesList().append(`<li>${acf.__('No matches found')}</li>`);
				}

				// Get new results
				const html = this.walkChoices(json.results);
				
				// Append
				this.$stickyList().empty().append(html.stickyList);
				$list.append(html.list);
				this.$valuesInput().val(this.parseData(json.data));
				this.sortList();
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
						if(item != 'pa-block-render') 
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
			ajaxData.action = 'acf/fields/remote_data/search';
			ajaxData.field_key = this.get('key');
			ajaxData.exclude = [];

			this.$valuesList().find('li').each((_, element) => ajaxData.exclude.push(element.dataset.id));
			
			// Filter			
			return acf.applyFilters('remote_data_search_data', ajaxData, this);
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
			
			// Clear html if is new query
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
			// check if value is empty
			const stickyManual = this.$manualInput().val().length ? JSON.parse(this.$manualInput().val()) : [];
			// merge data from api and manual data
			const mergeItems = [].concat(data, stickyManual);
			
			mergeItems.forEach(element => {
				
				let content = `<li data-id="${acf.escAttr(element.id)}" data-date="${acf.escAttr(element.date)}"`;
				content += `${element.id.toString().startsWith('m') ? ' data-manual' : ''}><span class="acf-rel-item">`;

				if(sticky)
					content += '<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>';

				if(element.hasOwnProperty('featured_media_url')) {
					if(element.featured_media_url.hasOwnProperty('pa-block-preview'))
						content += `<img src="${element.featured_media_url['pa-block-preview']}" />`;
					else if(element.featured_media_url.hasOwnProperty('pa-block-render'))
						content += `<img src="${element.featured_media_url['pa-block-render']}" />`;
				}
				
				content += `${acf.escHtml(element.title.rendered)}</span></li>`;

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

		/**
		 * Clear and close search
		 */
		onClickClear() {
			this.$searchInput().val('');
			this.$choices().removeClass('active');
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
					text: `Limite máximo de ${limit} ite${limit == 1 ? 'm' : 'ns' } alcançado`,
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
		 * Show/hide taxonomies filters
		 */
		onClickToggleTaxonomies(e, $el) {		
			$el.toggleClass('active')
			this.$taxonomiesSelection().slideToggle();
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
			const results = this.get('results');
			const values = JSON.parse(this.$valuesInput().val());
			let sortedValues = [];

			this.$stickyInput().val('');

			this.$stickyList().find('li').each((_, element) => {
				let elementValue;

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

		/**
		 * 
		 */
		onClickAddManualPost(e, $el) {
			// console.log(e);
			var $modal = this.$control().find('.widgets-acf-modal.-fields');
			// Open modal
			modal.open($modal, {
				title: 'Manual',
				onOpen: () => {
					var $modalHeader = $modal.find('.widgets-acf-modal-title');
					$modalHeader.append('<button class="button button-primary button-sticky-add">Adicionar</button>');
					var $modalHeaderButtonAdd = $modalHeader.find('button.button-sticky-add');

					// get existing input value data
					// var $existingData = acf.getField('field_6074bcb2fba5c').val();
					var $existingData = this.$manualInput().val();
					// parse data
					var $newData = $existingData.length ? JSON.parse($existingData) : [];

					// var $existingSticky = acf.getField('field_6074bcb2fba5c').val();
					// var $existingSticky = $('input[name="acf[field_6074bcb2fba5c][sticky]"]');
					var $existingSticky = this.$stickyInput();

					// push new data to $newData
					$modalHeaderButtonAdd.click((e) => {
						// iterate fields and get fields values
						// $modal.find('.acf-fields > div').map(function( i, el ) {
						// 	console.log(el);
						// 	// get dynamic fields key
						// });

						// get acf fields inputs
						var $title = acf.getField('field_60a2d5646e5d7').val();
						var $thumbnail = $modal.find('.acf-field[data-name="thumbnail"]').find('img').attr('src');
						var $except = acf.getField('field_60a81bd49d958').val();

						var createNewFields = {
							id: `m${e.timeStamp}`,
							date: "2021-02-11T14:58:01",
							// date: Date.now(),
							title: {
								rendered: $title
							},
							featured_media_url: {
								'pa-block-render': $thumbnail
							},
							content: {
								rendered: $except
							},
						};

						$newData.push(createNewFields); // append new data

						// append updated values to input
						this.$manualInput().val(JSON.stringify($newData));
						// console.log($newData);

						// this.walkChoices($newData);

						// get current values and add new one
						$existingSticky.val(`${$existingSticky.val()},${createNewFields.id}`);
						// console.log($existingSticky.val());

						this.set('sticky', this.$stickyInput().val());

						this.fetch();
					});
				},
				onClose: () => {
				}
			});
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
			$selects.select2();
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
		},
		
	});

	// Widgets Modal
	//
	window.modal = {
        modals: [],
        
        // Open
        open: function($target, args) {
            var model = this;
            
            args = acf.parseArgs(args, {
                title: '',
                footer: false,
                size: false,
                destroy: false,
                onOpen: false,
                onClose: false,
            });
            
            model.args = args;
            
            $target.addClass('-open');
            
            if(args.size)
                $target.addClass('-' + args.size);
            
            if(!$target.find('> .widgets-acf-modal-wrapper').length)
                $target.wrapInner('<div class="widgets-acf-modal-wrapper" />');
            
            if(!$target.find('> .widgets-acf-modal-wrapper > .widgets-acf-modal-content').length)
                $target.find('> .widgets-acf-modal-wrapper').wrapInner('<div class="widgets-acf-modal-content" />');
            
            $target.find('> .widgets-acf-modal-wrapper').prepend('<div class="widgets-acf-modal-wrapper-overlay"></div><div class="widgets-acf-modal-title"><span class="title">' + args.title + '</span><button class="button button-secondary button-close">Cancelar</button></div>');
            
            $target.find('.widgets-acf-modal-title > .button-close').click(function(e) {
                e.preventDefault();
                model.close(args);
            });
            
            if(args.footer) {
                $target.find('> .widgets-acf-modal-wrapper').append('<div class="widgets-acf-modal-footer"><button class="button button-primary">' + args.footer + '</button></div>');
                
                $target.find('.widgets-acf-modal-footer > button').click(function(e){
                    e.preventDefault();
                    model.close(args);
                });
            }
            
            modal.modals.push($target);
            
            var $body = $('body');
            
            if(!$body.hasClass('widgets-acf-modal-opened')) {
				var overlay = $('<div class="widgets-acf-modal-overlay" />');
                
				$body.addClass('widgets-acf-modal-opened').append(overlay);
                
                $body.find('.widgets-acf-modal-overlay').click(function(e) {
                    e.preventDefault();
                    model.close(model.args);
                });
                
                $(window).keydown(function(e) {
                    if(e.keyCode !== 27 || !$('body').hasClass('widgets-acf-modal-opened'))
                        return;
                    
                    e.preventDefault();
                    model.close(model.args);
                });
			}
            
            modal.multiple();
            modal.onOpen($target, args);
            
            return $target;
		},
		
        // Close
		close: function(args) {
            args = acf.parseArgs(args, {
                destroy: false,
                onClose: false,
            });
            
            var $target = modal.modals.pop();
			
			$target.find('.widgets-acf-modal-wrapper-overlay').remove();
			$target.find('.widgets-acf-modal-title').remove();
			$target.find('.widgets-acf-modal-footer').remove();
            
			$target.removeAttr('style');
            
			//$target.removeClass('-open -small -medium -full');
			$target.removeClass('-open');
            
            if(args.destroy)
                $target.remove();
                
			if(!modal.modals.length) {
				$('.widgets-acf-modal-overlay').remove();
                $('body').removeClass('widgets-acf-modal-opened');
			}
            
            modal.multiple();
            modal.onClose($target, args);
		},
        
        // Multiple
        multiple: function() {
            var last = modal.modals.length - 1;
            
            $.each(modal.modals, function(i) {
                if(last == i) {
                    $(this).removeClass('widgets-acf-modal-sub').css('margin-left', '');
                    return;
                }
                
                $(this).addClass('widgets-acf-modal-sub').css('margin-left',  - (500 / (i+1)));
			});
        },
        
        onOpen: function($target, args) {
            if(!args.onOpen || !(args.onOpen instanceof Function))
                return;
            
            args.onOpen($target);
        },
        
        onClose: function($target, args) {
            if(!args.onClose || !(args.onClose instanceof Function))
                return;
            
            args.onClose($target);
        }
    };  
	
	acf.registerFieldType(Field);
})(jQuery);
