<?php

namespace App\Controller;

use App\CommandBus\Command\CreateParticipantCommand;
use App\Form\CreateParticipantType;
use App\Repository\Interfaces\ParticipantRepository;
use App\View\ParticipantViewFactory;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class BoardController extends AbstractController
{
    /**
     * @Route("/", name="participant_overview")
     */
    public function overview(ParticipantRepository $participantRepository) : Response
    {
        $companies = ParticipantViewFactory::createForParticipantRows(
            $participantRepository->fetchAll()
        );

        return $this->render('Board/overview.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/add-participant", name="add_participant")
     */
    public function addParticipant(CommandBus $commandBus, Request $request) : Response
    {
        $form = $this->createForm(CreateParticipantType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('Board/add_participant.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        $command = new CreateParticipantCommand($form->getData()['email']);
        $commandBus->handle($command);

        return $this->redirectToRoute('participant_overview');
    }
}
