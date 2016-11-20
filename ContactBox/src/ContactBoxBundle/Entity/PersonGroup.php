<?php

namespace ContactBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ContactBoxBundle\Entity\Person;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PersonGroup
 *
 * @ORM\Table(name="person_group")
 * @ORM\Entity(repositoryClass="ContactBoxBundle\Repository\PersonGroupRepository")
 */
class PersonGroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="group_name", type="string", length=255)
     */
    private $groupName;
    
    /**
     * @ORM\ManyToMany (targetEntity="Person", mappedBy="groups")
     */
    private $persons;
    
    public function __construct() {
        $this->persons = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set groupName
     *
     * @param string $groupName
     * @return PersonGroup
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * Get groupName
     *
     * @return string 
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * Add persons
     *
     * @param \ContactBoxBundle\Entity\Person $persons
     * @return PersonGroup
     */
    public function addPerson(\ContactBoxBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \ContactBoxBundle\Entity\Person $persons
     */
    public function removePerson(\ContactBoxBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }
    
    public function __toString() {
        return "$this->groupName";
    }
}
