<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\BasketItem;
use Bitrix\Sale\Fuser;

class FavoriteAddAjaxController extends Controller
{
    /** @var BasketBase */
    private $basket;
    /** @var array */
    private $result;

	/**
	 * @param Request|null $request
	 * @throws LoaderException
	 */
	public function __construct($request = null)
	{
		parent::__construct($request);

		Loader::includeModule('sale');
		Loader::includeModule('catalog');
        $this->result = array();
	}

	/**
	 * @return array
	 */
	public function configureActions()
	{
		return array(
			'addDelayItem' => array(
				'prefilters' => array()
			),
            'deleteDelayItem' => array(
                'prefilters' => array()
            ),
            'toggleDelayItem' => array(
                'prefilters' => array()
            ),
		);
	}

    /**
     * Load current basket for use later
     * @param  string $siteId Current site ID
     * @return void
     */
    public function loadBasket($siteId)
    {
        $FuserId = Fuser::getId();
        $this->basket = Basket::loadItemsForFUser($FuserId, $siteId);
    }

    /**
     * @todo Check when products already in cart and delay
     *
     * @param  int                $productId
     * @return BasketItem|bool
     */
    public function delayBasketItemExist($productId)
    {
        $basketItem = $this->basket->getExistsItem('catalog', $productId);

        if ($basketItem && 'Y' === $basketItem->getField('DELAY')) {
            return $basketItem;
        }

        return false;
    }

    /**
     * @param  int $productId
     * @param  int $quantity
     * @return BasketItem|bool
     */
    public function addDelayToBasket($productId, $quantity = 1)
    {
        if ($basketItem = $this->delayBasketItemExist($productId)) {
            $basketItem->setField('QUANTITY', $basketItem->getQuantity() + $quantity);
        } else {
            $basketItem = $this->basket->createItem('catalog', $productId);
            $basketItem->setFields(array(
                'LID' => $this->basket->getSiteId(),
                'QUANTITY' => $quantity,
                'CURRENCY' => CurrencyManager::getBaseCurrency(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
                'DELAY' => 'Y',
            ));
        }

        if ($basketItem = $this->delayBasketItemExist($productId)) {
            $this->result = static::getBasketItemInfo($productId, $basketItem);
        } else {
            // @todo Has not been included
        }

        return $basketItem;
    }

    /**
     * Get touched basket item info
     * @param  int        $productId
     * @param  BasketItem $basketItem
     * @return [type]
     */
    public static function getBasketItemInfo($productId, $basketItem)
    {
        return array(
            'id' => $productId,
            'name' => $basketItem->getField('NAME'),
            'quantity' => $basketItem->getQuantity(),
        );
    }

    /**
     * @param   string $siteId
     * @param   int    $productId
     * @param   int    $quantity
     * @return  array
     */
    public function addDelayItemAction($siteId, $productId, $quantity = 1): array
    {
        $this->loadBasket($siteId);
        $this->addDelayToBasket($productId, $quantity);
        $this->basket->save();

        return $this->result;
    }

    /**
     * @param   string $siteId
     * @param   int    $productId
     * @return  array
     */
    public function deleteDelayItemAction($siteId, $productId)
    {
        $this->loadBasket($siteId);

        if ($basketItem = $this->delayBasketItemExist($productId)) {
            $basketItem->delete();
            $this->result['id'] = $productId;
        } else {
            $this->result['id'] = 0;
        }

        $this->basket->save();

        return $this->result;
    }

    /**
     * @param   string $siteId
     * @param   int    $productId
     * @param   int    $quantity
     * @return  array
     */
    public function toggleDelayItemAction($siteId, $productId, $quantity = 1): array
    {
        $this->loadBasket($siteId);

        if ($basketItem = $this->delayBasketItemExist($productId)) {
            $basketItem->delete();

            $this->result = array(
                'id' => $productId,
                'action' => 'delete',
            );
        } else {
            $this->addDelayToBasket($productId, $quantity);
            $this->result['action'] = 'add';
        }

        $this->basket->save();

        return $this->result;
    }
}
