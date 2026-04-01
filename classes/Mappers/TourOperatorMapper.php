<?php

class TourOperatorMapper
{
    public static function mapToObject(array $data): TourOperator
    {
        return new TourOperator(
            $data['id'],
            $data['name'],
            $data['link']
        );
    }
}

?>