<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginFormAuthenticator extends AbstractAuthenticator
{
    private UrlGeneratorInterface $urlGenerator;
    private CsrfTokenManagerInterface $csrfTokenManager;

    public function __construct(UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function supports(Request $request): bool
    {
        return $request->isMethod('POST') && $request->request->has('_username') && $request->request->has('_password');
    }

    public function authenticate(Request $request): Passport
{
    $email = $request->request->get('_username');
    $password = $request->request->get('_password');

    return new Passport(
        new UserBadge($email),
        new CustomCredentials(
            function ($credentials, User $user) {
                return $credentials === $user->getPassword();
            },
            $password
        )
    );
}

public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?RedirectResponse
{
    $user = $token->getUser(); // Get the authenticated user

    if ($user instanceof \App\Entity\User) {
        $session = $request->getSession();
        $session->set('user_data', [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'address' => $user->getAddress(),
            'numTel' => $user->getNumTel(),
            'gender' => $user->getGender(),
            'dateDeNaissance' => $user->getDateDeNaissance()->format('Y-m-d'),
            'userType' => $user->getUserType(),
        ]);
    }

    $roles = $token->getRoleNames();

    if (in_array('ROLE_RH', $roles, true)) {
        return new RedirectResponse($this->urlGenerator->generate('admin_dashboard'));
    } elseif (in_array('ROLE_EMPLOYEE', $roles, true)) {
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    } elseif (in_array('ROLE_CANDIDAT', $roles, true)) {
        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    return new RedirectResponse($this->urlGenerator->generate('app_home'));
}



    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?RedirectResponse
    {
        dd('Login failed: ' . $exception->getMessage());
        return new RedirectResponse($this->urlGenerator->generate('app_login'));
    }
}
