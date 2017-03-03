<?php
namespace Application\Entities;

/**
 * @Entity
 */
class Driver implements \JsonSerializable{
    
    /** @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO") */
    private $id;
    
    /** @Column(type="string", length=100) */
    private $name;

    /** @Column(type="string", length=100) */
    private $team;
    
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getTeam() {
        return $this->team;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setTeam($team) {
        $this->team = $team;
    }
    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(){
        return array(
                "id"    =>  $this->getId(),
                "name"  =>  $this->getName(),
                "team"  =>  $this->getTeam()
        );
    }

    
}