<?php

namespace App\Form;

use App\Entity\Application;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ApplicationFormType extends AbstractType
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'constraints' => $this->getConstraintsByName()
            ])
            ->add('lastname', TextType::class, [
                'constraints' => $this->getConstraintsByName()
            ])
            ->add('email', EmailType::class, [
                'constraints' => $this->getConstraintsEmail()
            ])
            ->add('paragon', TextType::class, [
                'constraints' => $this->getConstraintsText()
            ])
            ->add('paragon_repeat', TextType::class, [
                'mapped' => false,
                'constraints' => $this->getContraintsParagon()
            ])
            ->add('product', TextType::class, [
                'constraints' => $this->getConstraintsText()
            ])
            ->add('phone', TextType::class, [
                'constraints' => $this->getConstraintsPhone()
            ])
            ->add('shop', EntityType::class, $this->getOptionsBySelect('App\Entity\Shop'))
            ->add('category', EntityType::class, $this->getOptionsBySelect('App\Entity\Category'))
            ->add('from_where', EntityType::class, $this->getOptionsBySelect('App\Entity\Where'))
            ->add('birth', BirthdayType::class, $this->getOptionsBirthDay())
            ->add('img_receipt', FileType::class, $this->getOptionsFile())
            ->add('legal_a', CheckboxType::class, [
                'label' => 'Akceptuję regulamin.',
                'required' => true,
                'constraints' => $this->getConstraintsLegal()
            ])
            ->add('legal_b', CheckboxType::class, [
                'label' => 'Wyrażam zgodę na przetwarzanie moich danych osobowych w celach marketingowych i handlowych przez Spectrum Brands Poland Sp. z o.o. z siedzibą w Warszawie, ul.Bitwy Warszawskiej 1920r 7a, 02-366 Warszawa zgodnie z ustawą z dnia 29 sierpnia 1997 o ochronie danych osobowych (Dz. U. z 2002r. nr 101, poz. 926 z późn. zm.)',
                'required' => true,
                'constraints' => $this->getConstraintsLegal()
            ])
            ->add('legal_c', CheckboxType::class, [
                'label' => 'Wyrażam zgodę na otrzymywanie od Spectrum Brands Poland Sp. z o.o. z siedzibą w Warszawie, ul.Bitwy Warszawskiej 1920r 7a, 02-366 Warszawa , w formie e-maila, informacji handlowej w rozumieniu ustawy z dnia 18 lipca 2002 r. o świadczeniu usług drogą elektroniczną (Dz. U. z 2002r. nr 144, 1204 z późn. Zm.)',
                'required' => true,
                'constraints' => $this->getConstraintsLegal()
            ])
            ->add('legal_d', CheckboxType::class, [
                'label' => 'Przyjmuje do wiadomości, że podanie danych osobowych jest dobrowolne, lecz konieczne dla uczestniczenia w promocji oraz, że przysługuje mi prawo dostępu do treści moich danych oraz ich poprawiania.',
                'required' => false
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     * @return void
     */
    public function validateEmailUnique($value, ExecutionContextInterface $context): void
    {
        $row = $this->manager->getRepository(Application::class)->findOneBy(['email' => $value]);

        if ($row !== null) {
            $context->buildViolation('Ten adres email został już wykorzystany.')
                ->atPath('email')
                ->addViolation();
        }
    }

    /**
     * @param $value
     * @param ExecutionContextInterface $context
     * @return void
     */
    public function validateParagonsMatch($value, ExecutionContextInterface $context): void
    {
        $formData = $context->getRoot()->getData();
        $paragonValue = $formData->getParagon();

        if ($paragonValue !== $value) {
            $context
                ->buildViolation('Pola "paragon" i "_paragon" muszą mieć taką samą wartość.')
                ->atPath('_paragon')
                ->addViolation();
        }
    }

    /**
     * @return array
     */
    public function getOptionsBirthDay(): array
    {
        return [
            'widget' => 'single_text',
            'format' => 'dd-MM-yyyy',
            'html5' => false,
            'attr' => [
                'class' => 'datapicker',
                'data-beatpicker' => true,
                'data-beatpicker-id' => 'myDatePicker',
                'data-beatpicker-format' => "['DD','MM','YYYY'],separator:'-'",
                'data-beatpicker-extra' => 'customOptions'
            ],
        ];
    }

    /**
     * @return string[]
     */
    public function getOptionsBySelect(string $class): array
    {
        return [
            'class' => $class,
            'choice_label' => 'name',
            'placeholder' => '--- wybierz ---',
        ];
    }

    /**
     * @return array
     */
    public function getOptionsFile(): array
    {
        return [
            'required' => true,
            'mapped' => false,
            'attr' => [
                'accept' => '.jpg,.png,.webp',
                'maxFileSize' => '4M',
                'class' => 'upload-file',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getConstraintsByName(): array
    {
        return [
            new NotBlank([
                'message' => 'Pole nie może być puste.'
            ]),
            new Length([
                'min' => 3,
                'max' => 128,
                'minMessage' => 'Pole musi zawierać co najmniej {{ limit }} znaki.',
                'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
            ]),
            new Regex([
                'pattern' => '/^[a-zA-Z\s\-]+$/',
                'message' => 'Pole powinno zawierać tylko litery, spację lub znak "-"',
            ]),
        ];
    }

    /**
     * @return array
     */
    public function getConstraintsEmail(): array
    {
        return [
            new NotBlank([
                'message' => 'Pole nie może być puste.'
            ]),
            new Length([
                'max' => 255,
                'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
            ]),
            new Email([
                'message' => 'Wpisz poprawny adres email.'
            ]),
            new Callback([
                'callback' => [$this, 'validateEmailUnique'],
            ])
        ];
    }

    /**
     * @return array
     */
    public function getConstraintsText(): array
    {
        return [
            new NotBlank([
                'message' => 'Pole nie może być puste.'
            ]),
            new Length([
                'max' => 255,
                'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
            ]),
        ];
    }

    /**
     * @return IsTrue[]
     */
    public function getConstraintsLegal(): array
    {
        return [
            new IsTrue([
                'message' => 'Musisz zaakceptować warunek.',
            ]),
        ];
    }

    /**
     * @return array
     */
    public function getConstraintsPhone(): array
    {
        return [
            new NotBlank([
                'message' => 'Pole nie może być puste.',
            ]),
            new Length([
                'min' => 9,
                'max' => 9,
                'exactMessage' => 'Numer telefonu powinien składać się z {{ limit }} cyfr.',
            ]),
            new Regex([
                'pattern' => '/^[0-9]*$/',
                'message' => 'Numer telefonu powinien składać się tylko z cyfr.',
            ]),
        ];
    }

    /**
     * @return array
     */
    public function getContraintsParagon(): array
    {
        return [
            new NotBlank([
                'message' => 'Pole nie może być puste.'
            ]),
            new Length([
                'max' => 255,
                'maxMessage' => 'Pole może zawierać maksymalnie {{ limit }} znaków.',
            ]),
            new Callback([$this, 'validateParagonsMatch']),
        ];
    }

}
