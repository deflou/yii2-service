<?php
namespace deflou\components\services\repositories;

/**
 * Class Yii2RepositoryAbstract
 *
 * @package deflou\components\services\repositories
 * @author deflou.dev@gmail.com
 */
class Yii2RepositoryAbstract
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
}
