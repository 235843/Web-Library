<?php

namespace Endpoints;

use FFI\Exception;
use Session\Session;
use Views\LoginForm;
use Views\Register;

class RegisterEndpoint
{
    public static function save_user()
    {
        
        $name = htmlspecialchars($_POST["name"]);
        $surname = htmlspecialchars($_POST["surname"]);
        $password = htmlspecialchars($_POST["password"]);
        $passwordconf = htmlspecialchars($_POST["password-confirm"]);
        $email = htmlspecialchars($_POST["email"]);
        $phone = $_POST["phone"];
        $city = htmlspecialchars($_POST["city"]);
        $zip = $_POST["zip"];
        $street = htmlspecialchars($_POST["street"]);
        $local = htmlspecialchars($_POST["local"]);

        if(strlen($name)>20 || strlen($surname)>30 || strlen($password)>30 || strlen($passwordconf)>30
        || strlen($email)>30 || strlen($city)>40 || strlen($street)>50 || strlen($local)>10)
        {
            header("Location: localhost:3000/register");
            return Register::view() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }
        
        $name = htmlspecialchars($_POST["name"]);
        $surname = htmlspecialchars($_POST["surname"]);
        $password = htmlspecialchars($_POST["password"]);
        $passwordconf = htmlspecialchars($_POST["password-confirm"]);
        $email = htmlspecialchars($_POST["email"]);
        $city = htmlspecialchars($_POST["city"]);
        $street = htmlspecialchars($_POST["street"]);
        $local = htmlspecialchars($_POST["local"]);
        
        if(strcmp($password,$passwordconf)!=0)
        {
            header("Location: localhost:3000/register");
            return Register::view() . "<html><script>
            alert(\"Podane hasła się różnią\");
            </script></html>";
        }
        
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $query = "INSERT INTO student (Name, Surname, Password, PhoneNumber, EMail)
         VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "sssss", $name, $surname, $hashed_passw, $phone, $email);

        mysqli_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if(!mysqli_num_rows($res))
        {
            header("Location: localhost:3000/register");
            return Register::view() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }
        
        mysqli_stmt_close($stmt);

        $res = mysqli_fetch_assoc($res);
        $user_id = $res["ID"];

        $hashed_passw = password_hash($password, PASSWORD_DEFAULT);
        $conn->query("UPDATE `student` SET Password='$hashed_passw' WHERE ID='$user_id'");

        $id = $conn->query("SELECT * FROM `student` WHERE EMail=$email");
        $id = mysqli_fetch_assoc($id);
        $id = $id["ID"];

        $query = "INSERT INTO address(InhabitantID, City, Street, LocalNumber, ZIP)
        VALUES ('$id', ?, ?, ?,')";

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_bind_param($stmt, "ssss", $city, $street, $local, $zip);

        mysqli_execute($stmt);

        $res = mysqli_stmt_get_result($stmt);
        if(!mysqli_num_rows($res))
        {
            header("Location: localhost:3000/register");
            return Register::view() . "<html><script>
            alert(\"Bład danych\");
            </script></html>";
        }
        
        mysqli_stmt_close($stmt);

       
        $conn->close();

         return LoginForm::view()   ;
    }
}
