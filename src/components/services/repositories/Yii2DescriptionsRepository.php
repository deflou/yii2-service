<?php
namespace deflou\components\services\repositories;

use app\models\mongo\Yii2ServicesDescriptions;
use deflou\components\services\Yii2ServiceDescription;
use deflou\interfaces\services\IServiceDescription;
use deflou\interfaces\services\repositories\IServiceDescriptionsRepository;

/**
 * Class Yii2DescriptionsRepository
 *
 * @package deflou\components\services\repositories
 * @author deflou.dev@gmail.com
 */
class Yii2DescriptionsRepository extends Yii2RepositoryAbstract implements IServiceDescriptionsRepository
{
    /**
     * @return array|Yii2ServiceDescription|null
     */
    public function one()
    {
        $model = Yii2ServicesDescriptions::find()->where($this->where)->one();

        return $model ? new Yii2ServiceDescription($model) : $model;
    }

    /**
     * @return IServiceDescription[]
     */
    public function all()
    {
        $models = Yii2ServicesDescriptions::find()->where($this->where)->all();

        $items = [];

        foreach ($models as $model) {
            $items[] = new Yii2ServiceDescription($model);
        }

        return $items;
    }

    /**
     * @param IServiceDescription|Yii2ServiceDescription $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function create($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceDescription) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceDescription::class . '"');
            }

            /**
             * @var Yii2ServicesDescriptions $model
             */
            return $model->save();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }

    /**
     * @param IServiceDescription $serviceInstance
     *
     * @return bool
     */
    public function update($serviceInstance)
    {
        return $this->create($serviceInstance);
    }

    /**
     * @param IServiceDescription $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceDescription) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceDescription::class . '"');
            }

            /**
             * @var Yii2ServicesDescriptions $model
             */
            return $model->delete();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }
}
