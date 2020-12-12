<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\StudentType;
use App\Repository\StudentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;

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


    /**
     *@Route("/{id}/modif", name="editSudent")
     */
    public function modif(Request $request){
        $study = new Students;

        $form = $this->createForm(StudentType::class, $study);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('students');
        }

        return $this->render('students/edit.html.twig', [
            'study' => $study,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="deleteSudent")
     */
    public function delete(Students $study){
        $getId = $this->getDoctrine()->getManager();
        $getId->remove($study);
        $getId->flush();
        return $this->redirectToRoute('students');
    }
    
}
