<?php

/**
 * Description of ShowFormTest
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class ShowFormTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Event\View\Helper\ShowForm
     */
    public $helper;

    /**
     * @var string
     */
    public $basePath;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->helper = new Event\View\Helper\ShowForm();
        $this->renderer = new \Zend\View\Renderer\PhpRenderer();
        $helpers = $this->renderer->getHelperPluginManager();
        $config = new Zend\Form\View\HelperConfig();
        $config->configureServiceManager($helpers);

        $this->helper->setView($this->renderer);
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->helper);
    }

    public function testHelperSendsOutput()
    {
        $form = new \Zend\Form\Form('default');
        $output = $this->helper->__invoke($form, 'test');
        $this->assertInternalType('string', $output);
    }

    /**
     *
     */
    public function testHelperSetsActionUrl()
    {
        $form = new \Zend\Form\Form('default');
        $url = '/test-url';
        $output = $this->helper->__invoke($form, $url);
        $this->assertRegExp('/action=\"' . addcslashes($url, '/') . '\"/', $output);
        $this->assertContains('</form>', $output);
    }

    public function testHelperThrowsExceptionIfInvalidUrlIsSet()
    {

        $this->setExpectedException('InvalidArgumentException');
        $form = new \Zend\Form\Form('default');
        $url = new \Zend\Stdlib\DateTime();
        $output = $this->helper->__invoke($form, $url);
    }

    /**
     *
     */
    public function testHelperSetsFormClass()
    {
        $form = new \Zend\Form\Form('default');
        $url = '/test-url';
        $output = $this->helper->__invoke($form, $url);
        $this->assertRegExp('/class=\"form-horizontal"/', $output);

        $class = 'test';
        $output = $this->helper->__invoke($form, $url, $class);
        $this->assertRegExp('/class=\"' . addcslashes($class, '/') . '\"/', $output);
    }

    public function testHelperCreatesElementHtmlOutput()
    {
        $form = new \Zend\Form\Form('default');
        $element = new Zend\Form\Element\Text('test');
        $element->setLabel('Testlabel');
        $form->add($element);

        $submit = new \Zend\Form\Element\Submit('submit');
        $form->add($submit);

        $hidden = new Zend\Form\Element\Hidden('hidden');
        $form->add($hidden);

        $csrf = new Zend\Form\Element\Csrf('honey');
        $form->add($csrf);

        $url = '/test-url';
        $output = $this->helper->__invoke($form, $url);
        $this->assertContains('Testlabel', $output);

        $this->assertContains('<div class="form-actions">', $output);
    }

}
