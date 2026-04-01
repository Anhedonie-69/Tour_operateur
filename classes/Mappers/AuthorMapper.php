<?php

class AuthorMapper
{
    public static function mapToObject(array $data): Author
    {
        return new Author(
            $data['id'],
            $data['name']
        );
    }
}

?>