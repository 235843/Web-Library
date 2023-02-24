<?php

namespace Views;

use db\DB;



class Register
{
    public static function view()
    {
        return <<<VIEW

        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Twoja Biblioteczka</title>
        <style>
          @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');
      

          body {
            margin: 0;
            box-sizing: border-box;
            
          }

    main {
      max-width: 350px;
      display: flex;
      flex-direction: column;
      align-items: center;
    
    }

    .intro {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      width: 100%;
      margin-bottom: 3rem;
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
 ;
      color: #b9b6d3;
      
    }

    .content {
      margin-left: 190px;
      border-left: 1px solid #d4d4d4;
      padding: 1em;
      overflow: hidden;
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

    .form-term {
      margin-bottom: 0.75em;
      font-size: 0.8rem;
      text-align: center;
    }

    .form-term span {
      font-weight: 700;
      color: #ff7a7a;
    }

    .left {
      
      float: left;
      width: 180px;
      margin: 0;
      padding: 1em;
      text-align: left;
      font-family: sans-serif;
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
    
    @media (min-width: 768px) {
      body {
        
        min-height: 100vh;
        text-align: center;
      }

      main {
        max-width: 100vw;
        flex-direction: column;
        justify-content: center;
      }

      .intro {
        align-items: flex-start;
        text-align: left;
        width: 45%;
        margin-right: 1rem;
      }

    
      
    }
  </style>
</head>

<body>
  <header class="header">
  <h1><a href="../home" style="text-decoration:none; color: black">Twoja Biblioteczka</a></h1>
    <form action = "/login" method="GET">
           <input class="submit-btn1" type="submit" value="Zaloguj">
          </form>
  </header>

  
  <aside class="left">
  <ul>
    <li><a href="../about">O nas</a></li>
  </ul>
  <br><br>
  <p>"Książka i możliwość czytania, to jeden z największych cudów ludzkiej cywilizacji."<br>- Ktoś bardzo mądry</p>
</aside>

  <main>

  
      <h1 style="font-family: 'Pacifico', cursive; ">Rejestracja</br></h1>
     
    <section class="sign-up">
    
      <form class="sign-up-form" action = "/login" method="POST">
      
       <div class="form-input"></div>
       <div class="form-input">
          <input type="text" name="name" id="name" placeholder="Imię" required autofocus>
          <span>!</span>
          <p class="warning">Name cannot be empty</p>
        </div>
        <div class="form-input">
          <input type="text" name="surname" id="surname" placeholder="Nazwisko" required>
          <span>!</span>
          <p class="warning">Surname cannot be empty</p>
        </div>
        

        <div class="form-input">
          <input type="Password" name="password" id="password" placeholder="Hasło" required>
          <span>!</span>
          <p class="warning">Password cannot be empty</p>
        </div>
        <div class="form-input">
          <input type="Password" name="password-confirm" id="password-confirm" placeholder="Powtórz hasło" required>
          <span>!</span>
          <p class="warning">Password-confirm cannot be empty</p>
        </div>
        <p></p>

        <div class="form-input">
          <input type="email" name="email" id="email" placeholder="Adres E-Mail" required>
          <span>!</span>
          <p class="warning">Looks like this is not an email</p>
        </div>
        <div class="form-input">
         <input type="tel" name="phone" id="phone" placeholder="Nr Telefonu 123456789" pattern="[0-9]{9}" required>
         <span>!</span>
         <p class="warning">Błędny format</p>
        </div>
        <p></p>

        <div class="form-input">
          <input type="text" name="city" id="city" placeholder="Podaj miasto" required>
          <span>!</span>
          <p class="warning">City cannot be empty</p>
        </div>
        <div class="form-input">
          <input type="text" name="zip" id="zip" placeholder="Podaj kod pocztowy 12-345" pattern-"[0-9]{2}-[0-9]{3}" required>
          <span>!</span>
          <p class="warning">ZIP cannot be empty</p>
        </div>
        <div class="form-input">
          <input type="text" name="street" id="street" placeholder="Podaj nazwę ulicy Łódzka" " required>
          <span>!</span>
          <p class="warning">Street cannot be empty</p>
        </div>
        <div class="form-input">
          <input type="text" name="local" id="local" placeholder="Podaj numer domu/lokalu 12/34" ">
          <span>!</span>
          <p class="warning">Street cannot be empty</p>
        </div>
        
         <button class="submit-btn" type="submit" value="Rejestracja" name="Rejestracja">Rejestracja</button>
          
      </form>
      
          
    </section>
  </main>
</body>
    }

VIEW;
    }

    // <form>
    //             <label>Email: <input type="text" name="email"></label><br>
    //             <label> Mobile: <input type="text" name="mobile"> </label><br>
    //             <textarea name="comments" rows="4">Enter your message</textarea><br>
    //             <input type="submit" value="Submit" /><br>
    //           </form>

    
}
