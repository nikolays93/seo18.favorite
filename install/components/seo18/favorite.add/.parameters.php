<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global $arCurrentValues
 */
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	'PARAMETERS' => array(
		"PRODUCT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => Loc::getMessage('FAVORITE_ADD_PRODUCT_ID_PARAMETER'),
			"TYPE" => 'STRING',
			"DEFAULT" => "",
		),
		"BUTTON_CLASS" => array(
			"PARENT" => "VISUAL",
			"NAME" => Loc::getMessage('FAVORITE_ADD_BUTTON_CLASS_PARAMETER'),
			"TYPE" => 'STRING',
			"DEFAULT" => "btn btn-outline-primary",
		),
		"BUTTON_TEXT" => array(
			"PARENT" => "VISUAL",
			"NAME" => Loc::getMessage('FAVORITE_ADD_BUTTON_TEXT_PARAMETER'),
			"TYPE" => 'STRING',
			"DEFAULT" => "Добавить в избранное",
		),
	),
);
