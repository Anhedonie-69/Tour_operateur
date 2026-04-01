<?php

class AuthorRepository
{
    private PDO $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAuthorById($id)
    {
        $request = $this->db->prepare('
            SELECT * FROM author
            WHERE id = ?
        ');
        $request->execute([$id]);
        $result = $request->fetch();

        $author = AuthorMapper::mapToObject($result);

        return $author;
    }

    public function getAuthorByName($name)
    {
        $request = $this->db->prepare('
            SELECT * FROM author
            WHERE name = ?
        ');
        $request->execute([$name]);
        $result = $request->fetch();

        if (!$result)
        {
            return null;
        }

        $author = AuthorMapper::mapToObject($result);

        return $author;
    }

    public function getAuthors()
    {
        $request = $this->db->prepare('
            SELECT * FROM author
        ');
        $request->execute();
        $result = $request->fetchAll();

        $authors = [];
        
        foreach($authors as $author)
        {
            $authors[] = AuthorMapper::mapToObject($author);
        }
        
        return $authors;
    }

    public function createAuthor($name)
    {
        $request = $this->db->prepare('
            INSERT INTO author (name)
            VALUES (?)
        ');
        $request->execute([$name]);

        $author = AuthorMapper::mapToObject([
            'id' => $this->db->lastInsertId(),
            'name' => $name
        ]);

        return $author;
    }
}

?>