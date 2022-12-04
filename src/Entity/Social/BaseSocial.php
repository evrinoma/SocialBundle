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

namespace Evrinoma\SocialBundle\Entity\Social;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\SocialBundle\Model\Social\AbstractSocial;

/**
 * @ORM\Table(name="e_social")
 * @ORM\Entity
 */
class BaseSocial extends AbstractSocial
{
}
