<?php

namespace AppBundle\Helper\RequestResolver\Task\ListTask;

use AppBundle\Helper\RequestResolver\Task\AbstractRequestResolver;
use Symfony\Component\HttpFoundation\Request;

class RequestResolver extends AbstractRequestResolver
{
    /**
     * @param Request $request
     * @return bool
     */
    public function resolve(Request $request)
    {
        $this->checkQueryParam($request);
        $isDone = ($this->valueParam === 'done') ? true : false;

        return $isDone;
    }
}
