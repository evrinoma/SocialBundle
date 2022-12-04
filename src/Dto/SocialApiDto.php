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

namespace Evrinoma\SocialBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlTrait;
use Symfony\Component\HttpFoundation\Request;

class SocialApiDto extends AbstractDto implements SocialApiDtoInterface
{
    use ActiveTrait;
    use IdTrait;
    use NameTrait;
    use UrlTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(SocialApiDtoInterface::ACTIVE);
            $id = $request->get(SocialApiDtoInterface::ID);
            $name = $request->get(SocialApiDtoInterface::NAME);
            $url = $request->get(SocialApiDtoInterface::URL);

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($name) {
                $this->setName($name);
            }
            if ($url) {
                $this->setUrl($url);
            }
        }

        return $this;
    }
}
