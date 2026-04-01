<?php

class ScoreMapper
{
    public static function mapToObject(array $data): Score
    {
        return new Score(
            $data['id'],
            $data['value'],
            $data['author_name']
        );
    }
}

?>