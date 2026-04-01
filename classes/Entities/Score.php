<?php

class Score
{
    private $id;
    private $value;
    private $author;

    public function __construct($id, $value, $author)
    {
        $this->id = $id;
        $this->value = $value;
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}

?>