<?php

namespace Application\Controller;

use Feed\Controller\FeedController;
use Feed\Form\FeedForm;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\PluginManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class IndexControllerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : IndexController
    {
        //Get Form by FormElementManager
        /** @var PluginManagerInterface $formElementManager */
        $formElementManager = $container->get('FormElementManager');
        /** @var FeedForm $form */
        $form = $formElementManager->get(FeedForm::class);

        // Get FeedController by ControllerManager
        /** @var ControllerManager $controllerManager */
        $controllerManager = $container->get('ControllerManager');
        /** @var FeedController $feedController */
        $feedController = $controllerManager->get(FeedController::class);

        return new IndexController($form, $feedController);
    }
}