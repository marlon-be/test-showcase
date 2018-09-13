<?php

namespace App\Form;

use App\Repository\Interfaces\ParticipantRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class CreateParticipantType extends AbstractType
{
    private $participantRepository;

    public function __construct(ParticipantRepository $participantRepository)
    {
        $this->participantRepository = $participantRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->add('email', TextType::class, ['constraints' => [
            new Assert\NotBlank(),
            new Assert\Email(),
            new Assert\Callback(function ($value, ExecutionContextInterface $context) : void {
                if (!$value || !$this->participantRepository->findOneBy(['email' => $value])) {
                    return;
                }

                $context->addViolation('Email already taken');
            }),
        ]]);
    }
}
