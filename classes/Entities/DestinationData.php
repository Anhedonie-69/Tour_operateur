<?php

class DestinationData
{
    public static function getAll()
    {
        return [
            [
                'name' => 'Rome',
                'image' => 'https://example.com/rome.jpg'
            ],
            [
                'name' => 'Londres',
                'image' => 'https://example.com/londres.jpg'
            ],
            [
                'name' => 'Monaco',
                'image' => 'https://example.com/monaco.jpg'
            ],
            [
                'name' => 'Tunis',
                'image' => 'https://example.com/tunis.jpg'
            ]
        ];
    }

    public static function getByName($name)
    {
        foreach (self::getAll() as $destination) {
            if ($destination['name'] === $name) {
                return $destination;
            }
        }

        return null;
    }
}

?>