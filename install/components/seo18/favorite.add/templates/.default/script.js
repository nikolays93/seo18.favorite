jQuery(document).ready(function($) {
    var componentName = 'seo18:favorite.add';
    var ajaxUrl       = '/bitrix/services/main/ajax.php?' + $.param({
        c: componentName,
        action: 'toggleDelayItem',
        mode: 'ajax'
    }, true);

    $('body').on('click', '[data-favorite]', function(event) {
        event.preventDefault();

        var $button = $(this);
        var productId = $button.data('favorite');

        function error(result) {
            console.error(result);
        }

        function success(result) {
            if ('add' == result.data.action) {
                $button.addClass('added');
                BX.onCustomEvent('OnFavoriteAdded', [$button]);
            } else {
                $button.removeClass('added');
                BX.onCustomEvent('OnFavoriteDeleted', [$button]);
            }
        }

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                siteId: 's1',
                productId: productId,
            },
        }).done(function(result) {
            'success' == result.status ? success(result) : error(result);
        }).fail(error);
    });

    // BX.addCustomEvent('OnFavoriteAdded', BX.delegate(function($button) {}));
    // BX.addCustomEvent('OnFavoriteDeleted', BX.delegate(function($button) {}));
});