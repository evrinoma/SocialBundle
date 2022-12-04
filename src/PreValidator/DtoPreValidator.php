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
    }

    public function onPut(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkId(DtoInterface $dto): void
    {
        /** @var SocialApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new SocialInvalidException('The Dto has\'t ID or class invalid');
        }
    }
}
