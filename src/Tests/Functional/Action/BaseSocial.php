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

namespace Evrinoma\SocialBundle\Tests\Functional\Action;

use Evrinoma\SocialBundle\Dto\SocialApiDto;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Tests\Functional\Helper\BaseSocialTestTrait;
use Evrinoma\SocialBundle\Tests\Functional\ValueObject\Social\Active;
use Evrinoma\SocialBundle\Tests\Functional\ValueObject\Social\Id;
use Evrinoma\SocialBundle\Tests\Functional\ValueObject\Social\Name;
use Evrinoma\SocialBundle\Tests\Functional\ValueObject\Social\Url;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseSocial extends AbstractServiceTest implements BaseSocialTestInterface
{
    use BaseSocialTestTrait;

    public const API_GET = 'evrinoma/api/social';
    public const API_CRITERIA = 'evrinoma/api/social/criteria';
    public const API_DELETE = 'evrinoma/api/social/delete';
    public const API_PUT = 'evrinoma/api/social/save';
    public const API_POST = 'evrinoma/api/social/create';

    protected static function getDtoClass(): string
    {
        return SocialApiDto::class;
    }

    protected static function defaultData(): array
    {
        return [
            SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            SocialApiDtoInterface::ID => Id::default(),
            SocialApiDtoInterface::NAME => Name::default(),
            SocialApiDtoInterface::ACTIVE => Active::value(),
            SocialApiDtoInterface::URL => Url::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createSocial();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ID => Id::value(), SocialApiDtoInterface::ACTIVE => Active::block(), SocialApiDtoInterface::NAME => Name::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ACTIVE => Active::value(), SocialApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ACTIVE => Active::delete(), SocialApiDtoInterface::NAME => Name::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([SocialApiDtoInterface::DTO_CLASS => static::getDtoClass(), SocialApiDtoInterface::ID => 49, SocialApiDtoInterface::ACTIVE => Active::block(), SocialApiDtoInterface::NAME => Name::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][SocialApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][SocialApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault([SocialApiDtoInterface::ID => Id::value(), SocialApiDtoInterface::NAME => Name::value()]));
        $this->testResponseStatusOK();

        Assert::assertEquals($find[PayloadModel::PAYLOAD][0][SocialApiDtoInterface::ID], $updated[PayloadModel::PAYLOAD][0][SocialApiDtoInterface::ID]);
        Assert::assertEquals(Name::value(), $updated[PayloadModel::PAYLOAD][0][SocialApiDtoInterface::NAME]);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([SocialApiDtoInterface::ID => Id::wrong(), SocialApiDtoInterface::NAME => Name::wrong()]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $query = static::getDefault([SocialApiDtoInterface::ID => Id::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $this->createSocial();

        $query = static::getDefault([SocialApiDtoInterface::NAME => Name::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createSocial();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankId();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankName();
        $this->testResponseStatusUnprocessable();
    }
}
