Getting started with SMSBundle
=============

## Prerequisites

This version of the bundle requires Symfony 2.1+ and Doctrine ORM 2.2+

## Installation

### Step 1: Download KarserSMSBundle using composer

Add KarserSMSBundle in your composer.json:

```js
{
    "require": {
        "karser/sms-bundle": "dev-master",
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php ./composer.phar update
```

Composer will install the bundle to your project's `vendor/karser` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Karser\SMSBundle\KarserSMSBundle(),
    );
}
```

### Step 3: Configure the KarserSMSBundle

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
karser_sms:
    sms_task_class: Acme\SMSBundle\Entity\SmsTask
    default_handler: karser.handler.main_sms #or karser.handler.sms_vesti
```

Update your schema:
```
app/console doctrine:schema:update --force
```
### Step 4: Implement the sms_task entity

``` php
<?php
namespace Your\Module\Entity;

use Karser\SMSBundle\Entity\SmsTask as BaseClass;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class SmsTask extends BaseClass
{
    /**
     * @ORM\Column(type="string", length=20)
     *
     * @var string
     */
    protected $ipAddress;

    /**
     * @ORM\Column(type="string", length=50)
     *
     * @var string
     */
    protected $sessionId;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     *
     * @var int
     */
    protected $userId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $this->createdAt = new \DateTime();
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SmsTask
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
```

### Step 5: Available backends

- [MainSMS](http://mainsms.ru/): [KarserMainSMSBundle](https://github.com/karser/MainSMSBundle)
- [SMSVesti](http://smsvesti.ru/): [KarserSMSVestiBundle](https://github.com/karser/SMSVestiBundle)


### Usage Steps
``` php
$task = new \Your\Module\Entity\SmsTask();
$task->setPhoneNumber('+799999999999');
$task->setMessage('ni hao');
$task->setSender('your_friend');

$handler = $container->get('karser.sms.manager')->getDefaultHandler();
$msg_id = $handler->send($task);
$status = $handler->checkStatus($task->getMessageId());
if ($status === SMSTaskInterface::STATUS_PROCESSING) {
    //is sent
}
```
