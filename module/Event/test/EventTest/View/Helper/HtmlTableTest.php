<?php

namespace EventTest\View\Helper;

/**
 * Description of ShowFormTest
 *
 * @author Kevin Purrmann <k.purrmann@familie-redlich.de>
 */
class HtmlTableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Event\View\Helper\HtmlTable
     */
    public $helper;

    /**
     * @var string
     */
    public $basePath;

    /**
     *
     * @var \Zend\View\Renderer\PhpRenderer
     */
    private $renderer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->helper = new \Event\View\Helper\HtmlTable();
        $this->renderer = new \Zend\View\Renderer\PhpRenderer();
        $helpers = $this->renderer->getHelperPluginManager();
        $serviceManager = \EventTest\Bootstrap::getServiceManager();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = \Zend\Mvc\Router\Http\TreeRouteStack::factory($routerConfig);
        $urlHelper = $helpers->get('url');
        $urlHelper->setRouter($router);
        $config = new \Zend\Form\View\HelperConfig();
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
        $data = array();
        $output = $this->helper->__invoke($data);
        $this->assertInternalType('string', $output);
        $this->assertContains('Keine Daten gefunden', $output);
    }

    public function testHelperSendsOutputOnArray()
    {
        $data = array(
           array('1', 2, 'Extra')
        );
        $output = $this->helper->__invoke($data);
        $this->assertInternalType('string', $output);
        $this->assertContains('Extra', $output);
    }

    public function testHelperSendsOutputOnEventObject()
    {
        $event = new \Event\Entity\Event();
        $event->setId(1);
        $event->setTitle('Extra');
        $data = array(
           $event
        );

        $output = $this->helper->__invoke($data);
        $this->assertInternalType('string', $output);
        $this->assertContains('Extra', $output);
    }

}
