<?php

namespace app\models\mongo;

use deflou\interfaces\services\IServiceRegistry;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "<df prefix>_services_registries".
 * @property $_id
 * @property $name
 * @property $title
 * @property $description
 * @property $base_url
 * @property $created
 */
class Yii2ServicesRegistries extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        $prefix = getenv('DF_DB_PREFIX') ?: 'df';

        return  $prefix . '_services_registries';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            IServiceRegistry::NAME,
            IServiceRegistry::TITLE,
            IServiceRegistry::DESCRIPTION,
            IServiceRegistry::FIELD__BASE_URL,
            IServiceRegistry::FIELD__CREATED
        ];
    }
}
