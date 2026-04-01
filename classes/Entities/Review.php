<?php

class Review
{
    private $id;
    private $message;
    private $author;

    public function __construct($id, $message, $author)
    {
        $this->id = $id;
        $this->message = $message;
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}

?>