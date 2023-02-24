<?php

namespace Endpoints;

use db\DB;
use FFI\Exception;
use Session\Session;
use Views\Home;


class DeleteEndpoint
{
    public static function DeleteBook($book_id)
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");

        $result = $conn->query("SELECT * FROM `order` WHERE BookID=$book_id");
        if(mysqli_num_rows($result))
        {
            return Home::view(). "<html><script>
            alert(\"Nie możesz usunąć tej książki\");
            </script></html>";  
        }

        $conn->query("DELETE FROM book WHERE BookID=$book_id");

        return Home::view(). "<html><script>
        alert(\"Pozycja została usunięta\");
        </script></html>";
    }
}