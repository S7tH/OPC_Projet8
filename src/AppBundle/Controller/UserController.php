<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Form\Type\UserEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * @Route("/users", name="user_list")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        //recover the repository
        $users = $this->getDoctrine()
        ->getManager()
        ->getRepository('AppBundle:User')
        ->findAll()
        ;

        //recover the paginator service
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $response = $this->render('user/list.html.twig', array(
            'users' => $users,
            'pagination' => $pagination
        ));
        $response->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    /**
     * @Route("/users/create", name="user_create")
     * @Method({"GET", "POST"}) 
     */
    public function createAction(Request $request, Response $response = null)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            if($response){$response->expire();}
            return $this->redirectToRoute('user_list');
        }

        $response = $this->render('user/create.html.twig', ['form' => $form->createView()]);
        $response->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    
    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User $user, Request $request, Response $response = null)
    {
        $form = $this->createForm(UserEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");
            if($response){$response->expire();}
            return $this->redirectToRoute('user_list');
            
        }

        $response = $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
        $response->setSharedMaxAge(3600)->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }
}
