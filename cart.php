<?php
	include_once "database/connection.php";
	include_once "base/header.php";
	include_once "base/messages.php";

    if(isset($_GET['checkout'])){
        foreach($_SESSION['cart'] as $item) { 
            $id = $_SESSION['id'];
            $productid = $item->qte;
            $qte = $item->qte;
            $stmt = $pdo->prepare("INSERT INTO Panier(ProductId, UserId, Qte) VALUES(:pid, :_uid, :qte)");
            $stmt->bindValue(':pid', $id, PDO::PARAM_INT);
            $stmt->bindValue(':_uid', $productid, PDO::PARAM_INT);
            $stmt->bindValue(':qte', $qte, PDO::PARAM_INT);
            $stmt->execute();
        }
        $_SESSION["message"] = "Your Order is Placed!";
        header("Location: clearcart.ajax.php");
        exit();
    }

    if( (! isset($_SESSION['id']) ) )
        return header("Location: /index.php");
    else
        $user_id = $_SESSION['id'];
?>

<title>Your Cart </title>

<?php 
    $total = 0;
    // if (isset($_SESSION['cart'])){
    //     print_r($_SESSION['cart']);
    // }
?>
<div class="container mx-auto mt-5" id="root">
    <div class="flex my-10">
        <div class="w-3/4 bg-white px-10 py-10">
            <div class="flex justify-between border-b pb-8">
                <h1 class="font-semibold text-2xl">Shopping Cart</h1>
                <h2 class="font-semibold text-2xl"><?= (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : "0" ?>  Items</h2>
            </div>
            <div class="flex mt-10 mb-5">
                <h3 class="font-semibold text-gray-600 text-xs uppercase w-2/5">Product Details</h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Quantity</h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Price</h3>
                <h3 class="font-semibold text-center text-gray-600 text-xs uppercase w-1/5 text-center">Total</h3>
            </div>

            <?php if (isset($_SESSION['cart'])) { ?>
            <?php foreach($_SESSION['cart'] as $item) { ?>
            <?php
                    $stmt = $pdo->prepare("SELECT * FROM Products WHERE sku=:pid");
                    $stmt->bindValue(':pid', $item->productid, PDO::PARAM_INT);
                    $stmt->execute();
                
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);

                    $total += (int)$product['price'];
                
            ?>
            <div class="flex items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                <div class="flex w-2/5">
                    <!-- product -->
                    <div class="w-20">
                        <img class="h-24" src="<?= $product['image'] ?>" alt="">
                    </div>
                    <div class="flex flex-col justify-between ml-4 flex-grow">
                        <span class="font-bold text-sm"><?= $product['name'] ?></span>
                        <span class="text-red-500 text-xs"><?= $product['description'] ?></span>
                        <a href="#" class="font-semibold hover:text-red-500 text-gray-500 text-xs">Remove</a>
                    </div>
                </div>
                <div class="flex justify-center w-1/5">
                    <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
                        <path
                            d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                    </svg>

                    <input class="mx-2 border text-center w-8" type="text" value="<?= $item->qte ?>">

                    <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
                        <path
                            d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" />
                    </svg>
                </div>
                <span class="text-center w-1/5 font-semibold text-sm">$<?= $product['price'] ?></span>
                <span class="text-center w-1/5 font-semibold text-sm">$<?= $product['price'] * $item->qte ?></span>
            </div>
            <?php } ?>
            <?php } ?>

            <a href="/" class="flex font-semibold text-red-600 text-sm mt-10">

                <svg class="fill-current mr-2 text-red-600 w-4" viewBox="0 0 448 512">
                    <path
                        d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z" />
                    </svg>
                Continue Shopping
            </a>
        </div>

        <div id="summary" class="w-1/4 px-8 py-10">
            <h1 class="font-semibold text-2xl border-b pb-8">Order Summary</h1>

            <div class="mt-8">
                <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                    <span>Total cost</span>
                    <span>$<?= $total ?></span>
                </div>
                <button
                    class="bg-transparent font-semibold hover:bg-red-600 py-3 text-sm text-white uppercase w-full mb-5" onclick="emptycart()">Empty Card</button>
                <button
                    class="bg-red-500 font-semibold hover:bg-red-600 py-3 text-sm text-white uppercase w-full" onclick="checkout()">Checkout</button>
            </div>
        </div>

    </div>
</div>

<script>
    function checkout(){
         window.location = "?checkout=true";
    }

    function emptycart(){
        $.ajax({
        url: 'clearcart.ajax.php',
        type: 'GET',
        success: function(resp) {
			// console.log(resp);
			$('#cart_items').load('index.php #cart_items', {}, function() {});
            $('#root').load('cart.php #root', {}, function() {});
        },
        error: function(resp){
            // console.log(resp);
        }
    });
    }
</script>