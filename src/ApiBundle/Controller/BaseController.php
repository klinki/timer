<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class BaseController
 * @package ApiBundle\Controller
 *
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class BaseController extends FOSRestController
{

}
