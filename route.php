<?php
// route.php
// echo "router";

switch ($link) {

    case '':
        include('auth/register.php');
        break;    
        
    case 'register':
        include('auth/register.php');
        break;

    case 'login':
        include('auth/login.php');
        break;

    case 'dashboard':
        include('dashboard.php');
        break;

    case 'products':
        include('product/all.php');
        break;

    case 'product/add':
        include('product/add.php');
        break;

    case 'cart':
        include('cart.php');
        break;
        
        
    case 'logout':
        include('auth/logout.php');
        break;

    // case 'migrate':
    //     include('migration.php');
    //     break;

    default:
        include('404.php');
        break;
}
?>