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
        var ajaxData = {
            url: ajaxUrl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                siteId: 's1',
                productId: productId,
            },
        };

        function error(result) {
            console.error(result);
        }

        function success(result) {
            if ('add' == result.data.action) {
                BX.onCustomEvent('OnFavoriteAdded', [$button]);
            } else {
                BX.onCustomEvent('OnFavoriteDeleted', [$button]);
            }
        }

        $.ajax(ajaxData).done(function(result) {
            'success' == result.status ? success(result) : error(result);
        }).fail(error);
    });

    BX.addCustomEvent('OnFavoriteAdded', BX.delegate(function($button) {
        $button
            .removeClass('btn-outline-primary')
            .addClass('btn-primary');
    }));

    BX.addCustomEvent('OnFavoriteDeleted', BX.delegate(function($button) {
        $button
            .removeClass('btn-primary')
            .addClass('btn-outline-primary');
    }));
});
