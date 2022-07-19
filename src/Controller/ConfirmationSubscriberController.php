<?php
namespace App\Controller;

use App\Entity\Subscriber;
use App\Repository\SubscriberRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ConfirmationSubscriberController extends AbstractController
{
    #[Route('/confirmation/subscriber/{id}', name:'confirmation_subscriber')]
    public function __invoke(Subscriber $subscriber, SubscriberRepository $subscriberRepository)
    {
        $subscriber->setIsVerified(true);
        $subscriberRepository->add($subscriber, true);

        return $this->redirect('https://rherault.fr/confirmation');
    }
}
