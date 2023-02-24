<?php

namespace Views;

use Auth\Auth;
use FFI\Exception;
use Session\Session;
use Views\LoginForm;
use Views\Register;

class Orders
{
    public static function show_orders()
    {
      $table = "<div class=\"wrapper\">
      <div class=\"table\" >
        <div class=\"row\" style=\"background-color:#38cc8c; color:white;\">
          <div class=\"cell\">
            ID zamówienia
          </div>
          <div class=\"cell\">
            Data zamówienia
          </div>
          <div class=\"cell\">
            Termin
          </div>
          <div class=\"cell\">
            Tytuł
          </div>
          <div class=\"cell\">
            Autor
          </div>
          <div class=\"cell\">
            Status
          </div>
        </div>";
        
      $user_id = Session::user_id();
        $conn = mysqli_connect("localhost", "root", "root", "baza");
       
        $result = $conn->query("SELECT * FROM `order` WHERE StudentID = $user_id ORDER BY OrderID DESC");
        $rows = [];
        if (mysqli_num_rows($result) > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($result)) {
              $time = $row["OrdersDate"];
              $deadline = $row["OrdersDeadline"];
              $order_id = $row["OrderID"];
              
              $book_id = $row["BookID"];
              $book = $conn->query("SELECT * FROM `book` WHERE BookID ='$book_id'");
              $book = mysqli_fetch_assoc($book);

              $title = $book["Title"];
              $author_id = $book["AuthorID"];

              $author = $conn->query("SELECT * FROM `author` WHERE AuthorID = '$author_id'");
              $author = mysqli_fetch_assoc($author);
              $author = $author["AuthorName"];

               $rows[$i] = ("<div class=\"row\">
               <div class=\"cell\" data-title=\"ID zamówienia\">
                 $order_id
               </div>
               <div class=\"cell\" data-title=\"Data zamówienia\">
                 $time
               </div>
               <div class=\"cell\" data-title=\"Termin oddania\">
                 $deadline
               </div>
               <div class=\"cell\" data-title=\"Tytuł\">
                 \"$title\"
               </div>
               <div class=\"cell\" data-title=\"Autor\">
                 $author
               </div>
               <div class=\"cell\" data-title=\"\">");
               if(!strcmp($row["OrderStatus"], "Zwrócono"))
                  $rows[$i].="Zwrócono";
                else
                  $rows[$i] .= ("<form  action = \"/return/$order_id\">
                  <button class=\"submit-btn\" style=\"margin-left:20px; width: 75%; font-size:12px; \">Zwróć</button>
                  </form>");
                $rows[$i] .= ("</div></div>");
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
    $table .= $rows."</div></div>";
   
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
               
               line-height: 20px;
               font-weight: 400;
               
               -webkit-font-smoothing: antialiased;
               font-smoothing: antialiased;
              
               
             }
             @media screen and (max-width: 580px) {
              .body {
                font-size: 16px;
                line-height: 22px;
              }
            }
            .wrapper {
              margin: 0 auto;
              padding: 40px;
              max-width: 800px;
            }
            .table {
              margin: 0 0 40px 0;
              width: 100%;
              box-shadow: 0 1px 3px rgba(0,0,0,0.2);
              display: table;
            }
            @media screen and (max-width: 580px) {
              .table {
                display: block;
              }
            }
            .row {
              display: table-row;
              background: #f6f6f6;
            }
            .row:nth-of-type(odd) {
              background: #e9e9e9;
            }
            .row.header {
              font-weight: 900;
              color: white;
              background: #ea6153;
            }
           
            
            @media screen and (max-width: 580px) {
              .row {
                padding: 14px 0 7px;
                display: block;
              }
              .row.header {
                padding: 0;
                height: 6px;
              }
              .row.header .cell {
                display: none;
              }
              .row .cell {
                margin-bottom: 10px;
              }
              .row .cell:before {
                margin-bottom: 3px;
                content: attr(data-title);
                min-width: 98px;
                font-size: 10px;
                line-height: 10px;
                font-weight: bold;
                text-transform: uppercase;
                color: white;
                display: block;
              }
            }
            .cell {
              
              padding: 6px 12px;
              display: table-cell;
            }
            @media screen and (max-width: 580px) {
              .cell {
                padding: 2px 16px;
                display: block;
              }
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
               @media screen and (max-width: 580px);
              display: block;
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
             <div >
            
             $table
           </div>
               <hr><br>
 
               
             </main>
           </div>
         </body>
         VIEW;  ;
    }
}
