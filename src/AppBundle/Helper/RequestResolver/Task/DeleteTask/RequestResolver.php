<?php

namespace AppBundle\Helper\RequestResolver\Task\DeleteTask;

use AppBundle\Helper\RequestResolver\Task\AbstractRequestResolver;
use Symfony\Component\HttpFoundation\Request;

class RequestResolver extends AbstractRequestResolver
{
    public function resolve(Request $request)
    {
        $this->checkTaskExist($request);
        $this->checkQueryParam($request);
        $this->checkAllowUser(
            "Vous ne pouvez pas supprimer la tâche d'un autre utilisateur."
        );
    }
}
