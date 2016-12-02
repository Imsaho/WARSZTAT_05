<?php

namespace ContactBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * InfoType
 *
 * @ORM\Table(name="info_type")
 * @ORM\Entity(repositoryClass="ContactBoxBundle\Repository\InfoTypeRepository")
 */
class InfoType
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
     * @ORM\Column(name="name", type="string", length=12, unique=true)
     */
    private $name;
    
    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="addressType")
     */
    private $addresses;
    
    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="emailType")
     */
    private $emails;
    
    /**
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="phoneType")
     */
    private $phones;
    
    
    public function __construct() {
        $this->addresses = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return InfoType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add addresses
     *
     * @param \ContactBoxBundle\Entity\Address $addresses
     * @return InfoType
     */
    public function addAddress(\ContactBoxBundle\Entity\Address $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \ContactBoxBundle\Entity\Address $addresses
     */
    public function removeAddress(\ContactBoxBundle\Entity\Address $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add emails
     *
     * @param \ContactBoxBundle\Entity\Email $emails
     * @return InfoType
     */
    public function addEmail(\ContactBoxBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param \ContactBoxBundle\Entity\Email $emails
     */
    public function removeEmail(\ContactBoxBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add phones
     *
     * @param \ContactBoxBundle\Entity\Phone $phones
     * @return InfoType
     */
    public function addPhone(\ContactBoxBundle\Entity\Phone $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \ContactBoxBundle\Entity\Phone $phones
     */
    public function removePhone(\ContactBoxBundle\Entity\Phone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhones()
    {
        return $this->phones;
    }
    
    public function __toString() {
        return (string) $this->name;
    }
}
