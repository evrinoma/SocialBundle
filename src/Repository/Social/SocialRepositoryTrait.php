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
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialCannotBeSavedException;
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Exception\SocialProxyException;
use Evrinoma\SocialBundle\Mediator\QueryMediatorInterface;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;

trait SocialRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param SocialInterface $social
     *
     * @return bool
     *
     * @throws SocialCannotBeSavedException
     * @throws ORMException
     */
    public function save(SocialInterface $social): bool
    {
        try {
            $this->persistWrapped($social);
        } catch (ORMInvalidArgumentException $e) {
            throw new SocialCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param SocialInterface $social
     *
     * @return bool
     */
    public function remove(SocialInterface $social): bool
    {
        return true;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return array
     *
     * @throws SocialNotFoundException
     */
    public function findByCriteria(SocialApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $socials = $this->mediator->getResult($dto, $builder);

        if (0 === \count($socials)) {
            throw new SocialNotFoundException('Cannot find social by findByCriteria');
        }

        return $socials;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws SocialNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): SocialInterface
    {
        /** @var SocialInterface $social */
        $social = $this->findWrapped($id);

        if (null === $social) {
            throw new SocialNotFoundException("Cannot find social with id $id");
        }

        return $social;
    }

    /**
     * @param string $id
     *
     * @return SocialInterface
     *
     * @throws SocialProxyException
     * @throws ORMException
     */
    public function proxy(string $id): SocialInterface
    {
        $social = $this->referenceWrapped($id);

        if (!$this->containsWrapped($social)) {
            throw new SocialProxyException("Proxy doesn't exist with $id");
        }

        return $social;
    }
}
