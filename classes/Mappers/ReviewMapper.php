<?php

class ReviewMapper
{
    public static function mapToObject(array $data): Review
    {
        return new Review(
            $data['id'],
            $data['message'],
            $data['author_name']
        );
    }
}

?>