<?php
/**
 * Created by PhpStorm.
 * User: jerem
 * Date: 27/03/16
 * Time: 17:50
 */

namespace ESN\AdministrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\Translator;

class BaseController extends Controller
{
    /**
     * @return Translator
     */
    public function getTranslator() {
        return $this->get('translator');
    }

}