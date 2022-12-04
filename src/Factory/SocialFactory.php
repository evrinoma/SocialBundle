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

namespace Evrinoma\SocialBundle\Factory;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Entity\Social\BaseSocial;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

class SocialFactory implements SocialFactoryInterface
{
    private static string $entityClass = BaseSocial::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     */
    public function create(SocialApiDtoInterface $dto): SocialInterface
    {
        /* @var BaseSocial $social */
        return new self::$entityClass();
    }
}
