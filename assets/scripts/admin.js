/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
function set_inline_xtt_pa_owner(event, widgetSet, nonce) {
  event.preventDefault();
  // revert Quick Edit menu so that it refreshes properly
  inlineEditPost.revert();
  var widgetInput = document.getElementById("terms-xtt-pa-owner");
  var nonceInput = document.getElementById("xtt-pa-owner-noncename");
  nonceInput.value = nonce;

  // check option manually
  for (let options of widgetInput.options) {
    if (options.value == widgetSet)
      options.setAttribute("selected", "selected");
    else options.removeAttribute("selected");
  }
}

(function(element, components, data, i18n, plugins, blocks, lodash) {
  const { __ } = i18n;
  const { select, useSelect, dispatch, subscribe } = data;
  const { SelectControl } = components;
  const { get, without } = lodash;
  const { registerPlugin } = plugins;
  const { unregisterBlockType } = blocks;
  const { createElement } = element;

  /**
   * Dropdown term selector
   *
   * @param {Object} props      Component props
   * @param {string} props.slug Taxonomy slug
   * @return {WPElement}        Dropdown term selector component
   */
  window.DropdownTermSelector = function DropdownTermSelector({ slug, selected = false }) {  
    /**
     * Module Constants
     */
    const DEFAULT_QUERY = {
      per_page: -1,
      orderby: "name",
      order: "asc",
      _fields: "id,name,parent,slug",
      context: "view",
    };
    const EMPTY_ARRAY = [];

    const { terms, availableTerms, taxonomy, selectedTerm } = useSelect(() => {
      const _taxonomy = data.select("core").getTaxonomy(slug);

      return {
        terms: _taxonomy
          ? data
              .select("core/editor")
              .getEditedPostAttribute(_taxonomy.rest_base)
          : EMPTY_ARRAY,
        availableTerms:
          data
            .select("core")
            .getEntityRecords("taxonomy", slug, DEFAULT_QUERY) || EMPTY_ARRAY,
        taxonomy: _taxonomy,
        selectedTerm: selected ? 
          data
            .select("core")
            .getEntityRecords("taxonomy", slug, DEFAULT_QUERY) : false,
      };
    }, [slug]);
    
    const { editPost } = dispatch("core/editor");
    // console.log(availableTerms.findIndex(term => term.slug === selected));
    // console.log(availableTerms.find((a) => a.slug === selected));
    /**
     * Update terms for post.
     *
     * @param {number[]} termIds Term ids.
     */
    const onUpdateTerms = termIds => {
      termIds = [termIds[termIds.length - 1]];
      editPost({ [taxonomy.rest_base]: termIds });
    };

    /**
     * Handler for checking term.
     *
     * @param {number} termId
     */
    const onChange = termId => {
      const hasTerm = terms.includes(termId);
      const newTerms = hasTerm ? without(terms, termId) : [...terms, termId];
      onUpdateTerms(newTerms);
    };

    const groupLabel = get(taxonomy, ["name"], __("Terms"));

    /**
     * Update terms based on first checking.
     * Add selected terms as default if terms is empty.
     *
     * @param {number} termId
     */
    if(availableTerms.length && !terms.length){
      let selectedId;
      if(selected) {
        selectedId = availableTerms.reduce(function (id, item) {
          if (item.slug === selected) {
            id = item.id;
          }
          return id;
        });
      } else {
        selectedId = availableTerms[0].id;
      }
      onUpdateTerms([selectedId]);
    }

    return createElement(
      "div",
      {
        className: "editor-post-taxonomies__hierarchical-terms-list",
        tabIndex: 0,
        role: "group",
        "aria-label": groupLabel,
      },
      createElement(SelectControl, {
        value: terms[0],
        onChange: onChange,
        options: availableTerms.map(term => {
          return {
            value: term.id,
            label: term.name,
          };
        }),
      })
    );
  };

  /**
   * Apply dropdown filter
   */
  const postTaxonomyType = (OriginalComponent) => {
    return function(props) {
      if (props.slug === "xtt-pa-owner")
        return createElement(DropdownTermSelector, { ...props });
  
      return createElement(OriginalComponent, { ...props });
    };
  };

  /**
   * Consults values to determine whether the editor is busy saving a post
   * Includes checks on whether the save button is busy
   * 
   * @returns {boolean} Whether the editor is on a busy save state
   */
  const isSavingPost = () => {
    // State data necessary to establish if a save is occuring.
    const isSaving = select('core/editor').isSavingPost() || select('core/editor').isAutosavingPost();
    const isSaveable = select('core/editor').isEditedPostSaveable();
    const isPostSavingLocked = select('core/editor').isPostSavingLocked();
    const hasNonPostEntityChanges = select('core/editor').hasNonPostEntityChanges();
    const isAutoSaving = select('core/editor').isAutosavingPost();
    const isButtonDisabled = isSaving || !isSaveable || isPostSavingLocked;

    // Reduces state into checking whether the post is saving and that the save button is disabled.
    const isBusy = !isAutoSaving && isSaving;
    const isNotInteractable = isButtonDisabled && ! hasNonPostEntityChanges;
    
    return isBusy && isNotInteractable;
  };

  /**
   * Consults edited taxonomy terms
   * 
   * @param {string} taxonomy Taxonomy slug to check
   * @returns {array} Edited terms list
   */
  const getTerms = (taxonomy) => {
    return select('core/editor').getEditedPostAttribute(taxonomy);
  };

  /**
   * Filter required taxonomies by current post type
   * 
   * @returns {array} Required taxonomies list
   */
  const getRequiredTaxonomies = () => {  
    let requiredTaxonomies = window.iasd.requiredTaxonomies.filter((value) => {
      return value.post_type == select('core/editor').getCurrentPostType();
    });
    
    return requiredTaxonomies.length ? requiredTaxonomies[0].taxonomies : [];
  };

  /**
   * Check required taxonomies and show notices
   */
  const checkRequiredTaxonomies = () => {
    if(!window.iasd || !window.iasd.requiredTaxonomies)
      return null;
  
    const requiredTaxonomies = getRequiredTaxonomies();
  
    if(!requiredTaxonomies.length)
      return null;
      
    requiredTaxonomies.forEach(element => {
      let terms = [];
  
      subscribe(() => {
        const taxonomy = select('core').getTaxonomy(element);
        
        if(!taxonomy)
          return;
  
        const newTerms = getTerms(element);
        const termsChanged = newTerms !== terms;
  
        terms = newTerms;
  
        if(termsChanged) {
          if(terms.length === 0) {
            // show notice
            dispatch('core/notices').createNotice(
              'error',
              __('Please select at least one ', 'iasd') + taxonomy.name,
              {
                id: `notice_${element}`,
                isDismissible: false,
              }
            );
          } 
          else
            // remove notice
            dispatch('core/notices').removeNotice(`notice_${element}`);
        }
      });
    });
  
    return null;
  };

  /**
   * Verifies that all mandatory taxonomies have been filled, 
   * otherwise reverts the post to draft
   */
  const checkPostSave = () => {
    if(!window.iasd || !window.iasd.requiredTaxonomies)
      return null;

    const requiredTaxonomies = getRequiredTaxonomies();
    
    if(!requiredTaxonomies.length)
      return null;
  
    const { editPost, savePost } = dispatch('core/editor');
  
    // Current saving state. isSavingPost is defined above.
    let wasSaving = isSavingPost();
  
    subscribe(() => {
      // New saving state
      let isSaving = isSavingPost();
  
      // It is done saving if it was saving and it no longer is.
      let isDoneSaving = wasSaving && !isSaving;
  
      // Update value for next use.
      wasSaving = isSaving;
  
      // Get post status
      let status = select('core/editor').getEditedPostAttribute('status');
  
      // Continue if saved post is complete and not draft 
      if(!isDoneSaving || status == 'draft')
        return null;

      requiredTaxonomies.every(element => {
        let terms = getTerms(element);
        
        if((!terms) || (terms.length > 0)){
          return true;
        }

        editPost({ status: 'draft' });
        savePost();
  
        return false;
      })
    });

    return null;
  };

  /**
   * Unregister unused blocks
   */
  const unregisterBlocks = () => {
    if(!window.iasd || !window.iasd.unregisterBlocks)
      return null;

    window.iasd.unregisterBlocks.forEach((block) => {
      if(select('core/blocks').getBlockType(block))
        unregisterBlockType(block);
    });

    return null;
  };

  /**
   * Apply dropdown filter
   */
  wp.hooks.addFilter(
    'editor.PostTaxonomyType',
    'adventistas',
    postTaxonomyType
  );

  /**
   * Register plugins
   */
  registerPlugin('check-required-taxonomies', {
    render: checkRequiredTaxonomies,
    icon: '',
  });  

  registerPlugin('check-post-save', {
    render: checkPostSave,
    icon: '',
  });  

  registerPlugin('unregister-blocks', {
    render: unregisterBlocks,
    icon: '',
  });
})(
  window.wp.element,
  window.wp.components,
  window.wp.data,
  window.wp.i18n,
  window.wp.plugins,
  window.wp.blocks,
  window.lodash,
);
