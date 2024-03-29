<?php

namespace AW\Bundle\CollectVerifiedEmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EmailRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EmailRepository extends EntityRepository
{

    /**
     * @param string $email
     * @return Email or null.
     */
    public function findOneByEmail($email)
    {
        return $this->findOneBy(array('email' => $email));
    }

}
