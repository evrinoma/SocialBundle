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
use Evrinoma\SocialBundle\Repository\Social\SocialQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private SocialQueryRepositoryInterface $repository;

    public function __construct(SocialQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws SocialNotFoundException
     */
    public function criteria(SocialApiDtoInterface $dto): array
    {
        try {
            $social = $this->repository->findByCriteria($dto);
        } catch (SocialNotFoundException $e) {
            throw $e;
        }

        return $social;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialProxyException
     */
    public function proxy(SocialApiDtoInterface $dto): SocialInterface
    {
        try {
            if ($dto->hasId()) {
                $social = $this->repository->proxy($dto->idToString());
            } else {
                throw new SocialProxyException('Id value is not set while trying get proxy object');
            }
        } catch (SocialProxyException $e) {
            throw $e;
        }

        return $social;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialNotFoundException
     */
    public function get(SocialApiDtoInterface $dto): SocialInterface
    {
        try {
            $social = $this->repository->find($dto->idToString());
        } catch (SocialNotFoundException $e) {
            throw $e;
        }

        return $social;
    }
}
