<?php

namespace AW\Bundle\CollectVerifiedEmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AW\Bundle\CollectVerifiedEmailBundle\Entity\Email
 *
 * @ORM\Table(name="awcollectverifiedemail_email")
 * @ORM\Entity(repositoryClass="AW\Bundle\CollectVerifiedEmailBundle\Entity\EmailRepository")
 */
class Email
{

    /**
     * @var integer $id
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $email
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var boolean $verified
     * @ORM\Column(name="verified", type="boolean")
     */
    private $verified;

    /**
     * @var string $verifyToken
     * @ORM\Column(name="verify_token", type="string", length=255)
     */
    private $verifyToken;

    /**
     * @var string $continueUrl
     * @ORM\Column(name="continue_url", type="string", length=255)
     */
    private $continueUrl;

    public function __construct($email, $continueUrl)
    {
        $this->email = $email;
        $this->verified = false;
        $this->verifyToken = mt_srand() . sha1($email);
        $this->continueUrl = $continueUrl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getVerified()
    {
        return $this->verified;
    }

    public function getVerifyToken()
    {
        return $this->verifyToken;
    }

    public function isVerifyTokenCorrect($token)
    {
        return $token === $this->verifyToken;
    }

    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    public function getContinueUrl()
    {
        return $this->continueUrl;
    }
}
