<?php

namespace Endpoints;


use Session\Session;
use Views\EditBook;
use Views\Home;
use Views\Profile;


class EditEndpoint
{
    public static function Edit($book_id)
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $user_id = Session::user_id();
        
        $title = $_POST["title"];
        $author = $_POST["author"];
        $amount = $_POST["amount"];
        $cat = $_POST["cat"];
        $descr = $_POST["descr"];


        $book = $conn->query("SELECT * FROM `book` WHERE BookID='$book_id'");
        $book = mysqli_fetch_assoc($book);

        if (!strcmp($title, ""))
            $title = $book["Title"];
        if (!strcmp($amount, ""))
            $amount = $book["Amount"];
        if (!strcmp($descr, ""))
            $descr = $book["Describtion"];

        $cat_id = $book["CategoryID"];
        $author_id = $book["AuthorID"];

        $cat_id = $conn->query("SELECT * FROM `category` WHERE CategoryID='$cat_id'");
        
        if (!strcmp($cat, "")){
            $cat_id = mysqli_fetch_assoc($cat_id);
            $cat = $cat_id["CategoryName"];
        }else{
            if (!mysqli_num_rows($conn->query("SELECT * FROM `category` WHERE CategoryName='$cat'")))
                $conn->query("INSERT INTO `category` (CategoryName) VALUES ('$cat')");
        }
        
        
        $cat_id = $conn->query("SELECT * FROM `category` WHERE CategoryName='$cat'");
        $cat_id = mysqli_fetch_assoc($cat_id);
        $cat_id = $cat_id["CategoryID"];
        
        
        $author_id = $conn->query("SELECT * FROM `author` WHERE AuthorID='$author_id'");
        
        
        if (!strcmp($author, "")) {
            $author_id = mysqli_fetch_assoc($author_id);
            $author = $author_id["AuthorName"];
        }else{
            if (!mysqli_num_rows($conn->query("SELECT * FROM `author` WHERE AuthorName='$author'")))
                $conn->query("INSERT INTO `author` (AuthorName) VALUES ('$author')");
        }

       

        $author_id = $conn->query("SELECT * FROM `author` WHERE AuthorName='$author'");
        $author_id = mysqli_fetch_assoc($author_id);
        $author_id = $author_id["AuthorID"];
        
        $conn->query("UPDATE `book` SET Title='$title', Amount='$amount', Describtion='$descr', CategoryID='$cat_id', AuthorID='$author_id' WHERE BookID='$book_id'");
            
        $conn->close();

        return EditBook::EditBook($book_id);
    }
}