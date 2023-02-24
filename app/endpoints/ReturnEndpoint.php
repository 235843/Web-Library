<?php

namespace Endpoints;

use db\DB;
use FFI\Exception;
use Session\Session;
use Views\Orders;


class ReturnEndpoint
{
    public static function ReturnBook($order_id)
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");    

        $row = $conn->query("SELECT * FROM `order` WHERE OrderID = $order_id");

        $row = mysqli_fetch_assoc($row);

        $book_id = $row["BookID"];

        $conn->query("UPDATE `book` SET Amount = Amount+1 WHERE BookID = $book_id ");
        $conn->query("UPDATE `order` SET OrderStatus='Zwrócono' WHERE OrderID=$order_id ");
        
        $conn->close();

        return Orders::show_orders() . "<html><script>
        alert(\"Książka została zwrócona\");
        </script></html>";
    }
}