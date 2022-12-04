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

namespace Evrinoma\SocialBundle\Manager;

use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialCannotBeCreatedException;
use Evrinoma\SocialBundle\Exception\SocialCannotBeRemovedException;
use Evrinoma\SocialBundle\Exception\SocialCannotBeSavedException;
use Evrinoma\SocialBundle\Exception\SocialInvalidException;
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Factory\SocialFactoryInterface;
use Evrinoma\SocialBundle\Mediator\CommandMediatorInterface;
use Evrinoma\SocialBundle\Model\Social\SocialInterface;
use Evrinoma\SocialBundle\Repository\Social\SocialRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private SocialRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private SocialFactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface       $validator
     * @param SocialRepositoryInterface   $repository
     * @param SocialFactoryInterface      $factory
     * @param CommandMediatorInterface $mediator
     */
    public function __construct(ValidatorInterface $validator, SocialRepositoryInterface $repository, SocialFactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialInvalidException
     * @throws SocialCannotBeCreatedException
     * @throws SocialCannotBeSavedException
     */
    public function post(SocialApiDtoInterface $dto): SocialInterface
    {
        $social = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $social);

        $errors = $this->validator->validate($social);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new SocialInvalidException($errorsString);
        }

        $this->repository->save($social);

        return $social;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @return SocialInterface
     *
     * @throws SocialInvalidException
     * @throws SocialNotFoundException
     * @throws SocialCannotBeSavedException
     */
    public function put(SocialApiDtoInterface $dto): SocialInterface
    {
        try {
            $social = $this->repository->find($dto->idToString());
        } catch (SocialNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $social);

        $errors = $this->validator->validate($social);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new SocialInvalidException($errorsString);
        }

        $this->repository->save($social);

        return $social;
    }

    /**
     * @param SocialApiDtoInterface $dto
     *
     * @throws SocialCannotBeRemovedException
     * @throws SocialNotFoundException
     */
    public function delete(SocialApiDtoInterface $dto): void
    {
        try {
            $social = $this->repository->find($dto->idToString());
        } catch (SocialNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $social);
        try {
            $this->repository->remove($social);
        } catch (SocialCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
