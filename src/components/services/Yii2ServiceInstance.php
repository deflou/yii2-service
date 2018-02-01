<?php
namespace deflou\components\services;

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
