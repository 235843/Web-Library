<?php

namespace Endpoints;

use FFI\Exception;
use Session\Session;
use Views\Home;
use Views\AddBook;

class AddedBook
{
    public static function AddBook()
    {
        
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $title = $_POST["title"];
        $author = $_POST["author"];
        $amount = $_POST["amount"];
        $descr = $_POST["descr"];
        $cat = $_POST["category"];

        


        $row = $conn->query("SELECT * FROM `author` WHERE AuthorName='$author'");
        
        if(!mysqli_num_rows($row))
            $conn->query("INSERT INTO `author` (AuthorName) VALUES ('$author')");

        $row = $conn->query("SELECT * FROM `category` WHERE CategoryName='$cat'");
       
        if(!mysqli_num_rows($row))
            $conn->query("INSERT INTO `category` (CategoryName) VALUES ('$cat')");
        
        $cat_id = $conn->query("SELECT * FROM `category` WHERE CategoryName='$cat'");
        $cat_id = mysqli_fetch_assoc($cat_id);
        $cat_id = $cat_id["CategoryID"];

        $author_id = $conn->query("SELECT * FROM `author` WHERE AuthorName='$author'");
        $author_id = mysqli_fetch_assoc($author_id);
        $author_id = $author_id["AuthorID"];

        $row = $conn->query("SELECT * FROM `book` WHERE Title='$title' AND AuthorID='$author_id'");
        if(mysqli_num_rows($row)){
            return AddBook::AddBook(). "<html><script>
            alert(\"Ta książka już jest w naszym katalogu\");
            </script></html>"   ;
        }

        $conn->query("INSERT INTO `book` (CategoryID, Title, AuthorID, Amount, Describtion)
        VALUES ('$cat_id', '$title', '$author_id', '$amount', '$descr')");
       
        $conn->close();

         return AddBook::AddBook(). "<html><script>
         alert(\"Dodano pozycję\");
         </script></html>"   ;
    }
}
