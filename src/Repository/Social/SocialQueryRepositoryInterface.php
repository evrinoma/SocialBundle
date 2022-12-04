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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Exception\SocialProxyException;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

interface SocialQueryRepositoryInterface
{
    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws SocialNotFoundException
     */
    public function findByCriteria(SocialApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return SocialInterface
     *
     * @throws SocialNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): SocialInterface;

    /**
     * @param string $id
     *
     * @return SocialInterface
     *
     * @throws SocialProxyException
     * @throws ORMException
     */
    public function proxy(string $id): SocialInterface;
}
