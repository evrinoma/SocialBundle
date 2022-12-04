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

namespace Evrinoma\SocialBundle\Mediator;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialCannotBeCreatedException;
use Evrinoma\SocialBundle\Exception\SocialCannotBeRemovedException;
use Evrinoma\SocialBundle\Exception\SocialCannotBeSavedException;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

interface CommandMediatorInterface
{
    /**
     * @param SocialApiDtoInterface $dto
     * @param SocialInterface       $entity
     *
     * @return SocialInterface
     *
     * @throws SocialCannotBeSavedException
     */
    public function onUpdate(SocialApiDtoInterface $dto, SocialInterface $entity): SocialInterface;

    /**
     * @param SocialApiDtoInterface $dto
     * @param SocialInterface       $entity
     *
     * @throws SocialCannotBeRemovedException
     */
    public function onDelete(SocialApiDtoInterface $dto, SocialInterface $entity): void;

    /**
     * @param SocialApiDtoInterface $dto
     * @param SocialInterface       $entity
     *
     * @return SocialInterface
     *
     * @throws SocialCannotBeSavedException
     * @throws SocialCannotBeCreatedException
     */
    public function onCreate(SocialApiDtoInterface $dto, SocialInterface $entity): SocialInterface;
}
