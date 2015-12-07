<?php

namespace Education\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\I18n\Translator\TranslatorInterface as Translator;

class Bulk extends Form implements InputFilterProviderInterface
{

    public function __construct(Translator $translator, Fieldset\Exam $exam)
    {
        parent::__construct();

        $this->add([
            'name' => 'exams',
            'type' => 'Collection',
            'options' => [
                'count' => 2,
                'allow_add' => true,
                'allow_remove' => true,
                'target_element' => $exam
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit'
        ]);

        $this->get('submit')->setLabel($translator->translate('Finalize exam uploads'));
    }

    public function getInputFilterSpecification()
    {
        return [];
    }

}