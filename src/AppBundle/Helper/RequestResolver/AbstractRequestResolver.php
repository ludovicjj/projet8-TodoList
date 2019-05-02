<?php

namespace AppBundle\Helper\RequestResolver;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequestResolver
{
    /** @var array */
    const ALLOW_PARAMS = ['done', 'waiting'];

    /** @var string */
    protected $routeParam;

    /** @var string */
    protected $valueParam;

    protected function checkQueryParam(Request $request)
    {
        $valueParam = $request->query->get('search', 'waiting');

        // Check if query param "search" has an allow value
        if (!\in_array($valueParam, self::ALLOW_PARAMS)) {
            $valueParam = 'waiting';
        }

        $this->routeParam = '?search='.$valueParam;
        $this->valueParam = $valueParam;
    }

    /**
     * @return string
     */
    public function getRouteParam()
    {
        return $this->routeParam;
    }

    /**
     * @return string
     */
    public function getValueParam()
    {
        return $this->valueParam;
    }
}
