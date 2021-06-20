<?php
	include_once "database/connection.php";
	include_once "base/header.php";
	include_once "base/messages.php";

	$numberOfProductPerPage = 8;

	if(!isset($_GET['page'])){
		$page = 1;
	}else {
		$page = htmlspecialchars($_GET['page']);
	}

	$startFrom = ($page - 1) * $numberOfProductPerPage;

	$stmt = $pdo->prepare("SELECT * FROM Products");
	$stmt->execute();
	$products_count = $stmt->rowCount();

	$stmt = $pdo->prepare("SELECT * FROM Products LIMIT :startFrom, :endFrom");

	if (isset($_GET['filter'])){
		$stmt = $pdo->prepare("SELECT * FROM Products WHERE CatId=:catid LIMIT :startFrom, :endFrom");
		$stmt->bindValue(":catid", htmlspecialchars($_GET['filter']), PDO::PARAM_STR);
	}
	
	$stmt->bindValue(':startFrom', $startFrom, PDO::PARAM_INT);
	$stmt->bindValue(':endFrom', $numberOfProductPerPage, PDO::PARAM_INT);
	$stmt->execute();

	$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$stmt = $pdo->prepare("SELECT * FROM Categories");
	$stmt->execute();
	$categories_count = $stmt->rowCount();

	$stmt = $pdo->prepare("SELECT * FROM Categories LIMIT 51625, 3");
	$stmt->execute();
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<title> YJ | Home </title>

<div class="bg-white">
    <main class="my-8">
	<nav class="sm:flex sm:justify-center sm:items-center mt-4">
                <div class="flex flex-col sm:flex-row">
				<?php foreach($categories as $ct){ ?>
					<?php 
						$__productsInCat = $pdo->prepare("SELECT * FROM Products WHERE CatId=:catid");
						$__productsInCat->bindValue(":catid", $ct['id'], PDO::PARAM_STR);
						$__productsInCat->execute();
						$pcount = $__productsInCat->rowCount();
					?>
                    <a href="?filter=<?= $ct['id'] ?>" class="mt-3 text-gray-600 hover:underline sm:mx-3 sm:mt-0"><?= $ct['name'] ?> (<?= $pcount ?>)</a>
				<?php } ?>
					<span class="ml-3 text-sm text-white rounded-full bg-red-800 p-1"><?= $categories_count ?>+ Category</span>
                </div>
            </nav>
        <div class="container mx-auto px-6">
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">

			<?php foreach($products as $pd){ ?>
					<div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden transform hover:scale-105 duration-300 ease-in-out">
						<div class="flex items-end justify-end h-56 w-full bg-cover" style="background-image: url('<?= $pd['image'] ?>')">
							<button class="p-2 rounded-full bg-red-600 text-white mx-5 -mb-4 hover:bg-red-500 focus:outline-none focus:bg-red-500"
								data-sku="<?= $pd['sku'] ?>" onclick="addToCart(this)">
								<svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
							</button>
						</div>
						<div class="px-5 py-3">
							<h3 class="text-gray-700 uppercase"><?= $pd['name'] ?></h3>
							<span class="text-gray-500 mt-2 font-black"><?= $pd['price'] ?>$</span>
						</div>
					</div>
			<?php } ?>
            </div>
            <div class="flex justify-center">
                <div class="flex rounded-md mt-8">
                    <a href="?page=<?= ($page-1) ?>"
						class="py-2 px-4 leading-tight bg-white border border-gray-200 text-red-700 border-r-0 ml-0 rounded-l hover:bg-red-500 hover:text-white">
						<span>Prev</span>
					</a>
                    <a href="?page=<?= $page ?>" 
						class="py-2 px-4 leading-tight bg-white border border-gray-200 text-red-700 border-r-0 hover:bg-red-500 hover:text-white">
						<span><?= $page ?></span>
					</a>
                    <a href="?page=<?= ($page+1) ?>"
						class="py-2 px-4 leading-tight bg-white border border-gray-200 text-red-700 rounded-r hover:bg-red-500 hover:text-white">
						<span>Next</span>
					</a>
                </div>
            </div>
        </div>
    </main>
</div>
<script>

function addToCart(target){
	productid = $(target).data("sku");
	qte = 1; // by default
	data = {productid, qte};
	$.ajax({
        url: 'addtocart.ajax.php',
        type: 'POST',
        data: data,
        success: function(resp) {
			// console.log(resp);
			$('#cart_items').load('index.php #cart_items', {}, function() {});
        },
        error: function(resp){
            // console.log(resp);
        }
    });
}

</script>