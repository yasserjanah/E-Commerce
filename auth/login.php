<?php
	include_once "../database/connection.php";
	include_once "../base/header.php";
?>
<title> YJ | Login </title>

<?php

    if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
        header("Location: /index.php");
    }
    else{
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(isset($_POST["email"]) && isset($_POST["password"])){
                $email    = htmlspecialchars($_POST["email"]);
                $password = htmlspecialchars($_POST["password"]);
    
                $hashed_password = sha1($password);
    
                $stmt = $pdo->prepare("SELECT * FROM Users WHERE email=:email AND password=:password");
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->execute();
                
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    
                if (!$user){
                    $_SESSION['error'] = "Email Or Password is Incorrect!";
                }
                else{
                    unset($_SESSION['error']);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['fname'] = $user['fname'];
                    $_SESSION['lname'] = $user['lname'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['message'] = "Congratulations, you are logged in!";
                    header("Location: /");
                }
    
            }
        }
    }
?>

<?php
    include_once "../base/messages.php";
?>

<div class="flex items-center mt-20 bg-white dark:bg-gray-900">
    <div class="container mx-auto">
        <div class="max-w-md mx-auto">
            <div class="text-center">
                <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Log in</h1>
                <p class="text-gray-500 dark:text-gray-400">Login to access your account</p>
            </div>
            <div class="m-7">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Your Email" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <label for="password" class="text-sm text-gray-600 dark:text-gray-400">Password</label>
                        </div>
                        <input type="password" name="password" id="password" placeholder="Your Password" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <button type="submit" class="w-full px-3 py-4 text-white bg-red-500 rounded-md focus:bg-red-600 focus:outline-none">Log in</button>
                    </div>
                    <p class="text-sm text-center text-gray-400">Don&#x27;t have an account yet? <a href="/auth/register.php" class="text-red-400 focus:outline-none focus:underline focus:text-red-500 dark:focus:border-red-800">Create Account</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>

	
