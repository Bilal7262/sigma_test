<?php
// route.php

$link = explode('?',$link)[0];



switch ($link) {

    case '':
        include('auth/register.php');
        break;    
        
    case 'register':
        include('auth/auth_form.php');
        break;

    case 'login':
        include('auth/auth_form.php');
        break;

    case 'dashboard':
        include('dashboard.php');
        break;

    case 'product-details':
        include('product/detail.php');
        break;
    case 'products':
        include('product/all.php');
        break;

    case 'product/add':
        include('product/add.php');
        break;

    case 'cart':
        include('cart/cart.php');
        break;
        

    default:
        include('404.php');
        break;
}
?>