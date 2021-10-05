/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
function set_inline_xtt_pa_owner(event, widgetSet, nonce) {
	event.preventDefault();
	// revert Quick Edit menu so that it refreshes properly
	inlineEditPost.revert();
	var widgetInput = document.getElementById('terms-xtt-pa-owner');
	var nonceInput = document.getElementById('xtt-pa-owner-noncename');
	nonceInput.value = nonce;

	// check option manually
	for(i = 0; i < widgetInput.options.length; i++) {
		if(widgetInput.options[i].value == widgetSet)
			widgetInput.options[i].setAttribute('selected', 'selected');
		else 
			widgetInput.options[i].removeAttribute('selected');
	}
}

(function(element, components, data, i18n, lodash) {
    const el = element.createElement;
    const {useSelect} = data;
    const {SelectControl} = components;
    const {__} = i18n;
    const {get, without} = lodash;

    /**
     * Module Constants
     */
    const DEFAULT_QUERY = {
        per_page: -1,
        orderby: 'name',
        order: 'asc',
        _fields: 'id,name,parent',
        context: 'view',
    };
    const EMPTY_ARRAY = [];


    /**
     * Dropdown term selector.
     *
     * @param {Object} props      Component props.
     * @param {string} props.slug Taxonomy slug.
     * @return {WPElement}        Hierarchical term selector component.
     */
    window.DropdownTermSelector = function DropdownTermSelector({ slug }) {
        const {
            terms,
            availableTerms,
            taxonomy,
        } = useSelect(
            () => {
                const _taxonomy = data.select('core').getTaxonomy( slug );

                return {
                    terms: _taxonomy
                        ? data.select('core/editor').getEditedPostAttribute(_taxonomy.rest_base)
                        : EMPTY_ARRAY,
                    availableTerms:
                        data.select('core').getEntityRecords('taxonomy', slug, DEFAULT_QUERY) ||
                        EMPTY_ARRAY,
                    taxonomy: _taxonomy,
                };
            },
            [slug]
        );

        const {editPost} = wp.data.dispatch('core/editor');

        /**
         * Update terms for post.
         *
         * @param {number[]} termIds Term ids.
         */
        const onUpdateTerms = (termIds) => {
            termIds = [termIds[termIds.length - 1]]; 
            editPost({[taxonomy.rest_base]: termIds});
        };

        /**
         * Handler for checking term.
         *
         * @param {number} termId
         */
        const onChange = (termId) => {
            const hasTerm = terms.includes(termId);
            const newTerms = hasTerm
                ? without(terms, termId)
                : [...terms, termId];
            onUpdateTerms(newTerms);
        };

        const groupLabel = get(taxonomy, ['name'], __('Terms'));

		if(!terms.length && availableTerms.length)
			onUpdateTerms([availableTerms[0].id]);

        return el('div', {
            className: 'editor-post-taxonomies__hierarchical-terms-list',
            tabIndex: 0,
            role: 'group',
            'aria-label': groupLabel,
        }, el(SelectControl, {
            value: terms[0],
            onChange: onChange,
            options: availableTerms.map((term) => {
                return {
                    value: term.id,
                    label: term.name,
                };
            }),
        }));
    }

    function customizeTaxonomySelector(OriginalComponent) {
        return function(props) {
            if(props.slug === 'xtt-pa-owner')
                return el(DropdownTermSelector, { ...props });

            return el(OriginalComponent, { ...props });
        };
    }

    wp.hooks.addFilter('editor.PostTaxonomyType', 'adventistas-videos', customizeTaxonomySelector);
}) (
	window.wp.element,
	window.wp.components,
    window.wp.data,
    window.wp.i18n,
    window.lodash,
);