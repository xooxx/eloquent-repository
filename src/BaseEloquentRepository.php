<?php

namespace Xooxx\Foundation\Infrastructure\Model\Repository\Eloquent;

use Xooxx\Assert\Assert;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository
{
    /** @var Model */
    protected static $instance;
    /**
     * BaseEloquentRepository constructor.
     *
     * @param Model $instance
     */
    protected function __construct(Model $instance)
    {
        self::$instance = $instance;
    }
    /**
     * @param Model $instance
     *
     * @return static
     */
    public static function create(Model $instance)
    {
        return new static($instance);
    }
    /**
     * @param $value
     *
     * @throws \Exception
     */
    protected function guard($value)
    {
        Assert::isInstanceOf($value, self::$instance);
    }
}