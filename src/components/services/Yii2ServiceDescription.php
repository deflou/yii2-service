<?php
namespace deflou\components\services;

use app\models\mongo\ServicesDescriptions;
use deflou\interfaces\services\IServiceDescription;

/**
 * Class Yii2ServiceDescription
 *
 * @package deflou\components\services
 * @author deflou.dev@gmail.com
 */
class Yii2ServiceDescription extends ServiceDescriptionAbstract implements IServiceDescription
{
    /**
     * @var ServicesDescriptions
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
     * @throws \Exception
     */
    protected function setAttribute($name, $value)
    {
        if (!$this->model) {
            throw new \Exception('Missed model');
        }

        $this->model->$name = $value;

        return $this;
    }
}
