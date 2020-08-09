<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var customOrderComponent $component */

use Bitrix\Main\Localization\Loc;

?>
<a class="btn btn-outline-primary"
   data-favorite="<?= $arParams['PRODUCT_ID'] ?>"
   href="?action=add2Favorite&productId=<?= $arParams['PRODUCT_ID'] ?>"><?= Loc::getMessage('FAVORITE_ADD_BUTTON_LABEL') ?></a>
