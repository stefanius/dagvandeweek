<?php

namespace Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator;

use Symfony\Component\HttpFoundation\Request;

class Generator
{
    /**
     * @var string
     */
    protected $linkKey = 'link';

    /**
     * @var string
     */
    protected $titleKey = 'title';

    /**
     * @var TitleBuilderInterface
     */
    protected $titleBuilder;

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
    protected function explodeUrlPath($path)
    {
        $path = trim($path, '/');

        return explode('/', $path);
    }

    /**
     * @param Request $request
     * @param array   $pathElements
     *
     * @return array
     */
    protected function prepareFirstPathElement(Request $request, array $pathElements)
    {
        if ($pathElements[0] !== trim($request->getBaseUrl(), '/')) {
            array_unshift($pathElements, '/');
        } else {
            $pathElements[0] = '/' . $pathElements[0];
        }

        return $pathElements;
    }

    /**
     * @param $path
     * @param $crumblink
     * @param $splitItems
     * @param $splitItem
     * @param $page
     * @param $index
     *
     * @return array
     */
    protected function createCrumb($path, $crumblink, $splitItems, $splitItem, $page, $index)
    {
        if (count($path) === 1) {
            $crumb = [
                $this->linkKey  => $crumblink,
                $this->titleKey => 'Home',
            ];
        } elseif ($index === count($splitItems) && $page !== null && property_exists($page, 'title')) {
            $crumb = [
                $this->linkKey  => $crumblink,
                $this->titleKey => $page->getTitle(),
            ];
        } else {
            $crumb = [
                $this->linkKey  => $crumblink,
                $this->titleKey => $this->titleBuilder->build($splitItem, $index, $path),
            ];
        }

        return $crumb;
    }

    /**
     * @param Request $request
     * @param null    $page
     *
     * @return array
     */
    public function generate(Request $request, $page = null)
    {
        $splitItems = $this->prepareFirstPathElement($request, $this->explodeUrlPath($request->getRequestUri()));

        $crumbs = [];
        $path   = [];
        $i      = 0;

        foreach ($splitItems as $splitItem) {
            $path[]    = $splitItem;
            $crumb     = null;
            $crumblink = '/' . trim(implode('/', $path), '/');
            $i++;

            $crumbs[] = $this->createCrumb($path, $crumblink, $splitItems, $splitItem, $page, $i);
        }

        return $crumbs;
    }
}
