<?php

use Bitrix\Main\Loader;
use Seo18\Favorite\FavoriteHelper;

$delayedBasketItems = FavoriteHelper::getDelayedItems(SITE_ID);
$delayedBasketItemsId = array_map(array('Seo18\Favorite\FavoriteHelper', 'getProductIdFromBasketItem'),
    $delayedBasketItems);

if (in_array($arParams['PRODUCT_ID'], $delayedBasketItemsId)): ?>
<script>$('[data-favorite="<?= $arParams['PRODUCT_ID'] ?>"]').addClass('added');</script>
<?php endif ?>