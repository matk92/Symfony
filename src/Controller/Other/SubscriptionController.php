<?php

declare(strict_types=1);

namespace App\Controller\Other;

use App\Repository\SubscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route(path: '/subscriptions', name: 'subscriptions')]
    public function show(
        SubscriptionRepository $subscriptionRepository
    ): Response
    {
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('other/abonnements.html.twig', [
            'subscriptions' => $subscriptions,
        ]);
    }
}