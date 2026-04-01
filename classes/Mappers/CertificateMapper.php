<?php

class CertificateMapper
{
    public static function mapToObject(array $data): Certificate
    {
        return new Certificate(
            $data['expires_at'],
            $data['signatory']
        );
    }
}

?>