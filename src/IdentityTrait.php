<?php

/**
 * Author: Xooxx <xooxx.dev@gmail.com>
 * Date: 9/02/16
 * Time: 20:31.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Xooxx\Foundation\Infrastructure\Model\Repository\Eloquent;

/**
 * Class IdentityTrait.
 */
trait IdentityTrait
{
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
    /**
     * @return string
     */
    public function id()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return (string) $this->id;
    }
}