<?php

namespace MyVendor\ContactForm\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class MinForm extends AbstractForm
{
    // use SetAntiCsrfTrait;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('name')
            ->setAttribs([
                'id' => 'name',
                'name' => 'name',
                'size' => 20,
                'maxlength' => 20,
                'class' => 'form-control',
                'placeholder' => 'Your Name'
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => 'Submit'
            ]);
        $this->filter->validate('name')->isNot('blank');
        $this->filter->validate('name')->is('alnum');
        $this->filter->useFieldMessage('name', 'Name must be alphabetic only !!.');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/min'
        ]);
        // name
        /** @var $tag Tag */
        $tag  = $this->helper->get('tag');
        $form .= $tag('div', ['class' => 'form-group']);
        $form .= $this->helper->tag('div', ['class' => 'form-group']);
        $form .= $this->helper->tag('label', ['for' => 'name']);
        $form .= 'Name:';
        $form .= $this->helper->tag('/label') . PHP_EOL;
        $form .= $this->input('name');
        $form .= $this->error('name');
        $form .= $this->helper->tag('/div') . PHP_EOL;
        // submit
        $form .= $this->input('submit');
        $form .= $this->helper->tag('/form');

        return $form;
    }
}
