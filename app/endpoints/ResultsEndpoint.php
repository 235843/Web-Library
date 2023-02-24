<?php

namespace Endpoints;

use FFI\Exception;
use Session\Session;
use Views\LoginForm;
use Views\Register;

class Results
{
    public static function show_results()
    {
    
        $conn = mysqli_connect("localhost", "root", "root", "baza");
        $query = $_POST['search'];
        
        $query = mysqli_real_escape_string($conn, $query);

        $result = $conn->query("SELECT * FROM book WHERE title LIKE '%$query%'");
        $rows = [];
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($result)) {
              $authorID = $row['AuthorID'];
              $bookID = $row['BookID'];
              $author = $conn->query("SELECT AuthorName FROM author WHERE AuthorID LIKE '$authorID'");
        
               $is_available = "Available ";
               if(Session::logged_in())
                 $is_available .=  "<button class=\"submit-btn\" style=\"margin-left:20px; width: 5%; font-size:10px; \">Zamów</button>";
               if ($row["Amount"]< 1)
                 $is_available = "Unavailable";
              $author = mysqli_fetch_assoc($author);
               $rows[$i] = ("<form  action=\"/order/$bookID\"><h2>\"" . $row["Title"] . "\" - " . $author["AuthorName"] ." / ". $is_available . "</h2>"
                            ."<p>Opis: ". $row["Describtion"]."</p></form>");
              if (Session::admin())
                $rows[$i] .= " <div style=\"display: flex;\">
                  <form style=\"margin-right:15px\" action=\"/editbook/$bookID\"><button class=\"submit-btn\"style=\"width:100%; font-size:10px; \" >Edytuj</button></form>
                  <form action=\"/delete/$bookID\"><button class=\"submit-btn\" style=\"width:100%; font-size:10px; \">Usuń</button></form>
                  </div>";
        $rows[$i] .= "<br><hr>";
              $i++;
            }
          } else {
            $rows =  "<p>No results found</p>";
          }
    $rows = implode(" ", $rows);
    
    $leftbuttons = "";
    $buttons = "<form action = \"/login\" method=\"GET\">
        <input class=\"submit-btn\" type=\"submit\" value=\"Zaloguj\" />
      </form>
       <p style=\"color: #e9e9e9\">aa</p>
     <form action = \"/register\" method=\"GET\">
       <input class=\"submit-btn1\" type=\"submit\" value=\"Zarejestruj\" />
       </form>";
    if (Session::logged_in()) {
      $buttons = "<form action = \"/logout\" method=\"GET\">
          <input class=\"submit-btn\" type=\"submit\" value=\"Wyloguj\" />
          </form>";
      $leftbuttons ="<li><a href=\"../return\">Zwróć książkę</a></li>
        <li><a href=\"../profile\">Profil</a></li>
        <li><a href=\"../password\">Zmień hasło</a></li>";
    }
    if(!Session::_logged_in())
      $rows = "<h2>Zaloguj się, aby kontynuować</h2>" . $rows;
    $conn->close();
    

    
         return <<<VIEW
         <head>
         <meta charset="UTF-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <title>Twoja Biblioteczka</title>
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
         <style>
         @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
         
             body {
               margin: 0;
               box-sizing: border-box;
               font-family: "Poppins", sans-serif;
               
               
             }
 
             .container {
               line-height: 150%;
             }

             .header {
               
               display: flex;
               justify-content: space-between;
               align-items: center;
               padding: 15px;
               background-color: #e9e9e9;
             }
         
             .header h1 {
               color: #222222;
               font-size: 30px;
               font-family: 'Pacifico', cursive;
             }
         
             .header .social a {
               padding: 0 5px;
               color: #222222;
             }
 
             .social {
                 display: flex;
                 margin-top: 20px;
                 margin-right: 30px;
             }
 
             .submit-btn {
                
                 cursor: pointer;
                 width: 100%;
                 padding: 0.7em;
                 margin-bottom: 0.7em;
                 border: none;
                 border-bottom: 5px solid #31bf81;
                 border-radius: 0.5em;
                 background-color: #38cc8c;
                 color: white;
                 font-weight: 900;
                 text-transform: uppercase;
               }
 
               .submit-btn1 {
                 cursor: pointer;
                 width: 105%;
                 padding: 0.7em;
                 margin-bottom: 1em;
                 border: none;
                 border-bottom: 5px solid #31bf81;
                 border-radius: 0.5em;
                 background-color: #38cc8c;
                 color: white;
                 font-weight: 1000;
                 text-transform: uppercase;
 
               }
           
               .submit-btn:hover   {
                 background-color: #5dd5a1;
               }
 
               .submit-btn1:hover   {
                 background-color: #5dd5a1;
               }
         
             .left {
               float: left;
               width: 180px;
               margin: 0;
               padding: 1em;
               font-family: sans-serif;
             }
 
             .form-input span {
               position: absolute;
               top: 10%;
               right: 0;
               padding: 0 0.65em;
               border-radius: 50%;
               background-color: #ff7a7a;
               color: white;
               display: none;
             }
         
             .form-input.warning span {
               display: inline-block;
             }
 
             .content {
               margin-left: 190px;
               border-left: 1px solid #d4d4d4;
               padding: 1em;
               overflow: hidden;
             }
         
             ul {
               list-style-type: none;
               margin: 0;
               padding: 0;
               font-family: sans-serif;
             }
         
             li a {
               display: block;
               color: #000;
               padding: 8px 16px;
               text-decoration: none;
             }
         
             li a.active {
               background-color: #38cc8c;
               color: white;
               
             }
         
             li a:hover:not(.active) {
               background-color: #38cc8c;
               color: white;
             }
         
             table {
               font-family: arial, sans-serif;
               border-collapse: collapse;
               width: 100%;
               margin: 30px 0;
             }
         
             td,
             th {
               border: 1px solid #dddddd;
               padding: 8px;
             }
         
             tr:nth-child(1) {
               background-color: #84e4e2;
               color: white;
             }
         
             tr td i.fas {
               display: block;
               font-size: 35px;
               text-align: center;
             }
         
             .footer {
               padding: 55px 20px;
               background-color: #2e3550;
               color: white;
               text-align: center;
             }
           </style>
         </head>
         
         <body>
           <div class="container">
             
           <header class="header">
           <h1><a href="../home" style="text-decoration:none; color: black">Twoja Biblioteczka</a></h1>
               <div class="social">
               $buttons
             </div>
          </header>
 
 
             <aside class="left">
               <ul>
                 <li><a href="../about">O nas</a></li>
                 $leftbuttons
               </ul>
               <br><br>
               <p>"Książka i możliwość czytania, to jeden z największych cudów ludzkiej cywilizacji."<br>- Ktoś bardzo mądry</p>
             </aside>
             <main class="content">
             <div class="search-results">
            
             $rows
           </div>
               
 
               
             </main>
           </div>
         </body>
         VIEW;  ;
    }
}
