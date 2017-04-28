<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController
{
    /**
     * @Route("/login_check", name="app_security_login_check")
     * @Method("POST")
     */
    public function loginCheckAction()
    {
        // no-op
    }

    /**
     * @Route("/logout", name="app_security_logout")
     * @Method("GET")
     */
    public function logoutAction()
    {
        // no-op
    }
}
