<?php

class Certificate
{
    private $expiresAt;
    private $signatory;

    public function __construct($expiresAt, $signatory)
    {
        $this->expiresAt = $expiresAt;
        $this->signatory = $signatory;
    }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getSignatory()
    {
        return $this->signatory;
    }
}

?>