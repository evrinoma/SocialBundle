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

namespace Evrinoma\SocialBundle\PreValidator;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param SocialApiDtoInterface $dto
     *
     * @throws SocialInvalidException
     */
    public function onPost(SocialApiDtoInterface $dto): void;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @throws SocialInvalidException
     */
    public function onPut(SocialApiDtoInterface $dto): void;

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @throws SocialInvalidException
     */
    public function onDelete(SocialApiDtoInterface $dto): void;
}
