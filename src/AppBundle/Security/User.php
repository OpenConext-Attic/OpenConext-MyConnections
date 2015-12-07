<?php
/**
 * @file
 * Project: orcid
 * File: User.php
 */


namespace AppBundle\Security;


class User
{
    /**
     * @var string
     */
    protected $nameId;
    /**
     * @var string
     */
    protected $displayName;
    /**
     * @var string
     */
    protected $eduPPN;
    /**
     * @var string
     */
    protected $uid;
    /**
     * @var string
     */
    protected $conextId;

    /**
     * @return string
     */
    public function getNameId()
    {
        return $this->nameId;
    }

    /**
     * @param string $nameId
     */
    public function setNameId($nameId)
    {
        $this->nameId = $nameId;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getEduPPN()
    {
        return $this->eduPPN;
    }

    /**
     * @param string $eduPPN
     */
    public function setEduPPN($eduPPN)
    {
        $this->eduPPN = $eduPPN;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getConextId()
    {
        return $this->conextId;
    }

    /**
     * @param string $conextId
     */
    public function setConextId($conextId)
    {
        $this->conextId = $conextId;
    }
}