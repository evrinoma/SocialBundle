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

namespace Evrinoma\SocialBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Entity\Social\BaseSocial;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class SocialFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            SocialApiDtoInterface::NAME => 'ite',
            SocialApiDtoInterface::URL => 'http://ite',
            SocialApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2008-10-23 10:21:50',
        ],
        [
            SocialApiDtoInterface::NAME => 'kzkt',
            SocialApiDtoInterface::URL => 'http://kzkt',
            SocialApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2015-10-23 10:21:50',
        ],
        [
            SocialApiDtoInterface::NAME => 'c2m',
            SocialApiDtoInterface::URL => 'http://c2m',
            SocialApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2020-10-23 10:21:50',
        ],
        [
            SocialApiDtoInterface::NAME => 'kzkt2',
            SocialApiDtoInterface::URL => 'http://kzkt2',
            SocialApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2015-10-23 10:21:50',
            ],
        [
            SocialApiDtoInterface::NAME => 'nvr',
            SocialApiDtoInterface::URL => 'http://nvr',
            SocialApiDtoInterface::ACTIVE => 'b',
            'created_at' => '2010-10-23 10:21:50',
        ],
        [
            SocialApiDtoInterface::NAME => 'nvr2',
            SocialApiDtoInterface::URL => 'http://nvr2',
            SocialApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2010-10-23 10:21:50',
            ],
        [
            SocialApiDtoInterface::NAME => 'nvr3',
            SocialApiDtoInterface::URL => 'http://nvr3',
            SocialApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2011-10-23 10:21:50',
        ],
    ];

    protected static string $class = BaseSocial::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setName($record[SocialApiDtoInterface::NAME])
                ->setUrl($record[SocialApiDtoInterface::URL])
                ->setCreatedAt(new \DateTimeImmutable($record['created_at']))
                ->setActive($record[SocialApiDtoInterface::ACTIVE]);

            $this->expandEntity($entity);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::SOCIAL_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
