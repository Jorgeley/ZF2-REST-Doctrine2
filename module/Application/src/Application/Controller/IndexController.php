<?php
/**
 * Zend Framework REST with Doctrine sample
 *
 * @link    https://github.com/Jorgeley/ZF2-REST-Doctrine2
 * @author  jorgeley@gmail.com
 */
namespace Application\Controller;

header("Access-Control-Allow-Origin: http://localhost");

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Application\Entities\Driver;

class IndexController extends AbstractRestfulController{    
    private static $em; //my entity manager property
    
    //Returning all the drivers
    public function indexAction(){
        $drivers = self::getConn()->getRepository("Application\Entities\Driver")->findAll();
        return new JsonModel($drivers);
    }
    
    //Save the new or updated driver
    public function saveAction(){        
        if ($this->getRequest()->isPost()){
            if ($this->params("id"))
                $Driver = self::getConn()->getRepository("Application\Entities\Driver")->find($this->params("id"));
            else
                $Driver = new Driver();
            $Driver->setName($this->getRequest()->getPost("name"));
            $Driver->setTeam($this->getRequest()->getPost("team"));
            self::getConn()->persist($Driver);
            self::getConn()->flush();
            return new JsonModel(array("driver"=>$Driver));
        }
    }
    
    //Return a specific Driver
    public function viewAction(){
        if ($this->params("id")){
            $driver = self::getConn()->getRepository("Application\Entities\Driver")->find($this->params("id"));
            if ($driver)
                return new JsonModel(array("driver"=>$driver));
        }            
    }
    
    //Delete a Driver
    public function delAction(){
        if ($this->params("id")){
            $driver = self::getConn()->getRepository("Application\Entities\Driver")->find($this->params("id"));
            if ($driver){
                self::getConn()->remove($driver);
                self::getConn()->flush();
                return new JsonModel(array("del"=>!$driver->getId()));
            }
        }            
    }
    
    /*
     * just getting my Entity Manager from Doctrine
     * being honest, I got it from my github and adapted: 
     * https://github.com/Jorgeley/Real-State/blob/master/imobiliaria/module/MyClasses/src/MyClasses/Conn/Conn.php
     */
    private static function getConn(){
        if (self::$em == null){
            $conn = array(
                'driverClass' 	=> 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'host'			=> 'localhost',
                'user'			=> 'root',
                'password'		=> '123456',
                'dbname'		=> 'F1'
            );
            $config = new \Doctrine\ORM\Configuration();
            $config->setProxyDir(__DIR__ . '/../Entities/Proxies');
            $config->setProxyNamespace('Application\Entities\Proxies');
            $config->setMetadataDriverImpl($config->newDefaultAnnotationDriver(array(), true));
            $eventManager = new \Doctrine\Common\EventManager();
            self::$em = EntityManager::create($conn, $config, $eventManager);
        }
        return self::$em;
    }
}