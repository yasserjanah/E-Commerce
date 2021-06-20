<?php
    session_start();
    include_once "database/connection.php";
    if( !isset($_POST['productid']) || !isset($_POST['qte']) ){
        http_response_code(400);
        exit();
    }

    $productid = filter_var( $_POST['productid'], FILTER_SANITIZE_NUMBER_INT);
    $qte = filter_var( $_POST['qte'], FILTER_SANITIZE_NUMBER_INT);
    $qte = (int) $qte;

    if( !is_int($qte) || $qte<0 || $qte>100 ){
        http_response_code(500);
        header('Content-Type: application/json');
        echo '{"status":"invalideData"}';
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM Products WHERE sku=:pid");
    $stmt->bindValue(':pid', $productid, PDO::PARAM_INT);
	$stmt->execute();

	$product = $stmt->fetch(PDO::FETCH_ASSOC);

    if( empty( $product ) ){
        http_response_code(404);
        header('Content-Type: application/json');
        echo '{"status":"invalideData"}';
        exit();
    }

    $added =false;
    $increment = !0;
    if( isset($_SESSION['cart']) ){
        $cart = $_SESSION['cart'];
        foreach ( $cart as $cartitem){
            if( $cartitem->productid === $productid  ){
                $cartitem->qte += $qte;
                $added = !0;
                $increment= !1;
            }
        }
    }else
        $cart = [];

    if( !$added )
        $cart[] = (object) [ "productid"=>$productid, "qte"=>$qte ];

    $_SESSION['cart'] = $cart;

    // print_r($_SESSION['cart']);

    http_response_code(200);
    header('Content-Type: application/json');
    echo '{"status":"success", "count":'.count($cart).', "increment":'.($increment? 'true':'false').'}';
    exit();
?>