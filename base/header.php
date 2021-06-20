<?php session_start(); ?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../assets/favicon.ico">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/main.js"></script>
</head>

<body>
<nav class="bg-white">
  <div class="container mx-auto px-6 py-3 md:flex md:justify-between md:items-center">
    <div class="flex justify-between items-center">
      <div>
        <a class="text-gray-800 text-xl font-bold md:text-2xl hover:text-gray-700" href="/">YJ | Store</a>
      </div>

      <!-- Mobile menu button -->
      <div class="flex md:hidden">
        <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
          <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
            <path fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
    <div class="md:flex items-center">
      <div class="flex flex-col md:flex-row md:mx-6">
        <a class="my-1 text-sm text-gray-700 font-medium hover:text-red-500 md:mx-4 md:my-0" href="/">Home</a>
        <?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])) : ?>
        	<a class="my-1 text-sm text-gray-700 font-medium hover:text-red-500 md:mx-4 md:my-0" href="/auth/logout.php">Logout</a>
        <?php else : ?>
          <a class="my-1 text-sm text-gray-700 font-medium hover:text-red-500 md:mx-4 md:my-0" href="/auth/login.php">Login</a>
          <a class="my-1 text-sm text-gray-700 font-medium hover:text-red-500 md:mx-4 md:my-0" href="/auth/register.php">Register</a>
        <?php endif ?>

        <?php if(isset($_SESSION['id']) && !empty($_SESSION['id'])) : ?>
          <span class="my-1 text-sm text-gray-700 font-black hover:text-red-800 md:mx-4 md:my-0">
            <?= $_SESSION["fname"] ?> <?= $_SESSION["lname"] ?>
          </span>
        <?php endif ?>

      </div>

      <div class="flex justify-center md:block">
        <a class="relative text-gray-700 hover:text-gray-600" href="cart.php">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>

          <span class="absolute top-0 left-6 rounded-full bg-red-500 text-white p-1 text-sm" id="cart_items"><?php
            if(isset($_SESSION['cart'])){
              echo count($_SESSION['cart']);
            }else echo "0"
          ?></span>
        </a>
      </div>
    </div>
  </div>
</nav>
