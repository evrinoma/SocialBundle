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

namespace Evrinoma\SocialBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\SocialBundle\Dto\SocialApiDtoInterface;
use Evrinoma\SocialBundle\Exception\SocialCannotBeSavedException;
use Evrinoma\SocialBundle\Exception\SocialInvalidException;
use Evrinoma\SocialBundle\Exception\SocialNotFoundException;
use Evrinoma\SocialBundle\Facade\Social\FacadeInterface;
use Evrinoma\SocialBundle\Serializer\GroupInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use Evrinoma\UtilsBundle\Serialize\SerializerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class SocialApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/social/create", options={"expose": true}, name="api_social_create")
     * @OA\Post(
     *     tags={"social"},
     *     description="the method perform create social",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\SocialBundle\Dto\SocialApiDto",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\SocialBundle\Dto\SocialApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create social")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var SocialApiDtoInterface $socialApiDto */
        $socialApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_SOCIAL;

        try {
            $this->facade->post($socialApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create social', $json, $error);
    }

    /**
     * @Rest\Put("/api/social/save", options={"expose": true}, name="api_social_save")
     * @OA\Put(
     *     tags={"social"},
     *     description="the method perform save social for current entity",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={
     *                     "class": "Evrinoma\SocialBundle\Dto\SocialApiDto",
     *                     "active": "b",
     *                     "id": "48",
     *                     "name": "Instagram",
     *                     "url": "http://www.instagram.com/intertechelectro",
     *                 },
     *                 type="object",
     *                 @OA\Property(property="class", type="string", default="Evrinoma\SocialBundle\Dto\SocialApiDto"),
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="url", type="string"),
     *                 @OA\Property(property="active", type="string")
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save social")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var SocialApiDtoInterface $socialApiDto */
        $socialApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_SOCIAL;

        try {
            $this->facade->put($socialApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save social', $json, $error);
    }

    /**
     * @Rest\Delete("/api/social/delete", options={"expose": true}, name="api_social_delete")
     * @OA\Delete(
     *     tags={"social"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\SocialBundle\Dto\SocialApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete social")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var SocialApiDtoInterface $socialApiDto */
        $socialApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($socialApiDto, '', $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete social', $json, $error);
    }

    /**
     * @Rest\Get("/api/social/criteria", options={"expose": true}, name="api_social_criteria")
     * @OA\Get(
     *     tags={"social"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\SocialBundle\Dto\SocialApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="name",
     *         in="query",
     *         name="name",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="url",
     *         in="query",
     *         name="url",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return social")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var SocialApiDtoInterface $socialApiDto */
        $socialApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_SOCIAL;

        try {
            $this->facade->criteria($socialApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get social', $json, $error);
    }

    /**
     * @Rest\Get("/api/social", options={"expose": true}, name="api_social")
     * @OA\Get(
     *     tags={"social"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\SocialBundle\Dto\SocialApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return social")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var SocialApiDtoInterface $socialApiDto */
        $socialApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_SOCIAL;

        try {
            $this->facade->get($socialApiDto, $group, $json);
        } catch (\Exception $e) {
            $json = [];
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get social', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof SocialCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof SocialNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof SocialInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
