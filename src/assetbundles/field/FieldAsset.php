<?php
/**
 * Randomm plugin for Craft CMS 3.x
 *
 * Fieldtype that allows you to create random things via chance.js
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\randomm\assetbundles\field;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Superbig
 * @package   Randomm
 * @since     2.0.0
 */
class FieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init ()
    {
        $this->sourcePath = "@superbig/randomm/assetbundles/field/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/chance-1.0.12.min.js',
            'js/Randomm-Field.js',
        ];

        $this->css = [
            'css/Randomm-Field.css',
        ];

        parent::init();
    }
}
