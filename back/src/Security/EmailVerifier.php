<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Mailer\MailerInterface;
// use Symfony\Component\Routing\Generator\UrlGenerator;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class EmailVerifier
{
    public function __construct(
        private VerifyEmailHelperInterface $helper,
        private MailerInterface $mailer,
        private EntityManagerInterface $manager,
        private UrlGeneratorInterface $urlGenerator,
    )
    {}

    // public function sendEmailConfirmation(string $verifyEmailRouteName, User $user, TemplatedEmail $email): void
    // public function sendEmailConfirmation(string $verifyEmailRouteName, User $user, Email $email): void
    public function sendEmailConfirmation(User $user, Email $email)
    {
        $userEmail = $user->getEmail();
        $userId = $user->getId();
        $userToken = $user->getToken();

        // $signatureComponents = $this->verifyEmailHelper->generateSignature(
        //     $verifyEmailRouteName,
        //     $userId,
        //     $userEmail
        // );
        // $context = $email->getContext();array

        $url = $this->urlGenerator->generate('verify_email', [
            // 'id' => $user->getId(),
            'token' => $userToken,
        ], 0);
        
        // $context = array();
        // $context['signedUrl'] = $signatureComponents->getSignedUrl();
        // $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        // $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();


        
        $emailContent = "<h1>Bonjour ****, veuillez confirmer votre e-mail</h1><p>
        Veuillez confirmer votre adresse e-mail en cliquant sur le lien suivant : <br><br>";
        $emailContent .="<a href=". $url .">Confirmer mon e-mail</a>.";
        // $emailContent .= "Ce lien expire dans ". $context['expiresAtMessageData'].".";
        $email->html($emailContent);
        // $email->context($context);

        $this->mailer->send($email);
        $res = array();
        $res['url'] = $url;
        $res['res'] = true;
        return json_encode($res);
    }

    // /**
    //  * @throws VerifyEmailExceptionInterface
    //  */
    // public function handleEmailConfirmation(Request $request, User $user): void
    // {
    //     $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

    //     $user->setIsVerify(true);

    //     $this->entityManager->persist($user);
    //     $this->entityManager->flush();
    // }
}