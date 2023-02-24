<?php

namespace Router;

use Auth\Auth;


use Endpoints\AddedBook;
use Endpoints\DeleteEndpoint;           
use Endpoints\EditEndpoint;
use Endpoints\RegisterEndpoint;
use Endpoints\LoginEndpoint;
use Endpoints\LogoutEndpoint;
use Endpoints\OrderEndpoint;
use Endpoints\Results;
use Endpoints\ReturnEndpoint;
use Endpoints\ChangeEndpoint;
use Endpoints\NewPasswordEndpoint;
use Session\Session;
use Views\About;
use Views\EditBook;
use Views\Home;
use Views\LoginForm;
use Views\Password;
use Views\Register;
use Views\Profile;
use Views\Orders;
use Views\AddBook;

$router = new Router();


$router->add('/home', fn() => Home::view());

$router->add('/about', fn() => About::view());

$router->add('/login', fn() => LoginForm::view())->auth(Auth::guest);

$router->add('/register', fn() => Register::view())->auth(Auth::guest);

$router->add('/password', fn() => Password::ChangePassword())->auth(Auth::signed);

$router->add('/profile', fn() => Profile::ChangeData())->auth(Auth::signed);

$router->add('/return', fn() => Orders::show_orders())->auth(Auth::signed);

$router->add('/addbook', fn() => AddBook::AddBook())->auth(Auth::admin);

$router->add('/logout', fn() => LogoutEndpoint::Logout(), Method::GET)->auth(Auth::signed);

$router->add('/home', fn() => LoginEndpoint::Login(), Method::POST);

$router->add('/changepassword', fn() => NewPasswordEndpoint::ChangePassword(), Method::POST)->auth(Auth::signed);

$router->add('/change', fn() => ChangeEndpoint::ChangeData(), Method::POST)->auth(Auth::signed);

$router->add('/results', fn() => Results::show_results(), Method::POST);

$router->add('/login', fn() => RegisterEndpoint::save_user(), Method::POST)->auth(Auth::guest);

$router->add('/added', fn() => AddedBook::AddBook(), Method::POST)->auth(Auth::admin);

$router->add('/delete/:id', fn($id) => DeleteEndpoint::DeleteBook($id))->auth(Auth::admin);

$router->add('/editbook/:id', fn($id) => EditBook::EditBook($id))->auth(Auth::admin);

$router->add('/return/:id', fn($id) => ReturnEndpoint::ReturnBook($id))->auth(Auth::signed);

$router->add('/order/:id', fn($id) => OrderEndpoint::MakeOrder($id))->auth(Auth::signed);

$router->add('/editbook/:id', fn($id) => EditEndpoint::Edit($id), Method::POST)->auth(Auth::admin);

