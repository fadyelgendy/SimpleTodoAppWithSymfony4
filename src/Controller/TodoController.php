<?php

namespace  App\Controller;

use App\Entity\Todo;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TodoController extends AbstractController
{

    /**
     * @Route("/new", name="new_todo" )
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $todo = new Todo();

        $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' =>
            array('class'=> "form-control")))
            ->add('body', TextareaType::class, array(
                'required'=> false,
                'attr'=>array("class" => "form-control")))
            ->add('save', SubmitType::class, array(
            'label' => 'Create',
            "attr" => array('class' => 'btn btn-primary mt-3 rounded')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $todo = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($todo);
            $entityManager->flush();
            return $this->redirectToRoute("todo_list");
        }

        return $this->render('articles/new.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/update/{id}", name="update_todo" )
     * Method({"GET", "POST"})
     */
    public function update(Request $request, $id)
    {
        $todo = $this->getDoctrine()
            ->getRepository(Todo::class)
            ->find($id);

        $form = $this->createFormBuilder($todo)
            ->add('title', TextType::class, array('attr' =>
                array('class'=> "form-control")))
            ->add('body', TextareaType::class, array(
                'required'=> false,
                'attr'=>array("class" => "form-control")
            ))
            ->add('update', SubmitType::class, array(
                'label' => 'Edit',
                "attr" => array('class' => 'btn btn-primary mt-3 rounded')
            ))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("todo_list");
        }

        return $this->render('articles/edit.html.twig', array(
            'form' => $form->createView()));
    }


    /**
     * @Route("/todo/{id}", name="todo-show")
     */

    public function show($id)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        return $this->render("articles/show.html.twig", array(
            "todo" =>$todo
        ));
    }


    /**
     * @Route("/todo/delete/{id]")
     * Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        // find the item
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->remove($todo);
        $entityManger->flush();

        // send response to fetch
        $response = new Response();
        $response->send();
    }

    /**
     * @Route("/", name="todo_list")
     */
    public function index()
    {
        $todos = $this->getDoctrine()->getRepository
        (Todo::class)->findAll();

        return $this->render('articles/index.html.twig',
            array('todos'=> $todos)
        );
    }
}