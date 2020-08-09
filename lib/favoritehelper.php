<?php

namespace Seo18\Favorite;

use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;

class FavoriteHelper {
    /**
     * @param  string $siteId
     * @param  int $fUserId
     * @param  Basket $basket
     * @return array <BasketItem>[]
     */
    public static function getDelayedItems($siteId)
    {
        $fUserId = Fuser::getId();
        $basket = Basket::loadItemsForFUser($fUserId, $siteId);

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
}
