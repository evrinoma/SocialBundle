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

namespace Evrinoma\SocialBundle\Tests\Functional\Helper;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

trait BaseSocialTestTrait
{
    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createSocial(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankName(): array
    {
        $query = static::getDefault([SocialApiDtoInterface::NAME => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankUrl(): array
    {
        $query = static::getDefault([SocialApiDtoInterface::URL => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkSocial($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkSocial($entity): void
    {
        Assert::assertArrayHasKey(SocialApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(SocialApiDtoInterface::NAME, $entity);
        Assert::assertArrayHasKey(SocialApiDtoInterface::URL, $entity);
        Assert::assertArrayHasKey(SocialApiDtoInterface::ACTIVE, $entity);
    }
}
