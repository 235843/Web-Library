<?php

namespace Endpoints;


use Session\Session;
use Views\Home;
use Views\Profile;


class NewPasswordEndpoint
{
    public static function ChangePassword()
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $user_id = Session::user_id();
        
        $newpassw = $_POST["newpassword"];
        $newpassw_conf = $_POST["passwordconf"];
        $passw = $_POST["password"];
        
        if(strcmp($newpassw, $newpassw_conf))
        {
            return NewPasswordEndpoint::ChangePassword()() . "<html><script>
            alert(\"Podane hasła się różnią\");
            </script></html>";
        }

        $user = $conn->query("SELECT * FROM `student` WHERE ID=$user_id");
        $user = mysqli_fetch_assoc($user);
        
        if(!password_verify($passw,$user["Password"]))
        {
           return NewPasswordEndpoint::ChangePassword() . "<html><script>
            alert(\"Niepoprawne hasło\");
            </script></html>";
        }
        $query = "UPDATE `student` SET Password=? WHERE ID='$user_id'";
        
        $stmt = mysqli_prepare($conn, $query);


        mysqli_stmt_bind_param($stmt, "s", $newpassw);

        mysqli_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if(!mysqli_num_rows($res))
        {
            return NewPasswordEndpoint::ChangePassword() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }
        
        mysqli_stmt_close($stmt);

        
        $hashedpassw = password_hash($newpassw, PASSWORD_DEFAULT);

        

        $conn->query("UPDATE `student` SET Password='$hashedpassw' WHERE ID='$user_id'");

       
        $conn->close();

        return Home::view(). "<html><script>
        alert(\"Hasło zostało zmienione\");
        </script></html>";
    }
}