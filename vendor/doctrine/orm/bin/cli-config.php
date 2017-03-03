<?php
require_once '../../common/lib/Doctrine/Common/ClassLoader.php';
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine/ORM', realpath(__DIR__ . '/../../lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine/DBAL', realpath(__DIR__ . '/../../lib/vendor/doctrine-dbal/lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine/Common', realpath(__DIR__ . '/../../lib/vendor/doctrine-common/lib'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', realpath(__DIR__ . '/../../lib/vendor'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__.'/../../../../module/Application/src/Application/Entities');
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__.'/../../../../module/Application/src/Application/Entities/Proxies');
$classLoader->register();
$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/../../../../module/Application/src/Application/Entities"));
$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(__DIR__ . '/../../module/Application/src/Application/Entities/Proxies');
$config->setProxyNamespace('Application/Entities/Proxies');
$connectionOptions = array(
	'driverClass' 	=> 'Doctrine\DBAL\Driver\PDOMySql\Driver',
	'host'        	=> 'localhost',
	'user'        	=> 'root',
	'password'    	=> '123456',
	'dbname'    	=> 'F1',
);
$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
$helpers = new Symfony\Component\Console\Helper\HelperSet(array(
'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

