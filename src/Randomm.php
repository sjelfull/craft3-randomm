<?php
/**
 * Randomm plugin for Craft CMS 3.x
 *
 * Fieldtype that allows you to create random things via chance.js
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\randomm;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use superbig\randomm\fields\RandommField;
use yii\base\Event;

/**
 * Class Randomm
 *
 * @author    Superbig
 * @package   Randomm
 * @since     2.0.0
 *
 */
class Randomm extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Randomm
     */
    public static $plugin;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init ()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = RandommField::class;
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ( $event->plugin === $this ) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'randomm',
                '{name} plugin loaded',
                [ 'name' => $this->name ]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
