<?php
namespace Karser\SMSBundle\Entity;

interface HlrInterface
{
    /**
     * @return string
     */
    public function getDef();

    /**
     * @return string
     */
    public function getNumberFrom();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getOpsos();

    /**
     * @return string
     */
    public function getRegion();

    /**
     * @return string
     */
    public function getNumberTo();
} 