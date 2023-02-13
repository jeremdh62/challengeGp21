<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use App\Security\EmailVerifier;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[AsController]
class RegisterController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $passwordHasher,
        private EmailVerifier $emailVerifie,
        // private UserAuthenticatorInterface $userAuthenticator,
    ) {}

    public function __invoke()
    {
        $email = json_decode($this->requestStack->getCurrentRequest()->getContent())->email;        
        $username = json_decode($this->requestStack->getCurrentRequest()->getContent())->username;        
        if ($this->managerRegistry->getRepository(User::class)->findOneBy(['email' => $email, 'username' => $username])) {
            throw $this->createNotFoundException();
        }
        
        $user = (new User())
        ->setEmail($email)
        ->setUsername($username)
        ;
        
        $plainPwd = json_decode($this->requestStack->getCurrentRequest()->getContent())->password;        
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPwd
        );
        $user->setPassword($hashedPassword);
        $user->setToken(bin2hex(random_bytes(32)));
        $user->eraseCredentials();
        $this->managerRegistry->getManager()->persist($user);
        $this->managerRegistry->getManager()->flush();
        
        $emailResponse = $this->emailVerifie->sendEmailConfirmation(
            // 'verify_email',
            $user,
            // (new TemplatedEmail())
            (new Email())
                // ->from(new Address('admin@festnib.com', 'festinb'))
                ->from(new Address('from@example.com', 'Mailtrap'))
                ->to('to@example.com')
                ->subject('Please Confirm your Email')
                ->html("<h1>Bonjour, veuillez confirmer votre e-mail</h1>")
                // ->htmlTemplate('front/registration/confirmation_email.html.twig')
        );
        // do anything else you need here, like send an email

        // return $this->userAuthenticator->authenticateUser(
        //     $user,
        //     $authenticator,
        //     $this->requestStack->getCurrentRequest()
        // );

        // $email = (new Email())
        //     ->from('moufid.moutarou.pro@gmail.com')
        //     ->to('moufid.moutarou.pro@gmail.com')
        //     ->subject('Bienvenue')
        //     ->text('Bienvenue Sur ...')
        //     ->html(`<p> Bienvenue chez ... </p>{$username}`);
        // $this->mailer->send($email);

        return $this->json('User registered. Check your mail for validation('.$emailResponse.').');
    }
}