<?php
namespace deflou\components\services;

use app\models\mongo\Yii2ServicesRegistries;
use deflou\interfaces\services\IServiceRegistry;

/**
 * Class Yii2ServiceRegistry
 *
 * @package deflou\components\services
 * @author deflou.dev@gmail.com
 */
class Yii2ServiceRegistry extends ServiceRegistryAbstract implements IServiceRegistry
{
    /**
     * @var Yii2ServicesRegistries
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
