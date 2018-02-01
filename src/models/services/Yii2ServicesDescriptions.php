<?php

namespace app\models\mongo;

use deflou\interfaces\services\IServiceDescription;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "<df prefix>_services_descriptions".
 * @property $_id
 * @property $service_name
 * @property $service_describer
 * @property $service_version
 * @property $service_config
 */
class Yii2ServicesDescriptions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        $prefix = getenv('DF_DB_PREFIX') ?: 'df';

        return  $prefix . '_services_descriptions';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            IServiceDescription::FIELD__SERVICE_NAME,
            IServiceDescription::FIELD__VERSION,
            IServiceDescription::FIELD__DESCRIBER,
            IServiceDescription::FIELD__CONFIG
        ];
    }
}
