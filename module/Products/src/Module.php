<?php
namespace Products;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;


class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return [
    		'factories' => [
    			Model\ProductsTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProductsTableGateway::class);
                    return new Model\ProductsTable($tableGateway);
                },
                Model\ProductsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Products());
                    return new TableGateway('products', $dbAdapter, null, $resultSetPrototype);
                },
    		]
    	];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProductController::class => function($container) {
                    return new Controller\ProductController(
                        $container->get(Model\ProductsTable::class)
                    );
                },
            ],
        ];
    }
}