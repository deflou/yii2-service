<?php
namespace deflou\components\services\repositories;

use deflou\components\services\Yii2ServiceInstance;
use deflou\interfaces\services\IServiceDescription;
use deflou\interfaces\triggers\events\ITriggerEvent;
use deflou\interfaces\services\IServiceInstance;
use deflou\interfaces\services\repositories\IServiceInstancesRepository;
use deflou\interfaces\triggers\ITrigger;
use deflou\models\services\Yii2ServicesInstances;

/**
 * Class Yii2InstancesRepository
 *
 * @package deflou\components\services\repositories
 * @author deflou.dev@gmail.com
 */
class Yii2InstancesRepository implements IServiceInstancesRepository
{
    /**
     * @var array
     */
    protected $where = [];

    /**
     * @return static
     */
    public static function getInstance()
    {
        return new static();
    }

    /**
     * @param mixed $where
     *
     * @return $this
     */
    public function find($where)
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @return array|IServiceInstance|null
     */
    public function one()
    {
        $model = Yii2ServicesInstances::find()->where($this->where)->one();

        return $model ? new Yii2ServiceInstance($model) : $model;
    }

    /**
     * @return IServiceInstance[]
     */
    public function all()
    {
        $models = Yii2ServicesInstances::find()->where($this->where)->all();

        $instances = [];

        foreach ($models as $model) {
            $instances[] = new Yii2ServiceInstance($model);
        }

        return $instances;
    }

    /**
     * @param IServiceInstance|Yii2ServiceInstance $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function create($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceInstance) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceInstance::class . '"');
            }

            /**
             * @var Yii2ServicesInstances $model
             */
            return $model->save();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }

    /**
     * @param IServiceInstance $serviceInstance
     *
     * @return bool
     */
    public function update($serviceInstance)
    {
        return $this->create($serviceInstance);
    }

    /**
     * @param IServiceInstance $serviceInstance
     *
     * @return bool
     * @throws \Exception
     */
    public function delete($serviceInstance): bool
    {
        if ($serviceInstance instanceof Yii2ServiceInstance) {
            $model = $serviceInstance->getModel();

            if (!$model) {
                throw new \Exception('Missed model of "' . Yii2ServiceInstance::class . '"');
            }

            /**
             * @var Yii2ServicesInstances $model
             */
            return $model->delete();
        }

        throw new \Exception('Can not operate with "' . get_class($serviceInstance) . '" instance.');
    }

    /**
     * @param ITriggerEvent $triggerEvent
     *
     * @return IServiceInstance|null
     * @throws \Exception
     */
    public function identifyServiceByTriggerEvent(ITriggerEvent $triggerEvent): IServiceInstance
    {
        $instance = $this->find([IServiceInstance::NAME => $triggerEvent->getServiceName()])->one();

        if ($instance) {
            $description = Yii2DescriptionsRepository::getInstance()->find([
                IServiceDescription::FIELD__SERVICE_NAME => $instance->getServiceName()
            ])->one();

            if ($description) {
                $describer = $description->getDescriber();
                $describer->setServiceConfig($description->getConfig());
                $instance->setDescriber($describer);
            } else {
                throw new \Exception('Missed "' . $instance->getServiceName() . '" description');
            }
        }

        return $instance;
    }

    /**
     * @param ITrigger $trigger
     *
     * @return IServiceInstance|null
     */
    public function identifyDestinationServiceByTrigger(ITrigger $trigger)
    {
        return $this->find([IServiceInstance::NAME => $trigger->getDestinationService()])->one();
    }
}
