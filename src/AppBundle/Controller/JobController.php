<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use AppBundle\Entity\Job;
use AppBundle\Form\JobType;

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
                ->orWhere('j.companyName LIKE :query')
                ->orWhere('j.location LIKE :query')
                ->andWhere('j.verified = true')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();


        return $this->render('Job/search.html.twig', [
                    'jobs' => $jobs,
                    'query' => $query
        ]);
    }

    /**
     * @Route("/usun/{id}", name="remove_job")
     */
    public function deleteAction(Job $job)
    {

        if (!$job) {
            throw $this->createNotFoundException('Oferta nie istnieje');
        }

        $em = $this->getDoctrine()->getManager();

        $em->remove($job);
        $em->persist();

        return $this->redirectToRoute('jobs_list');
    }

    /**
     * @Route("/dodaj", name="add_job")
     */
    public function addAction(Request $request)
    {
        $user = $this->getUser();

        $userNbJobs = $this->getDoctrine()
                ->getRepository('AppBundle:Job')
                ->findBy(array('user' => $user));

        $job = new Job();
        $job->setEmail($user->getEmail());
        $job->setUser($user);

        $form = $this->createForm(new JobType(), $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$user) {
            $this->addFlash('error', 'Aby dodać ofertę musisz być zalogowany');
            return $this->redirectToRoute('jobs_list');
        }
        if ($form->isValid()) {
            if (count($userNbJobs) > 2 && $user->getVerified() == false) {

                $user->setVerified(true);
                $job->setVerified(true);
                $this->addFlash('notice', 'Oferta została pomyślnie dodana oraz użytkownik został'
                        . ' automatycznie zweryfikowany jako zaufany');

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                return $this->redirectToRoute('jobs_list');
            }
            if ($user->getVerified() == true) {

                $job->setVerified(true);
                $this->addFlash('notice', 'Oferta została pomyślnie dodana');

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                return $this->redirectToRoute('jobs_list');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->addFlash('notice', 'Oferta została pomyślnie dodana i oczekuje na moderacje');
            return $this->redirectToRoute('jobs_list');
        }

        return $this->render('Job/add.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edytuj/{id}", name="edit_job")
     * 
     */
    public function editAction(Request $request, Job $job)
    {
        $user = $this->getUser();

        $form = $this->createForm(new JobType(), $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$user) {
            $this->addFlash('notice', 'Musisz być zalogowany aby edytować ofertę');
            return $this->redirectToRoute('jobs_list');
        }

        $userNbJobs = $this->getDoctrine()
                ->getRepository('AppBundle:Job')
                ->findBy(array('user' => $user));

        if ($form->isValid()) {
            if (count($userNbJobs) > 2 && $user->getVerified() == false) {

                $user->setVerified(true);
                $job->setVerified(true);
                $this->addFlash('notice', 'Oferta została pomyślnie edytowana oraz użytkownik został'
                        . ' automatycznie zweryfikowany jako zaufany');

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                return $this->redirectToRoute('jobs_list');
            }
            if ($user->getVerified() == true) {

                $job->setVerified(true);
                $this->addFlash('notice', 'Oferta została pomyślnie edytowana');

                $em = $this->getDoctrine()->getManager();
                $em->persist($job);
                $em->flush();

                return $this->redirectToRoute('jobs_list');
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            $this->addFlash('notice', 'Oferta została pomyślnie edytowana i oczekuje na moderacje');
            return $this->redirectToRoute('jobs_list');
        }

        return $this->render('Job/edit.html.twig', [
                    'form' => $form->createView(),
                    'job' => $job,
        ]);
    }

    /**
     * @Route("/oferta/{id}", name="show_job", defaults={"id": false}, requirements={"id": "\d+"})
     */
    public function showAction(Job $job = null)
    {
        $user = $this->getUser();

        if (!$job) {
            $jobs = $this->getDoctrine()
                    ->getRepository('AppBundle:Job')
                    ->findBy(array('user' => $user), array('publishedAt' => 'DESC'));

            return $this->render('Job/show_jobs.html.twig', array(
                        'jobs' => $jobs,
            ));
        }

        $session = $this->get('session');
        $lastSean = $session->get('lastFive', array());
        array_unshift($lastSean, $job->getId());

        if (count($lastSean) == 6) {
            array_pop($lastSean);
        }
        $session->set('lastFive', $lastSean);

        return $this->render('Job/show.html.twig', [
                    'job' => $job,
        ]);
    }

    /**
     * @Route("/odnow/{id}", name="renew_job")
     */
    public function renewAction(Job $job)
    {

        $user = $this->getUser();
        
        $userJob = $this->getDoctrine()
                ->getRepository('AppBundle:Job')
                ->find($job);

        if ($job->getPublishedAt() < new \DateTime('-25 days') && 
                $user == $userJob->getUser() &&
                $user->hasRole('ROLE_USER')) {
            
            $job->setPublishedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($userJob);
            $em->flush();

            $this->addFlash('notice', 'Oferta została przedłużona o kolejne 30 dni');

            return $this->redirectToRoute('show_job');
        }

        $this->addFlash('error', 'Oferta nie może zostać jeszcze przedłużona');

        return $this->redirectToRoute('show_job');
    }

}
