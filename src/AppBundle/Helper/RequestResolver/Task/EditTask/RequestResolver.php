<?php

namespace AppBundle\Helper\RequestResolver\Task\EditTask;

use AppBundle\Helper\RequestResolver\Task\AbstractRequestResolver;
use Symfony\Component\HttpFoundation\Request;

class RequestResolver extends AbstractRequestResolver
{
    public function resolve(Request $request)
    {
        $this->checkTaskExist($request);
        $this->checkQueryParam($request);
        $this->checkAllowUser(
            "Vous ne pouvez pas modifier la tâche d'un autre utilisateur."
        );
    }
}
