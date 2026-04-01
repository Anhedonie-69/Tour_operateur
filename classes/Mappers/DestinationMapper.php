<?php

class DestinationMapper
{
    public static function mapToObject(array $data): Destination
    {
        return new Destination(
            $data['id'],
            $data['location'],
            $data['price'],
            $data['tour_operator_id']
        );
    }
}

?>