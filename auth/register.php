<?php
	include_once "../database/connection.php";
	include_once "../base/header.php";
?>
<title> YJ | Register </title>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["fname"]) && isset($_POST["lname"]) && isset($_POST["email"]) && isset($_POST["password_1"]) && isset($_POST["password_2"])){
            // avoid SQL Injection 
            $fname    = htmlspecialchars($_POST["fname"]);
            $lname    = htmlspecialchars($_POST["lname"]);
            $email    = htmlspecialchars($_POST["email"]);
            $password_1 = htmlspecialchars($_POST["password_1"]);
            $password_2 = htmlspecialchars($_POST["password_2"]);
    
            if ($password_1 !== $password_2){
                $_SESSION['error'] = "Passwords doesn't match";
            }


            else{

                $query = $pdo->prepare("SELECT * FROM Users WHERE email=:email");
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $_SESSION['error'] = "The email address is already registered!";
                }
                else{
                    $hashed_password = sha1($password_1);
    
                    try{
                        $stmt = $pdo->prepare("INSERT INTO Users(fname, lname, email, password) VALUES(:fname, :lname, :email, :password)");
                        $stmt->bindValue(':fname', $fname, PDO::PARAM_STR);
                        $stmt->bindValue(':lname', $lname, PDO::PARAM_STR);
                        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
                        $result = $stmt->execute();
                        if ($result){
                            $_SESSION['message'] = "You registration was successful!";
                        }
                    } catch(Exception $e){
                        echo $e;
                        exit();
                    }
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
                <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Register</h1>
                <p class="text-gray-500 dark:text-gray-400">Create your account</p>
            </div>
            <div class="m-7">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="mb-6">
                        <label for="fname" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">First
                            Name</label>
                        <input type="text" name="fname" id="fname" placeholder="Your First Name"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <label for="lname" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Last Name</label>
                        <input type="text" name="lname" id="lname" placeholder="Your Last Name"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Email
                            Address</label>
                        <input type="email" name="email" id="email" placeholder="Your Email"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <label for="password_1" class="text-sm text-gray-600 dark:text-gray-400">Password</label>
                        </div>
                        <input type="password" name="password_1" id="password_1" placeholder="Your Password"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <div class="flex justify-between mb-2">
                            <label for="password_2" class="text-sm text-gray-600 dark:text-gray-400">Re-type
                                Password</label>
                        </div>
                        <input type="password" name="password_2" id="password_2" placeholder="Re-type Password"
                            class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-red-100 focus:border-red-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                    </div>
                    <div class="mb-6">
                        <button type="submit"
                            class="w-full px-3 py-4 text-white bg-red-500 rounded-md focus:bg-red-600 focus:outline-none">Register</button>
                    </div>
                    <p class="text-sm text-center text-gray-400">already have an account yet? <a href="/auth/login.php" class="text-red-400 focus:outline-none focus:underline focus:text-red-500 dark:focus:border-red-800">Login</a>.</p>
                </form>
            </div>
        </div>
    </div>
</div>