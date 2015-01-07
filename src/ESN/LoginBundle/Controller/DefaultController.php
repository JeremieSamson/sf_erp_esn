<?php

namespace ESN\LoginBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // Gestion d'un formulaire :
        // Si la requête est un post, c'est uqe le visiteur a soumis le formulaire
        if ($request->isMethod('POST')) {
            //Puis on redirige vers la page de visualisation de cette annonce
            return $this->redirect($this->generateUrl('esn_admin_homepage'));
        }
        // Si on n'est pas en Post, alors on affiche le formulaire
        return $this->render('ESNLoginBundle:Default:index.html.twig');
    }
    
    
}
