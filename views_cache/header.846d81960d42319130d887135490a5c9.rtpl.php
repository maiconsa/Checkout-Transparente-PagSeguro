<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout Transparente com PagSeguro</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!--JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!--JQuery UI  -->
    <link rel="stylesheet" href="/views/res/jquery-ui-1.12.1/jquery-ui.css">
    <link rel="stylesheet" href="/views/res/jquery-ui-1.12.1/jquery-ui.structure.css">
    <script src="/views/res/jquery-ui-1.12.1/jquery-ui.js"></script>

    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <!---PagSeguro Librarys -->
    <script type="text/javascript" src="<?php echo htmlspecialchars( $stc, ENT_COMPAT, 'UTF-8', FALSE ); ?>/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

    <!-- Personal CSS and JS Files -->
    <link rel="stylesheet" type="text/css" media="all" href="/views/res/css/main.css">



</head>

<body>
<!--<header style="width: 100vw;height: 8vh;background-color: lightsteelblue">
    <h2>Exemplo de Utilização de pagamento PagSeguro</h2>
</header>-->

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ">
            <a class="nav-item nav-link  nactive" href="/">Home <span class="sr-only">(current)</span></a>
            <a class="nav-item nav-link" href="/create/sender">Sender Register</a>
            <a class="nav-item nav-link" href="/cart">Cart</a>
            <a class="nav-item nav-link" href="/payment">Payment</a>
        </div>
    </div>
</nav>


<div id="#main-container" style="width: 50vw;margin: 0px auto;"> <!-- Start Main Container -->






