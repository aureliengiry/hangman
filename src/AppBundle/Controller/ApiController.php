<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api")
 */
class ApiController
{
    /**
     * @Route("/game/add-word/{word}")
     * @Method("PUT")
     */
    public function addGameWordAction($word)
    {
        // TODO rajouter le mot dans un dico
    }
}
