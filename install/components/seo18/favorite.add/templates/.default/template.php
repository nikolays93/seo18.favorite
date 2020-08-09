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
<a class="<?= $arParams['BUTTON_CLASS'] ?>"
   data-favorite="<?= $arParams['PRODUCT_ID'] ?>"
   href="?action=add2Favorite&productId=<?= $arParams['PRODUCT_ID'] ?>"><?= $arParams['BUTTON_TEXT'] ?></a>