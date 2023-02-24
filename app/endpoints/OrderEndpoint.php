<?php

namespace Endpoints;

use db\DB;
use FFI\Exception;
use Session\Session;
use Views\Home;


class OrderEndpoint
{
    public static function MakeOrder($book_id)
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $user_id = Session::user_id();

        $check = $conn->query("SELECT * FROM `order` WHERE BookID='$book_id' AND  StudentID = '$user_id'AND  OrderStatus != 'Zwrócono'");

       if(mysqli_num_rows($check))
        {
            return Home::view() . "<html><script>
            alert(\"Nie możesz naraz wypożyczyć dwóch tych samych pozycji\");
            </script></html>";
        }

        $ordertime = date("Y-m-d H:i:s");
        $time = strtotime($ordertime);
        $deadline = date("Y-m-d H:i:s", strtotime("+1 month", $time));
        

        $conn->query("INSERT INTO `order` (StudentID, BookID, OrdersDate, OrdersDeadline, OrderStatus)
        VALUES ('$user_id',
         '$book_id',
          '$ordertime', 
          '$deadline', 
          'W realizacji')");

        $conn->query("UPDATE `book` SET Amount = Amount-1 WHERE BookID = '$book_id' ");

        $conn->close();

        return Home::view() . "<html><script>
        alert(\"Zamówienie zostało przyjęte do realizacji\");
        </script></html>";
    }
}