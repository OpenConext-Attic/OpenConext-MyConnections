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
        $nameId = $this->get('nameId', NULL);
        return (!empty($nameId));
    }

    /**
     * @return mixed|null
     */
    public function getDisplayName()
    {
        $name = $this->get('displayName', NULL);
        if (NULL === $name) {
            $name = $this->get('eduPPN', NULL);
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
            $this->get('eduPPN')
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
