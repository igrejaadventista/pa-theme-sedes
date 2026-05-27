(function ($) {
  const flagIconsBaseUrl = 'https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.5.0/';
  const fallbackCountries = [
    { code: 'br', name: 'Brazil' },
    { code: 'es', name: 'Spain' },
  ];
  let countries = fallbackCountries;
  let countriesRequest = null;

  function flagIconUrl(code) {
    return flagIconsBaseUrl + 'flags/4x3/' + code + '.svg';
  }

  function renderFlagOption(option) {
    if (!option.id) {
      return option.text;
    }

    return $(
      '<span class="pa-language-flag-option" style="display:flex;align-items:center;gap:8px;line-height:20px;">' +
        '<img src="' + flagIconUrl(option.id) + '" alt="" aria-hidden="true" style="display:inline-block;height:auto;max-height:18px;max-width:25px;object-fit:contain;width:auto;">' +
        '<span>' + option.text + '</span>' +
      '</span>'
    );
  }

  function formatCountryLabel(country) {
    return country.name + ' - ' + country.code.toUpperCase();
  }

  function getLanguageFlagSelects($el) {
    return $el.find('.acf-field[data-name="ct_languages"] .acf-field[data-name="icon"] select');
  }

  function populateLanguageFlagSelects($el) {
    getLanguageFlagSelects($el).each(function () {
      const $select = $(this);
      const currentValue = $select.val() || 'br';

      if (countries.length > fallbackCountries.length) {
        $select.empty();

        countries.forEach(function (country) {
          $select.append(new Option(formatCountryLabel(country), country.code, false, country.code === currentValue));
        });

        if (!countries.some(function (country) { return country.code === currentValue; })) {
          $select.append(new Option(currentValue.toUpperCase(), currentValue, true, true));
        }
      }

      $select.val(currentValue);
      refreshLanguageFlagSelect($select);
    });
  }

  function refreshLanguageFlagSelect($select) {
    if (typeof $select.select2 !== 'function') {
      return;
    }

    if ($select.data('select2')) {
      $select.select2('destroy');
    }

    $select.select2({
      templateResult: renderFlagOption,
      templateSelection: renderFlagOption,
      escapeMarkup: function (markup) {
        return markup;
      },
      width: '100%',
    });
  }

  function loadCountries() {
    if (countriesRequest) {
      return countriesRequest;
    }

    countriesRequest = $.getJSON(flagIconsBaseUrl + 'country.json').then(
      function (data) {
        countries = data
          .filter(function (country) {
            return country.iso && country.code && country.name;
          })
          .map(function (country) {
            return {
              code: country.code,
              name: country.name,
            };
          });
      },
      function () {
        countries = fallbackCountries;
      }
    );

    return countriesRequest;
  }

  if (typeof window.acf === 'undefined') {
    return;
  }

  window.acf.add_filter('select2_args', function (args, $select, settings, field) {
    if (field.data('name') !== 'icon' || !field.closest('.acf-field[data-name="ct_languages"]').length) {
      return args;
    }

    args.templateResult = renderFlagOption;
    args.templateSelection = renderFlagOption;
    args.escapeMarkup = function (markup) {
      return markup;
    };

    return args;
  });

  window.acf.addAction('ready append', function () {
    loadCountries().always(function () {
      populateLanguageFlagSelects($(document));
    });
  });
})(jQuery);
