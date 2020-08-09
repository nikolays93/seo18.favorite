<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

IncludeModuleLangFile(__FILE__);

if (class_exists('seo18_favorite')) {
    return;
}

class seo18_favorite extends CModule
{
    /** @var array */
    public $components;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';
        $this->MODULE_ID = 'seo18.favorite';
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('FAVORITE_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('FAVORITE_MODULE_DESC');
        $this->PARTNER_NAME = 'Николай Сухих';
        $this->PARTNER_URI = '//seo18.ru';

        $this->components = array(
            'favorite',
            'favorite.add',
        );
    }

    /**
     * Get application folder.
     * @return string /document/local (when exists) or /document/bitrix
     */
    public static function getRoot()
    {
        $local = $_SERVER['DOCUMENT_ROOT'] . '/local';
        if (1 === preg_match('#local[\\\/]modules#', __DIR__) && is_dir($local)) {
            return $local;
        }

        return $_SERVER['DOCUMENT_ROOT'] . BX_ROOT;
    }

    private static function deleteComponent($componentName)
    {
        DeleteDirFilesEx($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/components/seo18/' . $componentName);
        DeleteDirFilesEx($_SERVER['DOCUMENT_ROOT'] . '/local/components/seo18/' . $componentName);
    }

    public function DoInstall()
    {
        global $DB;

        if (!CheckVersion(ModuleManager::getVersion("main"), "14.00.00")) {
            $APPLICATION->ThrowException(
                Loc::getMessage("FAVORITE_MODULE_ERROR_MAIN_VERSION")
            );
        }

        /**
         * Install Database
         */
        // $DB->RunSQLBatch(__DIR__ . '/install/db/install.sql');

        /**
         * Install Events
         */

        /**
         * Install Files
         */
        CopyDirFiles(__DIR__ . '/components', static::getRoot() . '/components', true, true);

        ModuleManager::RegisterModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        /**
         * Uninstall Database
         */
        // $DB->RunSQLBatch(__DIR__ . '/install/db/uninstall.sql');

        /**
         * Uninstall Events
         */

        /**
         * Uninstall Files
         */
        array_walk($this->components, array(__CLASS__, 'deleteComponent'));

        UnRegisterModule($this->MODULE_ID);
    }
}