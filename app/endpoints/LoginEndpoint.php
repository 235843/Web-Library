<?php

namespace Endpoints;

use db\DB;
use FFI\Exception;
use Session\Session;
use Views\Home;
use Views\LoginForm;

class LoginEndpoint
{
    public static function Login()
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        
        $email = $_POST["email"];
        $password = htmlspecialchars($_POST["Password"]);
        if(strlen($password)>30){
            return LoginForm::view() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }

        $query = "SELECT * FROM student WHERE email = ?";

        $stmt = mysqli_prepare($conn, $query);


        mysqli_stmt_bind_param($stmt, "s", $email);

        mysqli_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!mysqli_num_rows($result)) {
            return LoginForm::view() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }
        
        mysqli_stmt_close($stmt);
      
        $conn->close();

        if(mysqli_num_rows($result)<1)
        {
          ;
            return LoginForm::view() . "<html><script>
            alert(\"Podany email nie jest przypisany do żadnego użytkownika\");
            </script></html>";
        }
        $row = $result->fetch_assoc();
        if(password_verify($password,$row["Password"])==false)
        {
           
           return LoginForm::view() . "<html><script>
            alert(\"Niepoprawne hasło\");
            </script></html>";
        }
        if(!strcmp($row["Role"],"USER"))
            Session::log_in($_POST);
        else {
            
            Session::log_in(['admin' => true]);
        }
        Session::user_id($row["ID"]);
      
        return Home::view();
    }
}