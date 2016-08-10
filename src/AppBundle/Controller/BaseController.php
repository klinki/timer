<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BaseController
 * @package AppBundle\Controller
 *
 */
class BaseController extends Controller
{
    protected function requireMethod(Request $request, $method = 'POST')
    {
        if (!$request->isMethod($method)) {
            throw $this->createNotFoundException("Expecting method {$method}");
        }
    }
}
