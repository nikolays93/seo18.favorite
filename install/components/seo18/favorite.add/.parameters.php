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
			"REFRESH" => "N",
			"MULTIPLE" => "N",
			"ADDITIONAL_VALUES" => "N",
		),
	),
);
