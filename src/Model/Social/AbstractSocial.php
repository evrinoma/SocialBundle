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

namespace Evrinoma\SocialBundle\Model\Social;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\NameTrait;
use Evrinoma\UtilsBundle\Entity\UrlTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractSocial implements SocialInterface
{
    use ActiveTrait;
    use CreateUpdateAtTrait;
    use IdTrait;
    use NameTrait;
    use UrlTrait;
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @param int|null $id
     *
     * @return SocialInterface
     */
    public function setId(?int $id): SocialInterface
    {
        $this->id = $id;

        return $this;
    }
}
