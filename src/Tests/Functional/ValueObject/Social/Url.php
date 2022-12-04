<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\SocialBundle\Tests\Functional\ValueObject\Social;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractIdentity;

class Url extends AbstractIdentity
{
    protected static string $value = 'http://nvr';
    protected static string $default = 'http://kpz';
}
