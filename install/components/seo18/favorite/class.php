<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Seo18\Favorite\FavoriteHelper;

class FavoriteComponent extends CBitrixComponent
{
    /**
     * @param CBitrixComponent|null $component
     * @throws Bitrix\Main\LoaderException
     */
    public function __construct($component = null)
    {
        parent::__construct($component);

        Loader::includeModule('sale');
        Loader::includeModule('catalog');
        Loader::includeModule('seo18.favorite');
    }

    public function executeComponent()
    {
        $siteId = \Bitrix\Main\Context::getCurrent()->getSite();

        $delayedBasketItems = FavoriteHelper::getDelayedItems($siteId);

        $this->arParams['DELAYED_BASKET_ITEMS'] = array_map(array('Seo18\Favorite\FavoriteHelper', 'getProductIdFromBasketItem'),
            $delayedBasketItems);

        $this->includeComponentTemplate();
    }
}
