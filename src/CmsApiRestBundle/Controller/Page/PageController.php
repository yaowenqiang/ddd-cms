<?php

namespace CmsApiRestBundle\Controller\Page;

use CmsBundle\Cms\Application\Model\Common\Request\QueryParams;
use CmsBundle\Cms\Application\Model\Page\CommandHandler\CreatePage\CreatePageCommand;
use CmsBundle\Cms\Application\Model\Page\CommandHandler\FindPages\FindPagesCommand;
use CmsBundle\Cms\Application\Model\Page\CommandHandler\GetPage\GetPageCommand;
use CmsBundle\Cms\Domain\Model\Page\Entity\Page;
use CmsBundle\Cms\Infrastructure\Services\Bus\CommandBus;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PageController
 * @package CmsApiRestBundle\Controller\Page
 *
 * @RouteResource("page", pluralize=false)
 */
class PageController extends Controller
{
    /** @var CommandBus  */
    private $commandBus;

    /**
     * PageController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Get a page",
     * )
     *
     * @View(statusCode=200, serializerGroups={"Default"})
     *
     * @param string $id
     * @return \CmsBundle\Cms\Application\Model\Page\CommandHandler\GetPage\GetPageCommandResult
     */
    public function getAction(string $id)
    {
        return $this->commandBus->handle(GetPageCommand::instance($id));
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="List page collection",
     * )
     *
     * @QueryParam(
     *     name="filter",
     *     description="Order fields in Json Format ie. filter={""user"":[""user_id"", ""user_id""], ""status"":1}"
     * )
     * @QueryParam(name="order", description="Filter by fields in Json Format ie. order={""createdOn"":""DESC""}")
     * @QueryParam(name="limit", requirements="\d+", default="250", description="Items per page")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page number")
     *
     * @View(statusCode=200, serializerGroups={"Default"})
     *
     * @param ParamFetcher $fetcher
     * @return Page[]
     * @internal param Request $request
     */
    public function cgetAction(ParamFetcher $fetcher)
    {
        $paramFetcher = new QueryParams($fetcher->all());

        return $this->commandBus->handle(FindPagesCommand::instance($paramFetcher));
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create page",
     * )
     *
     * @RequestParam(name="user_id", description="The user id")
     * @RequestParam(name="site_id", description="The site id")
     * @RequestParam(name="content", description="The page content")
     *
     * @View(statusCode=202, serializerGroups={"Default"})
     *
     * @param Request $request
     *
     * @return \CmsBundle\Cms\Application\Model\Page\CommandHandler\CreatePage\CreatePageCommandResult
     */
    public function postAction(Request $request)
    {
        $command = CreatePageCommand::instance(
            $request->request->get('user_id'),
            $request->request->get('site_id'),
            $request->request->get('content')
        );

        return $this->commandBus->handle($command);
    }
}
