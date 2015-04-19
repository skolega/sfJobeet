<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;

class JobController extends Controller
{

    /**
     * @Route("/oferty/{id}", name="jobs_list", defaults={"id" = false}, requirements={"id": "\d+"})
     */
    public function indexAction(Request $request, Category $category = null)
    {

        $jobs = $this->getDoctrine()
                ->getRepository('AppBundle:Job')
                ->getJobsQuery($category);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $jobs, $request->query->get('page', 1), 10
        );
        return $this->render('Job/index.html.twig', [
                    'pagination' => $pagination
        ]);
    }

    /**
     * 
     * @Route("/szukaj", name="job_search")
     */
    public function searchAction(Request $request)
    {
        $query = $request->query->get('query');

        $jobs = $this->getDoctrine()
                ->getRepository('AppBundle:Job')
                ->createQueryBuilder('j')
                ->SELECT('j')
                ->where('j.position LIKE :query')
                ->orWhere('j.description LIKE :query')
                ->orWhere('j.location LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();



        return $this->render('Job/search.html.twig', [
                    'jobs' => $jobs,
                    'query' => $query
        ]);
    }

    /**
     * @Route("/usun/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/dodaj")
     */
    public function addAction()
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/edytuj/{id}")
     * @Template()
     */
    public function editAction($id)
    {
        return array(
                // ...
        );
    }

    /**
     * @Route("/oferta/{id}")
     * @Template()
     */
    public function showAction($id)
    {
        return array(
                // ...
        );
    }

}
