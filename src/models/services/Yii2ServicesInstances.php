<?php
namespace deflou\models\services;

use deflou\interfaces\services\IServiceInstance;
use yii\mongodb\ActiveRecord;

/**
 * This is the model class for collection "{df_prefix}_services_instances".
 * @property $_id
 * @property $service_name ex.: jira
 * @property $name         ex.: jira_826252
 * @property $title
 * @property $description
 * @property $version ex. 1.0.0
 * @property $users {<user name>: <user role: owner|user>}
 * @property $options {<option name>: <option value>}
 * @property $created timestamp
 */
class Yii2ServicesInstances extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function collectionName()
    {
        $prefix = getenv('DF_DB_PREFIX') ?: 'df';

        return  $prefix . '_services_instances';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            '_id',
            IServiceInstance::FIELD__SERVICE_NAME,
            IServiceInstance::NAME,
            IServiceInstance::TITLE,
            IServiceInstance::DESCRIPTION,
            IServiceInstance::FIELD__VERSION,
            IServiceInstance::FIELD__USERS,
            IServiceInstance::FIELD__OPTIONS,
            IServiceInstance::FIELD__CREATED
        ];
    }
}
