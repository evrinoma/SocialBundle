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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkUrl($dto)
            ->checkName($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkUrl($dto)
            ->checkName($dto)
            ->checkActive($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkUrl(DtoInterface $dto): self
    {
        /** @var SocialApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new SocialInvalidException('The Dto has\'t url');
        }

        return $this;
    }

    private function checkName(DtoInterface $dto): self
    {
        /** @var SocialApiDtoInterface $dto */
        if (!$dto->hasName()) {
            throw new SocialInvalidException('The Dto has\'t name');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var SocialApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new SocialInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var SocialApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new SocialInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
