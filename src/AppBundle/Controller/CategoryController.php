<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{

    /**
     * @Route("/list")
     */
    public function listAction(Request $request)
    {

        $qb = $this
                ->getDoctrine()
//                ->getManager()
                ->getRepository('AppBundle:Category')
                ->findAll();
//                ->createQueryBuilder();
//
//        $qb
//                ->select('c', 'j')
//                ->from('AppBundle:Category', 'c')
//                ->join('c.job', 'j');
//
//        $categories = $qb
//                ->getQuery()
//                ->getResult();

        return $this->render('Category/list.html.twig', [
                    'categories' => $qb,
        ]);
    }

}
