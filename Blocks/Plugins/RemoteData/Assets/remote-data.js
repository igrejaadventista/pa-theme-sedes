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
		
		$control: function() {
			return this.$('.acf-remote-data');
		},

		$stickyInput: function() {
			return this.$control().find('[data-sticky]');
		},

		$searchInput: function() {
			return this.$control().find('[data-filter="s"]');
		},

		$limitInput: function() {
			return this.$control().find('[data-limit]');
		},

		$valuesInput: function() {
			return this.$control().find('[data-values]');
		},

		$buttonClear: function() {
			return this.$control().find('.button-clear');
		},
		
		$choices: function() {
			return this.$('.choices');
		},

		$choicesList: function() {
			return this.$choices().find('.choices-list');
		},

		$stickyList: function() {
			return this.$('.sticky-list');
		},

		$list: function() {
			return this.$('.values-list');
		},

		stickyItems: function() {
			return this.$stickyInput().val().split(',');
		},
		
		$listItems: function() {
			return this.$list().find('.acf-rel-item');
		},
		
		$listItem: function(id) {
			return this.$list().find('.acf-rel-item[data-id="' + id + '"]');
		},

		$searchLoading: function() {
			return this.$control().find('.-search .acf-loading');
		},

		$taxonomiesSelection: function() {
			return this.$control().find('.taxonomies-selection');
		},

		$taxonomyRow: function() {
			return this.$control().find('.taxonomy-row').first();
		},

		order: function() {
			var index = 0;

			this.$control().find('li').each(function() {
				var itemOrder = $(this).css('order');
				index = itemOrder < index ? itemOrder : index;
			});

			return index - 1;
		},
		
		initialize: function() {
			this.set('limit', this.$limitInput().val());
			this.set('sticky', this.$stickyInput().val());
			this.$searchInput().val('');

			// Add sortable.
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
				this.$list('choices').scrollTop(0);
				
				// Fetch choices.
				this.fetch();
			}));
			
			// Bind "interacted with".
			this.$el.one('mouseover', delayed);
			this.$el.one('focus', 'input', delayed);
			
			// Bind "in view".
			acf.onceInView(this.$el, delayed);
		},
		
		onKeypressFilter: function(e, $el) {
			// don't submit form
			if(e.which == 13)
				e.preventDefault();
		},
		
		onChangeFilter: function(e, $el) {
			// vars
			var val = $el.val().trim();
			var filter = $el.data('filter');

			console.log(this.get(filter));
				
			// Bail early if filter has not changed
			if(this.get(filter) === val || val == '')
				return;
			
			// update attr
			this.set(filter, val);

			// search must go through timeout
			this.maybeFetch(filter);
		},
		
		onClickSticky: function(e, $el) {
			// Prevent default here because generic handler wont be triggered.
			e.preventDefault();
			
			// vars
			var $span = $el.parent();
			var $li = $span.parent();
			var sticky = $li.parent().get(0) == this.$list().get(0);

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
		
		maybeFetch: function(filter) {	
			// vars
			var timeout = this.get('timeout');
			
			// abort timeout
			if(timeout)
				clearTimeout(timeout);
			
		    // fetch
		    timeout = this.setTimeout(filter == 's' ? this.search : this.fetch, 300);
		    this.set('timeout', timeout);
		},
		
		getAjaxData: function() {
			// load data based on element attributes
			var ajaxData = this.$control().data();

			for(var name in ajaxData)
				ajaxData[name] = this.get(name);
			
			// extra
			ajaxData.action = 'acf/fields/remote_data/query';
			ajaxData.field_key = this.get('key');
			ajaxData.sticky = this.get('sticky');
			ajaxData.limit = this.get('limit');
			
			// Filter.
			ajaxData = acf.applyFilters('remote_data_ajax_data', ajaxData, this);
			
			// return
			return ajaxData;
		},
		
		fetch: function() {
			// abort XHR if this field is already loading AJAX data
			var xhr = this.get('xhr');
			if(xhr)
				xhr.abort();
			
			// add to this.o
			var ajaxData = this.getAjaxData();
			
			// clear html if is new query
			var $list = this.$list();
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
					this.$list().append('<li>' + acf.__('No matches found') + '</li>');
	
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

		getSearchData: function() {
			// load data based on element attributes
			var ajaxData = this.$control().data();

			for(var name in ajaxData)
				ajaxData[name] = this.get(name);
			
			// extra
			ajaxData.action = 'acf/fields/remote_data/search';
			ajaxData.field_key = this.get('key');
			ajaxData.exclude = [];

			this.$list().find('li').each((_, element) => ajaxData.exclude.push(element.dataset.id));
			
			// Filter.
			ajaxData = acf.applyFilters('remote_data_search_data', ajaxData, this);
			
			// return
			return ajaxData;
		},

		search: function() {
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
		
		walkChoices: function(data, sticky = true) {
			// vars
			var stickyItems = this.stickyItems();
			var list = '';
			var stickyList = '';
			
			data.forEach(element => {
				var content = '<li data-id="' + acf.escAttr(element.id) + '" data-date="' + acf.escAttr(element.date) + '"><span class="acf-rel-item">';

				if(sticky)
					content += '<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>';

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

		onClickClear: function() {
			this.$searchInput().val('');
			this.$choices().removeClass('active');
			this.$buttonClear().removeClass('active');
			this.set('s', '');

			setTimeout(() => this.$choicesList().html(''), 400);
		},

		onClickAdd: function(e, $el) {		
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

		onClickToggleTaxonomies: function(e, $el) {		
			$el.toggleClass('active')
			this.$taxonomiesSelection().slideToggle();
		},

		newValue: function(props) {
			return $([
			'<li data-id="' + props.id + '" data-date="' + props.date + '" data-from-search>',
				'<span class="acf-rel-item">' + props.text,
					'<a href="#" class="acf-icon -pin small dark acf-js-tooltip" data-action="sticky" title="Fixar/Desafixar item"></a>',
				'</span>',
			'</li>'
			].join(''));
		},

		sortList: function() {
			this.$list().find('li').sort(function(a, b) {
				return new Date(b.dataset.date) - new Date(a.dataset.date);
			})
			.appendTo(this.$list());
		},

		sortValues: function() {
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

			this.$list().find('li').each((_, element) => sortedValues.push(values.find(value => value.id == element.dataset.id)));

			this.$valuesInput().val(JSON.stringify(sortedValues));
			this.$stickyInput().val(this.$stickyInput().val().replace(/(^\,+|\,+$)/mg, ''));
			this.set('sticky', this.$stickyInput().val());
		},

		onClickAddTaxonomy: function(e, $el) {		
			var $row = this.$taxonomyRow().clone();
			
			$row.insertBefore($el.parent());
			$row.slideDown();
		},

		onClickRemoveTaxonomy: function(e, $el) {		
			$el.parent().slideUp(() => $el.parent().remove());
		},
		
	});
	
	acf.registerFieldType(Field);
})(jQuery);