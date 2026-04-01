<?php

class CertificateRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCertificateByTourOperatorId($id)
    {
        $request = $this->db->prepare('
            SELECT * FROM certificate
            WHERE tour_operator_id = ?
        ');
        $request->execute([$id]);
        $result = $request->fetch();

        $certificate = CertificateMapper::mapToObject($result);

        return $certificate;
    }
}

?>