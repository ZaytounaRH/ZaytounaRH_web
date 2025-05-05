<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface; // Better way to inject HttpClient

class LoginController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function home(UserRepository $userRepository): Response
    {
        return $this->render('base.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/register', name: 'app_register')]
public function register(Request $request, EntityManagerInterface $entityManager, HttpClientInterface $httpClient): Response
{
    $user = new User();
    $form = $this->createForm(RegistrationFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle reCAPTCHA
        $recaptchaResponse = $request->get('g-recaptcha-response');
        $secretKey = 'your-secret-key'; // Move this to a safer place (e.g., .env file)

        $response = $httpClient->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'query' => [
                'secret' => $secretKey,
                'response' => $recaptchaResponse,
            ],
        ]);

        $data = $response->toArray();

        if (!$data['success']) {
            $this->addFlash('error', 'reCAPTCHA verification failed. Please try again.');
            return $this->redirectToRoute('app_register');
        }

        // Set the password directly (no encoding)
        $user->setPassword($form->get('plainPassword')->getData());

        // Set default user_type if none
        if (empty($user->getUserType())) {
            $user->setUserType('EMPLOYEE');
        }

        // Save user
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Registration successful. You can now log in.');

        return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/register.html.twig', [
        'registrationForm' => $form->createView(),
    ]);
}


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // This method can be blank - Symfony handles logout automatically.
    }
}