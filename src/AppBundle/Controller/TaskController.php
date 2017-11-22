<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(Request $request)
    {
        //this request allow us to put a condition to displaying only the tasks which are over. 
        $overtasks = $request->query->get('overtasks');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');

        $tasks = ($overtasks !== null) ? $repository->findByIsTaskDone($overtasks) : $tasks = $repository->findAllTasks();

        return $this->render('task/list.html.twig', array(
                                'tasks' => $tasks
                            ));
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $user = $this->getUser();

        //if user session don't exist author will be null then anonymous
        if($user)
        {
            $task->setAuthor($user);
        }
        
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        //we recover the user session
        $session = $this->getUser();
        
        //we compare the user session with the owner of the task
        if(($session == $task->getAuthor() && $task->getAuthor() !== null) || ($task->getAuthor() === null && $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')))
        {
            $form = $this->createForm(TaskType::class, $task);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'La tâche a bien été modifiée.');

                return $this->redirectToRoute('task_list');
            }

            return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
            ]);
        }
        else
        {
            $this->addFlash('failed', 'Vous devez être soit l\'autheur de cette tâche soit administrateur pour pouvoir l\'editer.');
            
            return $this->redirectToRoute('task_list');
        }
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        //we recover the user session
        $session = $this->getUser();

        //we compare the user session with the owner of the task
        if(($session == $task->getAuthor() && $task->getAuthor() !== null) || ($task->getAuthor() === null && $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')))
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'La tâche a bien été supprimée.');
        }
        else
        {
            $this->addFlash('failed', 'Vous devez être l\'autheur de cette tâche pour la supprimer.');
        }
        
        return $this->redirectToRoute('task_list');
    }
}
