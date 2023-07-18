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

namespace Evrinoma\SocialBundle\Serializer\Symfony;

use Evrinoma\UtilsBundle\Serialize\AbstractConfiguration;

class ConfigurationSocial extends AbstractConfiguration
{
    protected string $fileName = '/src/Resources/serializer/Symfony/serializer/SocialBundle/Model.Social.AbstractSocial.yml';
}
