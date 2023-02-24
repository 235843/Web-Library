<?php

namespace Views;

use Auth\Auth;
use FFI\Exception;
use Session\Session;
use Views\LoginForm;
use Views\Register;

class EditBook
{
    public static function EditBook($book_id)
    {
        $user_id = Session::user_id();
        $conn = mysqli_connect("localhost", "root", "root", "baza");
       
        $result = $conn->query("SELECT * FROM `book` WHERE BookID = '$book_id'");
        $rows = "";
        
        $result = mysqli_fetch_assoc($result);
        $title = $result["Title"];
        $author_id = $result["AuthorID"];
        $cat_id = $result["CategoryID"];
        $descr = $result["Describtion"];
        $amount = $result["Amount"];

        $author = $conn->query("SELECT * FROM `author` WHERE AuthorID = '$author_id'");
        $author = mysqli_fetch_assoc($author);
        $author = $author["AuthorName"];

        $cat = $conn->query("SELECT * FROM `category` WHERE CategoryID = '$cat_id'");
        $cat = mysqli_fetch_assoc($cat);
        $cat = $cat["CategoryName"];
            

        $rows .= "<div><h2 style=\"text-align:center\">Zmień dane</h2><form  action=\"/editbook/$book_id\" class=\"sign-up-form\" style=\"item-align:center; margin-left:400px; margin-right:400px\" method=\"POST\">
            <div class=\"form-input\"><input type=\"text\" name=\"title\" id=\"title\" placeholder=\"Tytuł: $title\" ></div>
            <div class=\"form-input\"><input type=\"text\" name=\"author\" id=\"author\" placeholder=\"Autor: $author\" ></div>
            <div class=\"form-input\"><input type=\"text\" name=\"amount\" id=\"amount\" placeholder=\"Ilość: $amount\" ></div>
            <div class=\"form-input\"><input type=\"text\" name=\"cat\" id=\"cat\" placeholder=\"Kategoria: $cat\" ></div>
            <div class=\"form-input\"><input type=\"text\" name=\"descr\" id=\"descr\" placeholder=\"Opis: $descr\" ></div>
            
            <button class=\"submit-btn\" type=\"submit\" value=\"Zapiszdane\" name=\"Zapiszdane\">Zapisz dane</button></form></div>";
                
            
           
    
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

             .sign-up {
                width: 50%;
                text-align: center;
              }
          
              .sign-up-para {
                padding: 1rem 5rem;
                margin-bottom: 1.75rem;
                border-radius: 0.8rem;
                box-shadow: 0 8px 0px rgba(0 0 0/0.15);
                
                text-align: center;
              }
          
              .sign-up-form {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                padding: 1.2rem;
                border-radius: 0.8rem;
                margin-letf:40px;
                margin-right:40px
                color: #b9b6d3;
                
              }

              .form-input {
                width: 100%;
                margin-bottom: 1em;
                position: relative;
                margin-top: 10px
              }
          
              .form-input span {
                position: absolute;
                top: 10%;
                right: 0;
                padding: 0 0.65em;
                border-radius: 50%;
               
                
                display: none;
              }
          
              .form-input.warning span {
                display: inline-block;
              }
          
              .form-input input {
                width: calc(100% - 20px);
                padding: 10px;
                border: 2px solid rgba(185, 182, 211, 0.25);
                border-radius: 0.5em;
                font-weight: 600;
                color: #3e3c49;
              }
          
              .form-input input:focus {
                outline: none;
                border: 2px solid #b9b6d3;
              }
          
              .form-input.warning input {
                border: 2px solid #ff7a7a;
              }
          
              .form-input p {
                margin: 0.2em 0.75em 0 0;
                display: none;
                font-size: 0.75rem;
                text-align: right;
                font-style: italic;
                color: #ff7a7a;
              }
          
              .form-input.warning p {
                display: block;
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
                $rows
               
                
               
             </main>
           </div>
         </body>
         VIEW;  ;
    }
}
