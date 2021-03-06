<?php

namespace CmsBundle\Cms\Domain\Model\User\Entity;

use albertcolom\Assert\AssertEmail;
use CmsBundle\Cms\Domain\Model\Common\Event\DomainEventPublisher;
use CmsBundle\Cms\Domain\Model\User\Event\UserWasCreated;
use CmsBundle\Cms\Domain\Model\User\ValueObject\UserIdentity;

class User
{
    /** @var UserIdentity */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var \DateTime */
    private $createdOn;

    /**
     * @param UserIdentity $id
     * @param string $name
     * @param string $email
     */
    private function __construct(UserIdentity $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->setEmail($email);
        $this->createdOn = new \DateTime();

        DomainEventPublisher::instance()->publish(
            new  UserWasCreated($id, $name, $email)
        );
    }

    /**
     * @param UserIdentity $id
     * @param string $name
     * @param string $email
     * @return User
     */
    public static function instance(UserIdentity $id, string $name, string $email): User
    {
        return new self($id, $name, $email);
    }

    /**
     * @return UserIdentity
     */
    public function id(): UserIdentity
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        AssertEmail::valid($email);
        AssertEmail::dns($email);
        AssertEmail::temporalMail($email);

        $this->email = $email;
    }

    /**
     * @return \DateTime
     */
    public function createdOn(): \DateTime
    {
        return $this->createdOn;
    }
}
