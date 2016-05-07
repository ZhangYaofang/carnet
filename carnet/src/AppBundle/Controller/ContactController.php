<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Config\Definition\IntegerNode;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactController extends Controller
{
	/**
	 * @Route("/liste/", name="liste")
	 */
	public function listeAction()   //Afficher les contacts
	{
		$contacts = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->findAll();
	
		return $this->render('contact/liste.html.twig', array(
				'contacts' => $contacts));
	}

	/**
	 * @Route("/contact/{id}", name="contact_show", requirements={
	 *              "id": "\d+"
	 *     })
	 */
	public function showAction($id)   //Afficher les informations du contact
	{
		$contact = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->find($id);
		if (!$contact) {
			throw $this->createNotFoundException('The contact does not exist');
		}	
		return $this->render('contact/contact_show.html.twig', array('contact' => $contact));
	}  

	/**
	 * @Route("/admin/contact/new", name = "add_contact")
	 */
	public function newAction(Request $request)   //Ajouter un nouveau contact
	{
		$contact = new Contact();

		$form = $this->createFormBuilder($contact)
             		 //->add('id', IntegerType::class)
             		 ->add('nom', TextType::class)
             		 ->add('prenom', TextType::class)
             		 ->add('email', TextType::class)
             		 ->add('telephone', TextType::class)
			 ->add('siteweb', TextType::class)
			 ->add('adresse', TextType::class)
               		 ->add('save', SubmitType::class, array('label' => 'Create contact'))
             		 ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($contact);
        		$em->flush();
		
				return $this->redirectToRoute('liste', array( 'id' => $contact->getId()));
		}
		
		return $this->render('admin/contact/new.html.twig', array(
				'form' => $form->createView()));
	}

	/**
	 * @Route("/admin/contact/{id}/email", name="email", requirements={
	 *              "id": "\d+"
	 *        })
	 */	
	public function emailAction($id, Request $request)   //Modifier l'e-mail
	{
		$contact = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->find($id);

		$form = $this->createFormBuilder($contact)
			->add('email', TextType::class)
			->add('save', SubmitType::class, array('label' => 'Modifier e-mail'))
             		 ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($contact);
        		$em->flush();
		
			return $this->render('contact/contact_show.html.twig', array('contact' => $contact));
		}
		
		return $this->render('admin/contact/email.html.twig', array(
				'form' => $form->createView()));
	}		

	/**
	 * @Route("/admin/contact/{id}/adresse", name="adresse", requirements={
	 *              "id": "\d+"
	 *        })
	 */	
	public function adresseAction($id, Request $request)    // Modifier l'adresse
	{
		$contact = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->find($id);

		$form = $this->createFormBuilder($contact)
			->add('adresse', TextType::class)
			->add('save', SubmitType::class, array('label' => 'Modifier adresse'))
             		 ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($contact);
        		$em->flush();
		
			return $this->render('contact/contact_show.html.twig', array('contact' => $contact));
		}
		
		return $this->render('admin/contact/email.html.twig', array(
				'form' => $form->createView()));
	}

	/**
	 * @Route("/admin/contact/{id}/tel", name="tel", requirements={
	 *              "id": "\d+"
	 *        })
	 */	
	public function telAction($id, Request $request)     // Modifier le numéro de téléphone
	{
		$contact = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->find($id);

		$form = $this->createFormBuilder($contact)
			->add('telephone', TextType::class)
			->add('save', SubmitType::class, array('label' => 'Modifier e-mail'))
             		 ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($contact);
        		$em->flush();
		
			return $this->render('contact/contact_show.html.twig', array('contact' => $contact));
		}
		
		return $this->render('admin/contact/email.html.twig', array(
				'form' => $form->createView()));
	}

	/**
	 * @Route("/admin/contact/{id}/site", name="site", requirements={
	 *              "id": "\d+"
	 *        })
	 */	
	public function siteAction($id, Request $request)    // Modifier le siteWeb
	{
		$contact = $this->getDoctrine()
		->getRepository('AppBundle:Contact')
		->find($id);

		$form = $this->createFormBuilder($contact)
			->add('siteweb', TextType::class)
			->add('save', SubmitType::class, array('label' => 'Modifier e-mail'))
             		 ->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
        		$em = $this->getDoctrine()->getManager();
        		$em->persist($contact);
        		$em->flush();
		
			return $this->render('contact/contact_show.html.twig', array('contact' => $contact));
			
		}
		
		return $this->render('admin/contact/email.html.twig', array(
				'form' => $form->createView()));
	}						




	/**
	 * @Route("/admin/contact/{id}/remove", name="contact_remove", requirements={
	 *              "id": "\d+"
	 *        })
	 */
	public function deleteAction($id)
	{
		$contacts = $this->getDoctrine()
			->getRepository('AppBundle:Contact')
			->findAll();
		
		$contact = $this->getDoctrine()
			->getRepository('AppBundle:Contact')
			->find($id);

		$em = $this->getDoctrine()->getManager();
		$em->remove($contact);
		$em->flush();

		return $this->redirectToRoute('liste', array( 'id' => $contact->getId()));
		
	}
	
}
