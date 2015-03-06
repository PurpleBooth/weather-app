<?php

namespace PurpleBooth\WeatherApp\Controller;

/**
 * Controller for the angularJS app
 *
 * @package PurpleBooth\WeatherApp\Controller
 */
class PostcodeWebsiteController
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * The constructor
     *
     * @param \Twig_Environment $twigEnvironment Twig to render the template
     */
    public function __construct(\Twig_Environment $twigEnvironment)
    {
        $this->twig = $twigEnvironment;
    }

    /**
     * Get the template for the AngularJS app
     *
     * @return string
     */
    public function indexAction()
    {
        return $this->twig->render('index.html.twig');
    }
}
