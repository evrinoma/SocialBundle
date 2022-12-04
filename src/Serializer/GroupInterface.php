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

namespace Evrinoma\SocialBundle\Serializer;

interface GroupInterface
{
    public const API_POST_SOCIAL = 'API_POST_SOCIAL';
    public const API_PUT_SOCIAL = 'API_PUT_SOCIAL';
    public const API_GET_SOCIAL = 'API_GET_SOCIAL';
    public const API_CRITERIA_SOCIAL = self::API_GET_SOCIAL;
    public const APP_GET_BASIC_SOCIAL = 'APP_GET_BASIC_SOCIAL';
}
