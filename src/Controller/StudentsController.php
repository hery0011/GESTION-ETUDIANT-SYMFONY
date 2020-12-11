<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentType;
use App\Repository\StudentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentsController extends AbstractController
{
    /**
     * @Route("/students", name="students")
     */
    public function index(StudentsRepository $stud): Response
    {
        $students = $stud->findAll() ;
        return $this->render('students/index.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function addNew(Request $request){
        $student = new Students;

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                    $file = $student->getPhoto(); /*le any am entity*/
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move($this->getParameter('upload_directory'), $fileName);
                    $student->setPhoto($fileName); /*le any am entity*/

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($student);
                    $em->flush();
                    
                    return $this->redirectToRoute('students');
                }        
 
        return $this->render('students/add.html.twig',
            ['form'=>$form->createView()]
    );
    }
}
