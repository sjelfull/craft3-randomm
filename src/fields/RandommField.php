<?php
/**
 * Randomm plugin for Craft CMS 3.x
 *
 * Fieldtype that allows you to create random things via chance.js
 *
 * @link      https://superbig.co
 * @copyright Copyright (c) 2017 Superbig
 */

namespace superbig\randomm\fields;

use superbig\randomm\Randomm;
use superbig\randomm\assetbundles\field\FieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    Superbig
 * @package   Randomm
 * @since     2.0.0
 */
class RandommField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $placeholder         = 'Generate random things';
    public $type                = '';
    public $typeArguments       = [];
    public $autoGenerateIfEmpty = false;

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName (): string
    {
        return Craft::t('randomm', 'Randomm');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            [ 'placeholder', 'string' ],
            [ 'placeholder', 'default', 'value' => 'Generate random things' ],

            [ 'type', 'string' ],
            //[ 'typeArguments', 'array' ],
            [ 'autoGenerateIfEmpty', 'boolean' ],
        ]);

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType (): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue ($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue ($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml ()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'randomm/_components/fields/_settings',
            [
                'field' => $this,
                'types' => $this->_getTypes(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml ($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(FieldAsset::class);

        // Get our id and namespace
        $id           = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id'        => $id,
            'name'      => $this->handle,
            'namespace' => $namespacedId,
            'prefix'    => Craft::$app->getView()->namespaceInputId(''),
        ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("Randomm.init('{$namespacedId}');");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'randomm/_components/fields/_input',
            [
                'name'         => $this->handle,
                'value'        => $value,
                'field'        => $this,
                'id'           => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }

    /**
     * Return types supported by chance.js
     *
     * @return array
     */
    private function _getTypes ()
    {
        $types = [
            'basics'     => [ 'optgroup' => 'Basics' ],
            'floating'   => 'Floating',
            'integer'    => 'Integer',
            'natural'    => 'Natural',
            'string'     => 'String',
            'text'       => [ 'optgroup' => 'Text' ],
            'paragraph'  => 'Paragraph',
            'sentence'   => 'Sentence',
            'syllable'   => 'Syllable',
            'word'       => 'Word',
            'person'     => [ 'optgroup' => 'Person' ],
            'name'       => 'Name',
            'ssn'        => 'SSN',
            'web'        => [ 'optgroup' => 'Web' ],
            'color'      => 'Color',
            'email'      => 'E-mail',
            'fbid'       => 'Facebook id',
            'hashtag'    => 'Hashtag',
            'ip'         => 'IP',
            'ipv6'       => 'IPv6',
            'twitter'    => 'Twitter handle',
            'location'   => [ 'optgroup' => 'Location' ],
            'address'    => 'Address',
            'altitude'   => 'Altitude',
            'areacode'   => 'Areacode',
            'city'       => 'City',
            'geohash'    => 'Geohash',
            'latitude'   => 'Latitude',
            'longitude'  => 'Longitude',
            'phone'      => 'Phone',
            'postal'     => 'Postal',
            'state'      => 'State',
            'street'     => 'Street',
            'zip'        => 'Zip',
            'time'       => [ 'optgroup' => 'Time' ],
            'date'       => 'Date',
            'hammertime' => 'Hammertime',
            'month'      => 'Month',
            'timestamp'  => 'Timestamp',
            'year'       => 'Year',
            'misc'       => [ 'optgroup' => 'Misc' ],
            'guid'       => 'GUID',
            'hash'       => 'Hash',
            'normal'     => 'Normal',
            'weighted'   => 'Weighted',
        ];

        return $types;
    }
}
