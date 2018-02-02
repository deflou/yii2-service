<?php
namespace deflou\components\services;

use deflou\components\services\repositories\Yii2DescriptionsRepository;
use deflou\interfaces\services\activities\IServiceAction;
use deflou\interfaces\services\activities\IServiceEvent;
use deflou\interfaces\services\IServiceDescription;
use deflou\interfaces\services\IServiceResolver;
use deflou\interfaces\triggers\events\ITriggerEvent;
use deflou\interfaces\triggers\ITrigger;
use deflou\models\services\Yii2ServicesInstances;

/**
 * Class Yii2ServiceInstance
 *
 * @package deflou\components\services
 * @author deflou.dev@gmail.com
 */
class Yii2ServiceInstance extends ServiceInstanceAbstract
{
    /**
     * @var Yii2ServicesInstances
     */
    protected $model = null;

    /**
     * @return null|IServiceResolver
     */
    public function getResolver()
    {
        $description = Yii2DescriptionsRepository::getInstance()
            ->find([IServiceDescription::FIELD__SERVICE_NAME => $this->getServiceName()])
            ->one();

        if ($description) {
            $describer = $description->getDescriber();
            $resolverClass = $describer->loadServiceConfig()->getServiceResolver();

            return new $resolverClass($this, $describer);
        }

        return null;
    }

    /**
     * @param ITriggerEvent $triggerEvent
     *
     * @return IServiceEvent
     * @throws \Exception
     */
    public function identifyServiceEventByTriggerEvent(ITriggerEvent $triggerEvent): IServiceEvent
    {
        $describer = $this->getDescriber();

        if (!$describer) {
            throw new \Exception('Missed service describer');
        }

        $events = $describer->getServiceEvents();

        foreach ($events as $event) {
            if ($event->getName() != $triggerEvent->getEventName()) {
                continue;
            }

            $data = $triggerEvent->getData();

            if (is_array($data)) {
                foreach ($data as $parameterName => $parameterValue) {
                    $event->hasParameter($parameterName) && $event->setParameter($parameterName, $parameterValue);
                }
            }
            return $event;
        }

        return null;
    }

    /**
     * todo
     * @param ITrigger $trigger
     *
     * @return IServiceAction
     * @throws \Exception
     */
    public function identifyServiceActionByTrigger(ITrigger $trigger): IServiceAction
    {
        $describer = $this->getDescriber();

        if (!$describer) {
            throw new \Exception('Missed service describer');
        }

        $actions = $describer->getServiceActions();

        foreach ($actions as $action) {
            if ($action->getName() != $trigger->getDestinationAction()) {
                continue;
            }

            // call extractors here

            return $action;
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function getAttribute($name)
    {
        if (!$this->model) {
            return null;
        }

        return $this->model->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    protected function setAttribute($name, $value)
    {
        if (!$this->model) {
            return $this;
        }

        $this->model->$name = $value;

        return $this;
    }
}
