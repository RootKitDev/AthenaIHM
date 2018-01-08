<?php
namespace Athena\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Athena\UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SecurityController extends Controller {

	public function loginAction(Request $request) {
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			
			return $this->redirectToRoute('athena_core');
		}

		$authenticationUtils = $this->get('security.authentication_utils');

		return $this->render('AthenaUserBundle:Security:login.html.twig', array(
			'last_username' => $authenticationUtils->getLastUsername(),
			'error' => $authenticationUtils->getLastAuthenticationError(),
		));
	}
}
?>