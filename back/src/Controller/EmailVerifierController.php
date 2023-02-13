<?php
// api/src/Controller/CreateBookPublication.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
// use Symfony\Contracts\Translation\TranslatorInterface;
// use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\EmailVerifier;

#[AsController]
class EmailVerifierController extends AbstractController
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private RequestStack $request,
        private ManagerRegistry $managerRegistry,
        // private TranslatorInterface $translator
    ) {}

    #[Route(
        name: 'verify_email',
        path: '/verify/email/{token}',
        // methods: ['POST'],
        // defaults: [
        //     '_api_resource_class' => User::class,
        //     '_api_operation_name' => '_api_/books/{id}/publication_post',
        // ],
    )]
    public function __invoke($token)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $user = $this->managerRegistry->getRepository(User::class)->findOneBy(['token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if(!$user){
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }
        
        if($user->isIsVerify()){
            return $this->json('User is already verified');
        }

        // On supprime le token
        // $user->setToken(null);
        $user->setIsVerify(true);
        $entityManager = $this->managerRegistry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('User verified');

        // On génère un message
        // $this->addFlash('message', 'Utilisateur activé avec succès');

        // On retourne à l'accueil
        // return $this->redirectToRoute('accueil');
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // // validate email confirmation link, sets User::isVerified=true and persists
        // try {
        //     $this->emailVerifier->handleEmailConfirmation($this->request->getCurrentRequest(), $this->getUser());
        // } catch (VerifyEmailExceptionInterface $exception) {
        //     // $this->addFlash('verify_email_error', $this->translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
        //     return $this->json($this->translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));
        //     // return $this->redirectToRoute('register');
        // }

        // // @TODO Change the redirect on success and handle or remove the flash message in your templates
        // // $this->addFlash('success', 'Your email address has been verified.');
        // return $this->json('verify email success');
        // // return $this->redirectToRoute('register');
    }
}