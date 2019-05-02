<?php

namespace AppBundle\Helper\RequestResolver\Task\ToggleTask;

use AppBundle\Helper\RequestResolver\Task\AbstractRequestResolver;
use Symfony\Component\HttpFoundation\Request;

class RequestResolver extends AbstractRequestResolver
{
    public function resolve(Request $request)
    {
        $this->checkTaskExist($request);
        $this->checkQueryParam($request);
        $this->checkAllowUser(
            "Vous ne pouvez pas changer le status d'une tâche d'un autre utilisateur."
        );
    }
}
