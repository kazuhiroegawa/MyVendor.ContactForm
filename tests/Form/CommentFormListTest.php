<?php

namespace MyVendor\ContactForm;

use Aura\Filter\FilterFactory;
use Aura\Html\HelperLocatorFactory;
use Aura\Input\Builder;
use BEAR\Resource\Exception\BadRequestException;
use MyVendor\ContactForm\Form\CommentForm;
use MyVendor\ContactForm\Form\ContactForm;
use MyVendor\ContactForm\Form\CommentFormList;
use Ray\WebFormModule\FormFactory;

class CommentFormListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContactForm
     */
    private $form;

    protected function setUp()
    {
        parent::setUp();
        /** @var $form ContactForm */
        $form = (new FormFactory)->newInstance(CommentForm::class);
        $this->form = new CommentFormList($form);
        $this->form->setBaseDependencies(new Builder, new FilterFactory, new HelperLocatorFactory);
        $this->form->postConstruct();
    }


    public function testString()
    {
        $html = (string)$this->form;
        $expected1 = '<input type="hidden" name="id" value="1" />';
        $expected2 = '<input type="hidden" name="id" value="2" />';
        $expected3 = '<input type="hidden" name="id" value="3" />';
        $expected4 = '<input type="hidden" name="id" value="4" />';
        $expected5 = '<input type="hidden" name="id" value="5" />';
        $this->assertContains($expected1, $html);
        $this->assertContains($expected2, $html);
        $this->assertContains($expected3, $html);
        $this->assertContains($expected4, $html);
        $this->assertContains($expected5, $html);
    }

    public function testApplyFailure()
    {
        $data = [
            'id' => 2,
            'comment' => '@@invalid'
        ];
        $success = $this->form->apply($data);
        $this->assertFalse($success);
        $html = (string)$this->form;
        // error message
        $expected = '<form method="post" action="/loop" enctype="multipart/form-data"><input type="hidden" name="id" value="2" />
<input id="comment" type="text" name="comment" />
Comment must be alphabetic only ! <input type="submit" name="submit" value="Submit" />
</form>';
        $this->assertContains($expected, $html);
        // no error message
        $expected = '<input type="hidden" name="id" value="1" />
<input id="comment" type="text" name="comment" />
<input type="submit" name="submit" value="Submit" />';
        $this->assertContains($expected, $html);
    }

    public function testApplySuccess()
    {
        $data = [
            'id' => 1,
            'comment' => 'nice'
        ];
        $success = $this->form->apply($data);
        $this->assertTrue($success);
    }

    public function testApplyNoId()
    {
        $this->setExpectedException(BadRequestException::class);
        $data = [
            'comment' => 'nice'
        ];
        $this->form->apply($data);
    }
}


/**
 * <form method="post" action="/multi" enctype="multipart/form-data"><div class="form-group"><div class="form-group"><div class="form-group"><label for="name">Name:</label>
<input id="contact[name]" type="text" name="contact[name]" size="20" maxlength="20" class="form-control" placeholder="Your Name" />
</div>
<div class="form-group"><label for="message">Message:</label>
<textarea id="contact[message]" name="contact[message]" cols="40" rows="5" class="form-control" placeholder="Message here"></textarea></div>
<input type="submit" name="submit" value="contact" />
</form><form method="post" action="/multi" enctype="multipart/form-data"><div class="form-group"><div class="form-group"><div class="form-group"><label for="name">Name:</label>
<input id="contact[name]" type="text" name="contact[name]" size="20" maxlength="20" class="form-control" placeholder="Your Name" />
</div>
<div class="form-group"><label for="message">Message:</label>
<textarea id="contact[message]" name="contact[message]" cols="40" rows="5" class="form-control" placeholder="Message here"></textarea></div>
<input type="submit" name="submit" value="contact" />
</form><form method="post" action="/multi" enctype="multipart/form-data"><div class="form-group"><div class="form-group"><div class="form-group"><label for="name">Name:</label>
<input id="contact[name]" type="text" name="contact[name]" size="20" maxlength="20" class="form-control" placeholder="Your Name" />
</div>
<div class="form-group"><label for="message">Message:</label>
<textarea id="contact[message]" name="contact[message]" cols="40" rows="5" class="form-control" placeholder="Message here"></textarea></div>
<input type="submit" name="submit" value="contact" />
</form><form method="post" action="/multi" enctype="multipart/form-data"><div class="form-group"><div class="form-group"><div class="form-group"><label for="name">Name:</label>
<input id="contact[name]" type="text" name="contact[name]" size="20" maxlength="20" class="form-control" placeholder="Your Name" />
</div>
<div class="form-group"><label for="message">Message:</label>
<textarea id="contact[message]" name="contact[message]" cols="40" rows="5" class="form-control" placeholder="Message here"></textarea></div>
<input type="submit" name="submit" value="contact" />
</form><form method="post" action="/multi" enctype="multipart/form-data"><div class="form-group"><div class="form-group"><div class="form-group"><label for="name">Name:</label>
<input id="contact[name]" type="text" name="contact[name]" size="20" maxlength="20" class="form-control" placeholder="Your Name" />
</div>
<div class="form-group"><label for="message">Message:</label>
<textarea id="contact[message]" name="contact[message]" cols="40" rows="5" class="form-control" placeholder="Message here"></textarea></div>
<input type="submit" name="submit" value="contact" />
</form>
 */