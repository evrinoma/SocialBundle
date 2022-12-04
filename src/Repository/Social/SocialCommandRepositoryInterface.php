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

namespace Evrinoma\SocialBundle\Repository\Social;

use Evrinoma\SocialBundle\Exception\SocialCannotBeRemovedException;
use Evrinoma\SocialBundle\Exception\SocialCannotBeSavedException;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

interface SocialCommandRepositoryInterface
{
    /**
     * @param SocialInterface $social
     *
     * @return bool
     *
     * @throws SocialCannotBeSavedException
     */
    public function save(SocialInterface $social): bool;

    /**
     * @param SocialInterface $social
     *
     * @return bool
     *
     * @throws SocialCannotBeRemovedException
     */
    public function remove(SocialInterface $social): bool;
}
