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
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param SocialApiDtoInterface $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(SocialApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param SocialApiDtoInterface $dto
     * @param QueryBuilderInterface $builder
     *
     * @return array
     */
    public function getResult(SocialApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
