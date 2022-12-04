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

namespace Evrinoma\SocialBundle\Manager;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialCannotBeRemovedException;
use Evrinoma\SocialBundle\Exception\SocialInvalidException;
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

interface CommandManagerInterface
{
    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialInvalidException
     */
    public function post(SocialApiDtoInterface $dto): SocialInterface;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialInvalidException
     * @throws SocialNotFoundException
     */
    public function put(SocialApiDtoInterface $dto): SocialInterface;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @throws SocialCannotBeRemovedException
     * @throws SocialNotFoundException
     */
    public function delete(SocialApiDtoInterface $dto): void;
}
