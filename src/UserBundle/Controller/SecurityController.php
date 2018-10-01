<?php


namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller{

    public function logoutAction(){
        throw new \RuntimeException('This should never be called directory.');
    }

    public function registerAction(Request $request){
        $user = new User();
        $form = $this->createUserRegistrationForm($user);

        return $this->render('UserBundle:Page:register.html.twig', [
            'registration_form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function handleFormSubmissionAction(Request $request){
        $user = new User();
        $form = $this->createUserRegistrationForm($user);
        $form->handleRequest($request);
        if(! $form->isSubmitted() || ! $form->isValid()){
            return $this->render('UserBundle:Page:register.html.twig', [
                'registration_form' => $form->createView()
            ]);
        }
        $passwordEncoder = $this->get('security.password_encoder');
        $password = $passwordEncoder->encodePassword(
            $user,
            $user->getPassword());
        $user->setPassword($password);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $token = new UsernamePasswordToken(
            $user,
            $password,
            'main',
            $user->getRoles()
        );
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));

        $this->addFlash('success', 'Вы успешно зарегистрировались!');
        return $this->redirectToRoute('page_list');
    }

    /**
     * @param $user
     * @return \Symfony\Component\Form\Form
     */
    private function createUserRegistrationForm($user)
    {
        return $this->createForm(new UserType(), $user, [
            'action' => $this->generateUrl('handle_registration_form_submission')
        ]);
    }

} 