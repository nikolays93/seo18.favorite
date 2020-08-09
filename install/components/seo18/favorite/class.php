<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;

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
    }

    /**
     * @param  string $siteId
     * @param  int $fUserId
     * @param  Basket $basket
     * @return array <BasketItem>[]
     */
    public static function getDelayedItems($siteId, $fUserId, $basket)
    {
        $delayedBasketItems = array();
        foreach ($basket as $basketItem) {
            if ('Y' === $basketItem->getField('DELAY')) {
                array_push($delayedBasketItems, $basketItem);
            }
        }

        return $delayedBasketItems;
    }

    /**
     * @param  BasketItem $basketItem
     * @return int
     */
    public static function getProductIdFromBasketItem($basketItem)
    {
        return (int) $basketItem->getProductId();
    }

    public function executeComponent()
    {
        $siteId = \Bitrix\Main\Context::getCurrent()->getSite();
        $fUserId = Fuser::getId();
        $basket = Basket::loadItemsForFUser($fUserId, $siteId);
        $delayedBasketItems = static::getDelayedItems($siteId, $fUserId, $basket);

        $this->arParams['DELAYED_BASKET_ITEMS'] = array_map(array(__CLASS__, 'getProductIdFromBasketItem'),
            $delayedBasketItems);

        $this->includeComponentTemplate();
    }
}
