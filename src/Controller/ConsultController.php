<?php

namespace App\Controller;

use App\Repository\ConsultRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ConsultController extends AbstractController
{
    #[Route('/api/consults/today', name: 'consults_today', methods: ['GET'])]
    #[IsGranted('ROLE_VETERINARIAN')]
    public function getTodayConsults(ConsultRepository $repository): JsonResponse
    {
        $veterinarian = $this->getUser();
        $consults = $repository->findConsultationsToday($veterinarian);
        return $this->json($consults, 200, [], ['groups' => 'read']);
    }
    #[Route('/api/consults/{id}/assign', name: 'assign_consult', methods: ['PATCH'])]
#[IsGranted('ROLE_VETERINARIAN')]
public function assignConsult(int $id, ConsultRepository $repository, EntityManagerInterface $entityManager): JsonResponse
{
    $consult = $repository->find($id);

    if (!$consult) {
        return $this->json(['error' => 'Consultation non trouvée'], 404);
    }

    if ($consult->getVeterinary()) {
        return $this->json(['error' => 'Déjà assigné à un vétérinaire'], 400);
    }

    $consult->assignVeterinary($this->getUser());

    // Utiliser l'EntityManager pour sauvegarder
    $entityManager->persist($consult);
    $entityManager->flush();

    return $this->json(['success' => 'Rendez-vous assigné'], 200);
}

    #[Route('/api/consults', name: 'consults_by_period', methods: ['GET'])]
    #[IsGranted('ROLE_DIRECTOR')]
    public function getConsultsByPeriod(ConsultRepository $repository, Request $request): JsonResponse
    {
        $startDate = new \DateTime($request->query->get('startDate'));
        $endDate = new \DateTime($request->query->get('endDate'));

        $consults = $repository->findConsultationsBetweenDates($startDate, $endDate);

        return $this->json($consults, 200, [], ['groups' => 'read']);
    }

    #[Route('/api/consults/{id}/status', name: 'update_consult_status', methods: ['PATCH'])]
    #[IsGranted('ROLE_VETERINARIAN')]
    public function updateConsultStatus(int $id, Request $request, ConsultRepository $repository, EntityManagerInterface $entityManager): JsonResponse
    {
        $consult = $repository->find($id);

        if (!$consult) {
            return $this->json(['error' => 'Consultation non trouvée'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $newStatus = $data['status'] ?? null;

        try {
            $consult->setStatus($newStatus);
        } catch (\InvalidArgumentException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }

        $entityManager->flush();

        return $this->json(['success' => 'Statut mis à jour'], 200);
    }



}
