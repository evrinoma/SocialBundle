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

namespace Evrinoma\SocialBundle;

use Evrinoma\SocialBundle\DependencyInjection\Compiler\Constraint\Property\SocialPass;
use Evrinoma\SocialBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\SocialBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\SocialBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\SocialBundle\DependencyInjection\EvrinomaSocialExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaSocialBundle extends Bundle
{
    public const BUNDLE = 'social';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new SocialPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaSocialExtension();
        }

        return $this->extension;
    }
}
