<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;



/**
 * Sequence
 *
 * @ORM\Table(name="sequence")
 * @ORM\Entity
 */
class Sequence
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=45, nullable=true)
     */
    private $description;

    /**
      * @ORM\OneToMany(targetEntity="Event", mappedBy="sequence",cascade={"ALL"}, fetch="EAGER")
      * @ORM\JoinColumn(nullable=false)
      */
     private $events;


    /**
     * constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     *
     * @return Sequence
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
     * Set description
     *
     * @param string $description
     *
     * @return Sequence
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
     * Get events
     *
     */
    public function getEvents()
    {
        return $this->events;
    }

    public function setEvents($events)
    {
      print_r($events);
      die;
       foreach ($events as $evt)
         {
             if (is_null($evt->getSequence()))
             {
                 $evt->setSequence($this);
             }
         }
        $this->events = $events;
    }

    public function __toString(){
      return (string)$this->getId();
    }

}
