<?php

namespace AW\Bundle\CollectVerifiedEmailBundle;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Service
{

    private $entityManager;
    private $session;

    public function __construct(EntityManager $entityManager, Session $session)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    /**
     * @return AW\Bundle\CollectVerifiedEmailBundle\Entity\Email or null
     */
    public function getEmailFromSession()
    {
        $sessionEmail = $this->session->get('collected_email');
        if (!$sessionEmail) {
            return null;
        }

        return $this->entityManager
                        ->getRepository('AWCollectVerifiedEmailBundle:Email')
                        ->findOneByEmail($sessionEmail);
    }

}
