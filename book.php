<?php

class Book
{
    public $title;
    public $author;

    public function __construct($title, $author)
    {
        $this->title = $title;
        $this->author = $author;
    }

    public function displayBook()
    {
        echo "Title: " . $this->title . "<br>";
        echo "Author: " . $this->author;
    }
}

$book = new Book("The Alchemist", "Paulo Coelho");

$book->displayBook();

?>