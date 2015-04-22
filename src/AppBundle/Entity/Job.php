<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\JobsRepository")
 */
class Job
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="companyName", type="string", length=255)
     */
    private $companyName;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var string
     * @Assert\Url(message="Należy podać adres url do pliku logo np. http://www.twojastrona.pl/img/logo.jpg")
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;

    /**
     * @var string
     * @Assert\Url(message="Należy podać adres url np. http://www.twojastrona.pl")
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", 
     * max="25", 
     * minMessage="Minimalna ilość znaków wynosi {{ limit }}",
     * maxMessage="Maksymalna ilość znaków wynosi {{ limit }}")
     * @ORM\Column(name="position", type="string", length=255)
     */
    private $position;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="3",
     *  max="30",
     * minMessage="Minimalna ilość znaków wynosi {{ limit }}",
     * maxMessage="Maksymalna ilość znaków wynosi {{ limit }}")
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     * max="1500", 
     * maxMessage="Za dużo znaków, maksymalna ilość dla tego pola to {{ limit }}")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    private $publishedAt;
    public function __construct()
    {
        return $this->publishedAt = new \DateTime;
    }

    /**
     * @var integer
     * 
     * @ORM\Column(name="howToApply", type="smallint")
     */
    private $howToApply;

    /**
     * @var string
     * @Assert\Email(message="'{{ value }}' - nie jest prawidłowym adresem email")
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="verified", type="boolean")
     */
    private $verified = false;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="jobs")
     */
    private $user;

    /**
     * @Assert\NotNull(message="Proszę wybrać odpowiednią kategorię")
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="jobs")
     */
    private $category;

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
     * Set companyName
     *
     * @param string $companyName
     * @return Job
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string 
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Job
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Job
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Job
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Job
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set location
     *
     * @param string $location
     * @return Job
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Job
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
     * Set publishedAt
     *
     * @param \DateTime $publishedAt
     * @return Job
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Get publishedAt
     *
     * @return \DateTime 
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set howToApply
     *
     * @param integer $howToApply
     * @return Job
     */
    public function setHowToApply($howToApply)
    {
        $this->howToApply = $howToApply;

        return $this;
    }

    /**
     * Get howToApply
     *
     * @return integer 
     */
    public function getHowToApply()
    {
        return $this->howToApply;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Job
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Job
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
    {
        return $this->position;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Job
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set verified
     *
     * @param boolean $verified
     * @return Job
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean 
     */
    public function getVerified()
    {
        return $this->verified;
    }

}
