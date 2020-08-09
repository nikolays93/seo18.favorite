<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
    "NAME"        => Loc::getMessage('FAVORITE_ADD_COMPONENT_NAME'),
    "DESCRIPTION" => Loc::getMessage('FAVORITE_ADD_COMPONENT_DESC'),
    "ICON"        => "/images/icon.gif",
    "SORT"        => 10,
    "CACHE_PATH"  => "Y",
    "PATH"        => array(
        "ID" => Loc::getMessage('FAVORITE_ADD_COMPONENT_GROUP'),
    ),
    "COMPLEX" => "N",
);
