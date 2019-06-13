<?php

require __DIR__ . '/Cart.php';

session_start();

if (isset($_SESSION['cart'])) {
    $cart = unserialize($_SESSION['cart']);
} else {
    $cart = new Cart();
}

if ('POST' === $_SERVER['REQUEST_METHOD']) {

    try {
	    $cart->updateQuantities($_POST['quantity']);
	    $_SESSION['cart'] = serialize($cart);
    } catch (CartException $e) {
        header('Content-Type: text/plain; charset="utf-8"');
        echo $e->getMessage();
        exit;
    }	

    $url = "TDD_laravel/";
    header($url);
    //exit;
}

require __DIR__ . '/view.php';