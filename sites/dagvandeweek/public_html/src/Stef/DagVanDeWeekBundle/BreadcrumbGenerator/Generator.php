<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;

use Stef\SimpleCmsBundle\Entity\AbstractCmsContent;
use Symfony\Component\HttpFoundation\Request;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class Generator {

    /**
     * @var Breadcrumbs
     */
    protected $breadcrumbs;

    /**
     * @var TitleBuilderInterface
     */
    protected $titleBuilder;
    /**
     * @param Breadcrumbs $breadcrumbs
     */
    function __construct(Breadcrumbs $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * @param TitleBuilderInterface $titleBuilder
     */
    public function setTitleBuilder(TitleBuilderInterface $titleBuilder)
    {
        $this->titleBuilder = $titleBuilder;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    public function explodeUrlPath($path)
    {
        $path = trim($path, '/');

        return explode('/', $path);
    }

    /**
     * @param Request $request
     * @param array $pathElements
     *
     * @return array
     */
    public function prepareFirstPathElement(Request $request, array $pathElements)
    {
        if ($pathElements[0] !== trim($request->getBaseUrl(), '/')) {
            array_unshift($pathElements, '/');
        } else {
            $pathElements[0] = '/' . $pathElements[0];
        }

        return $pathElements;
    }

    public function generate(Request $request, AbstractCmsContent $page = null)
    {
        $explode = $this->explodeUrlPath($request->getRequestUri());
        $explode = $this->prepareFirstPathElement($request, $explode);

        $path = [];
        $i = 0;

        foreach ($explode as $p) {
            $path[] = $p;
            $crumblink = '/' . trim(implode('/', $path), '/');
            $i++;

            if (count($path) === 1) {
                $this->breadcrumbs->addItem('Home', $crumblink);
            } elseif ($i === count($explode) && $page !== null) {
                $this->breadcrumbs->addItem($page->getTitle(), $crumblink);
            } else {
                $this->breadcrumbs->addItem($this->titleBuilder->build($p, $i), $crumblink);
            }
        }
    }
}