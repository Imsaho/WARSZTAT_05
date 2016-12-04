<?php

namespace ContactBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ContactBoxBundle\Entity\Address;
use Doctrine\Common\Collections\ArrayCollection;
use ContactBoxBundle\Entity\Email;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="ContactBoxBundle\Repository\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    
    /**
     * @ORM\OneToMany (targetEntity="Address", mappedBy="person", cascade={"remove"})
     */
    private $address;
    
    /**
     * @ORM\ManyToMany (targetEntity="PersonGroup", inversedBy="persons", cascade={"persist"})
     * @ORM\JoinTable(name="persons_groups")
     */
    private $groups;
    
    /**
     * @ORM\OneToMany (targetEntity="Email", mappedBy="person", cascade={"remove"})
     */
    private $email;
    
    /**
     * @ORM\OneToMany (targetEntity="Phone", mappedBy="person", cascade={"remove"})
     */
    private $phone;
    
    public function __construct() {
        $this->address = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->email = new ArrayCollection();
        $this->phone = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Person
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add groups
     *
     * @param \ContactBoxBundle\Entity\PersonGroup $groups
     * @return Person
     */
    public function addGroup(\ContactBoxBundle\Entity\PersonGroup $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param \ContactBoxBundle\Entity\PersonGroup $groups
     */
    public function removeGroup(\ContactBoxBundle\Entity\PersonGroup $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add email
     *
     * @param \ContactBoxBundle\Entity\Email $email
     * @return Person
     */
    public function addEmail(\ContactBoxBundle\Entity\Email $email)
    {
        $this->email[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \ContactBoxBundle\Entity\Email $email
     */
    public function removeEmail(\ContactBoxBundle\Entity\Email $email)
    {
        $this->email->removeElement($email);
    }

    /**
     * Get email
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add phone
     *
     * @param \ContactBoxBundle\Entity\Phone $phone
     * @return Person
     */
    public function addPhone(\ContactBoxBundle\Entity\Phone $phone)
    {
        $this->phone[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param \ContactBoxBundle\Entity\Phone $phone
     */
    public function removePhone(\ContactBoxBundle\Entity\Phone $phone)
    {
        $this->phone->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add address
     *
     * @param \ContactBoxBundle\Entity\Address $address
     * @return Person
     */
    public function addAddress(\ContactBoxBundle\Entity\Address $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \ContactBoxBundle\Entity\Address $address
     */
    public function removeAddress(\ContactBoxBundle\Entity\Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddress()
    {
        return $this->address;
    }
}
