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

namespace Evrinoma\SocialBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\SocialBundle\Validator\SocialValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class SocialPass extends AbstractConstraint implements CompilerPassInterface
{
    public const SOCIAL_CONSTRAINT = 'evrinoma.social.constraint.property';

    protected static string $alias = self::SOCIAL_CONSTRAINT;
    protected static string $class = SocialValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
