<?php
namespace deflou\components\services\repositories;

use app\models\mongo\Yii2ServicesRegistries;
use deflou\components\services\Yii2ServiceRegistry;
use deflou\interfaces\services\IServiceRegistry;
use deflou\interfaces\services\repositories\IServiceRegistriesRepository;

/**
 * Class Yii2RegistriesRepository
 *
 * @package deflou\components\services\repositories
 * @author deflou.dev@gmail.com
 */
class Yii2RegistriesRepository extends Yii2RepositoryAbstract implements IServiceRegistriesRepository
{
    /**
     * @return array|IServiceRegistry|null
     */
    public function one()
    {
        $model = Yii2ServicesRegistries::find()->where($this->where)->one();

        return $model ? new Yii2ServiceRegistry($model) : $model;
    }

    /**
     * @return IServiceRegistry[]
     */
    public function all()
    {
        $models = Yii2ServicesRegistries::find()->where($this->where)->all();

        $instances = [];

        foreach ($models as $model) {
            $instances[] = new Yii2ServiceRegistry($model);
        }

        return $instances;
    }

    /**
     * @param IServiceRegistry|Yii2ServiceRegistry $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function create($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceRegistry) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceRegistry::class . '"');
            }

            /**
             * @var Yii2ServicesRegistries $model
             */
            return $model->save();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }

    /**
     * @param IServiceRegistry $serviceInstance
     *
     * @return bool
     */
    public function update($serviceInstance)
    {
        return $this->create($serviceInstance);
    }

    /**
     * @param IServiceRegistry $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceRegistry) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceRegistry::class . '"');
            }

            /**
             * @var Yii2ServicesRegistries $model
             */
            return $model->delete();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }
}
