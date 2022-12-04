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
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Exception\SocialProxyException;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

interface QueryManagerInterface
{
    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws SocialNotFoundException
     */
    public function criteria(SocialApiDtoInterface $dto): array;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialNotFoundException
     */
    public function get(SocialApiDtoInterface $dto): SocialInterface;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialProxyException
     */
    public function proxy(SocialApiDtoInterface $dto): SocialInterface;
}
