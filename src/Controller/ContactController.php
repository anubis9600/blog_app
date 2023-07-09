<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\CategoriesServices;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // $form = $this->createFormBuilder()
        //             ->add("Civility", ChoiceType::class, [
        //                 "label" => "Votre sexe : ",
        //                 'choices' => [
        //                     'Mr' => "Monsieur",
        //                     'Mlle' => "Mademoiselle",
        //                     'Mme' => "Madame"
        //                 ]
        //                 // "attr" => [
        //                 //     "placeholder" => "Sexe...",
        //                 //     "class" => "form-group flex-1"
        //                 // ],
        //                 // "row_attr" =>[
        //                 //     "class" => "form-group"
        //                 // ]
        //             ])
        //             ->add("Category", ChoiceType::class, [
        //                 "label" => "Votre catégorie : ",
        //                 'choices' => $repoCat->findAll(),
        //                 'choice_value' => 'name',
        //                 'multiple' => true,
        //                 'choice_label' => function(?Category $category){
        //                     return $category ? strtoupper($category->getName()) : '';
        //                 }
        //                 // "attr" => [
        //                 //     "placeholder" => "Sexe...",
        //                 //     "class" => "form-group flex-1"
        //                 // ],
        //                 // "row_attr" =>[
        //                 //     "class" => "form-group"
        //                 // ]
        //             ])
        //             ->add("Hobies", CheckboxType::class, [])
        //             ->add("Sports", CheckboxType::class, [])
        //             ->add("File", FileType::class, [
        //                 // "label" => "Adresse Mail : ",
        //                 // "attr" => [
        //                 //     "placeholder" => "Votre Email",
        //                 //     "class" => "form-group flex-1"
        //                 // ],
        //                 // "row_attr" =>[
        //                 //     "class" => "form-group"
        //                 // ]
        //             ])
        //             ->add("Email", EmailType::class, [
        //                 "label" => "Adresse Mail : ",
        //                 "attr" => [
        //                     "placeholder" => "Votre Email",
        //                     "class" => "form-group flex-1"
        //                 ],
        //                 "row_attr" =>[
        //                     "class" => "form-group"
        //                 ]
        //             ])
        //             ->add("Subject", TextType::class, [
        //                 "label" => "Sujet : ",
        //                 "attr" => [
        //                     "placeholder" => "Votre Objet",
        //                     "class" => "form-group flex-1"
        //                 ],
        //                 "row_attr" =>[
        //                     "class" => "form-group"
        //                 ]
        //             ])
        //             ->add("Country", CountryType::class, [
        //                 "label" => "Pays : ",
        //                 "attr" => [
        //                     "class" => "form-group flex-1"
        //                 ],
        //                 "row_attr" =>[
        //                     "class" => "form-group"
        //                 ]
        //             ])
        //             ->add("Message", TextareaType::class, [
        //                 "label" => "Contenu de message : ",
        //                 "attr" => [
        //                     "placeholder" => "Votre Message",
        //                     "class" => "form-group flex-1",
        //                     "rows" => 10
        //                 ],
        //                 "row_attr" =>[
        //                     "class" => "form-group"
        //                 ]
        //             ])
        //             ->add("Envoyer_message", SubmitType::class, [
        //                 "label" => "Envoyer message",
        //                 "attr" => [
        //                     "class" => "btn"
        //                 ]
        //             ])
        //             ->getForm()
        // ;
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $session = $request->getSession();

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setCreatedAt(new \DateTimeImmutable());
            $em->persist($contact);
            $em->flush();

            $contact = new Contact();
            $form = $this->createForm(ContactType::class, $contact);
            

            $session->getFlashBag()->add("message", "Message envoyé avec succès");
            $session->set('status', "success");
            // dd($contact);
        }else if($form->isSubmitted() && ! $form->isValid()){
            $session->getFlashBag()->add("message", "Merci de corriger les erreurs");
            $session->set('status', "danger");
        }

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $form->createView()
        ]);
    }
}