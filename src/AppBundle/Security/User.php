<?php
/**
 * @file
 * Project: orcid
 * File: User.php
 */

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

class User extends NamespacedAttributeBag
{
    /**
     * Authenticated session?
     * @return bool
     */
    public function isLoggedIn()
    {
        $nameId = $this->get('nameId', null);
        return (!empty($nameId));
    }

    /**
     * @return mixed|null
     */
    public function getDisplayName()
    {
        $name = $this->get('displayName', null);
        if (null === $name) {
            $name = $this->getUsername();
        }
        return $name;
    }

    /**
     * @return bool|string
     */
    public function getUid()
    {
        return hash(
            'sha512',
            $this->getUsername()
        );
    }

    /**
     * @return mixed|null
     */
    public function getUsername()
    {
        return $this->get('eduPPN');
    }
}
