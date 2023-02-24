<?php

namespace Endpoints;


use Session\Session;
use Views\Home;
use Views\Profile;


class ChangeEndpoint
{
    public static function ChangeData()
    {
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $user_id = Session::user_id();
        
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $city = $_POST["city"];
        $zip = $_POST["zip"];
        $street = $_POST["street"];
        $local = $_POST["local"];

        $user = $conn->query("SELECT * FROM `student` WHERE ID=$user_id");
        $user = mysqli_fetch_assoc($user);
        $address = $conn->query("SELECT * FROM `address` WHERE InhabitantID=$user_id");
        $address = mysqli_fetch_assoc($address);

        if (!strcmp($name, ""))
            $name = $user["Name"];
        if (!strcmp($surname, ""))
            $surname = $user["Surname"];
        if (!strcmp($email, ""))
            $email = $user["EMail"];
        if (!strcmp($phone, ""))
            $phone = $user["PhoneNumber"];
        if (!strcmp($city, ""))
            $city = $address["City"];
        if (!strcmp($street, ""))
            $street = $address["Street"];
        if (!strcmp($local, ""))
            $local = $address["LocalNumber"];
        if (!strcmp($zip, ""))
            $zip = $address["ZIP"];

        $conn->query("UPDATE `student` SET Name='$name', Surname='$surname', EMail='$email', PhoneNumber='$phone' WHERE ID='$user_id'");
        $conn->query("UPDATE `address` SET City='$city', Street='$street', LocalNumber='$local', ZIP='$zip' WHERE InhabitantID='$user_id'");
            

        $conn->close();

        return Profile::ChangeData();
    }
}