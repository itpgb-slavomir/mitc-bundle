<?php

namespace SK\ITCBundle\Service\Google;

use SK\ITCBundle\Service\AbstractService;
use Psr\Log\LoggerInterface;

class Drive extends AbstractService
{
    /**
     *
     * @var string
     */
    protected $token;

    /**
     *
     * @param LoggerInterface $logger
     * @param string $token
     */
    public function __construct(LoggerInterface $logger, $token)
    {
        parent::__construct ( $logger );

        $this->setToken ( $token );
    }

    /**
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     *
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
}