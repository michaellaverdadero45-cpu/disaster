<?php
session_start();
$message = "";

// Database Connection
$conn = mysqli_connect("localhost", "root", "", "login_system");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Login
if(isset($_POST['login'])){
    $user = mysqli_real_escape_string($conn, $_POST['login_user']);
    $pass = $_POST['login_pass'];
    
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$user'");
    $row = mysqli_fetch_assoc($query);
    
    if($row && password_verify($pass, $row['password'])){
        $_SESSION['user'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        echo "<script>alert('✅ Login successful! Welcome ".$row['username']."!'); window.location.href='dashboard.php';</script>";
        exit;
    } else {
        $message = "<div class='error'>❌ Invalid Username or Password</div>";
    }
}

// Handle Reset Password
if(isset($_POST['reset'])){
    $user = mysqli_real_escape_string($conn, $_POST['reset_user']);
    $newpass = $_POST['new_pass'];
    $repass = $_POST['re_pass'];
    $ans = mysqli_real_escape_string($conn, $_POST['sec_ans']);
    
    if($newpass != $repass){
        $message = "<div class='error'>❌ Passwords do not match!</div>";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND sec_answer='$ans'");
        if(mysqli_num_rows($check) > 0){
            $hashed_pass = password_hash($newpass, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$hashed_pass' WHERE username='$user'");
            $message = "<div class='success'>✅ Password updated successfully! You can now login.</div>";
        } else {
            $message = "<div class='error'>❌ Incorrect Username or Security Answer</div>";
        }
    }
}

// Handle Create Account
if(isset($_POST['create'])){
    $user = mysqli_real_escape_string($conn, $_POST['new_user']);
    $pass = $_POST['new_acc_pass'];
    $qns = $_POST['sec_qns'];
    $ans = mysqli_real_escape_string($conn, $_POST['acc_sec_ans']);
    
    $check_user = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if(mysqli_num_rows($check_user) > 0){
        $message = "<div class='error'>❌ Username already exists!</div>";
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (username, password, sec_question, sec_answer, role) VALUES ('$user', '$hashed_pass', '$qns', '$ans', 'user')");
        $message = "<div class='success'>✅ Account created successfully! You can now login.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#165DFF',
                    },
                    fontFamily: {
                        inter: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .form-shadow {
                box-shadow: 0 10px 25px -5px rgba(22, 93, 255, 0.15), 0 8px 10px -6px rgba(22, 93, 255, 0.08);
            }
            .input-border {
                border-width: 0 0 2px 0;
            }
        }
        .error {
            background-color: #FEE2E2;
            color: #DC2626;
            padding: 10px;
            border-radius: 8px;
            margin-bottom:15px;
            text-align:center;
            font-size:14px;
        }
        .success {
            background-color: #D1FAE5;
            color: #065F46;
            padding:10px;
            border-radius:8px;
            margin-bottom:15px;
            text-align:center;
            font-size:14px;
        }
    </style>
</head>
<body class="bg-sky-50 min-h-screen flex items-center justify-center font-inter text-gray-800">

<div class="w-full max-w-[400px] p-5">

    <div class="text-center mb-8">
        <div class="flex justify-center mb-3">
            <div class="w-16 h-16 bg-primary/10 text-primary text-3xl rounded-full flex items-center justify-center">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <h1 class="text-[clamp(1.8rem,3vw,2.4rem)] font-extrabold text-gray-800 mb-1">Login System</h1>
        <p class="text-gray-500 text-sm">Secure Access To Your Account</p>
    </div>

    <?php echo $message; ?>

    <!-- LOGIN FORM -->
    <div id="loginForm" class="bg-white p-8 rounded-2xl form-shadow">
        <h2 class="text-lg font-bold text-center text-gray-700 mb-6 flex items-center justify-center gap-2">
            <i class="fa fa-sign-in text-primary"></i> Sign In
        </h2>
        <form method="POST" action="" class="text-left">
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-user"></i></span>
                    <input type="text" name="login_user" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-7">
                <label class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-key"></i></span>
                    <input type="password" name="login_pass" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <button type="submit" name="login" 
                class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-lg tracking-wide transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 shadow-lg hover:shadow-xl shadow-primary/25">
                LOGIN
            </button>
        </form>
    </div>


    <!-- RESET PASSWORD FORM -->
    <div id="resetForm" class="bg-white p-8 rounded-2xl form-shadow hidden">
        <h2 class="text-lg font-bold text-center text-gray-700 mb-6 flex items-center justify-center gap-2">
            <i class="fa fa-refresh text-primary"></i> Reset Password
        </h2>
        <form method="POST" action="" class="text-left">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-user"></i></span>
                    <input type="text" name="reset_user" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">New Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-lock"></i></span>
                    <input type="password" name="new_pass" required minlength="6" 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">Re-type Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-lock"></i></span>
                    <input type="password" name="re_pass" required minlength="6" 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-600">Security Answer</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-shield"></i></span>
                    <input type="text" name="sec_ans" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <button type="submit" name="reset" 
                class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-lg tracking-wide transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 shadow-lg hover:shadow-xl shadow-primary/25">
                RESET PASSWORD
            </button>
        </form>
    </div>


    <!-- CREATE ACCOUNT FORM -->
    <div id="createForm" class="bg-white p-8 rounded-2xl form-shadow hidden">
        <h2 class="text-lg font-bold text-center text-gray-700 mb-6 flex items-center justify-center gap-2">
            <i class="fa fa-user-plus text-primary"></i> Create New Account
        </h2>
        <form method="POST" action="" class="text-left">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">Username</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-user"></i></span>
                    <input type="text" name="new_user" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-lock"></i></span>
                    <input type="password" name="new_acc_pass" required minlength="6" 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-600">Security Question</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-question-circle"></i></span>
                    <select name="sec_qns" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                        <option value="What is the name of your first school?">What is the name of your first school?</option>
                        <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What city were you born in?">What city were you born in?</option>
                    </select>
                </div>
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-600">Security Answer</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-400"><i class="fa fa-shield"></i></span>
                    <input type="text" name="acc_sec_ans" required 
                        class="w-full pl-10 pr-3 py-2.5 input-border border-gray-300 bg-transparent focus:outline-none focus:border-primary transition duration-300">
                </div>
            </div>
            <button type="submit" name="create" 
                class="w-full bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-4 rounded-lg tracking-wide transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 shadow-lg hover:shadow-xl shadow-primary/25">
                CREATE ACCOUNT
            </button>
        </form>
    </div>


    <!-- LINKS -->
    <div class="text-center mt-6 text-sm">
        <a href="#" id="showReset" class="text-primary font-medium hover:underline">Forgot Password?</a>
        <span class="text-gray-400 mx-2">|</span>
        <a href="#" id="showCreate" class="text-primary font-medium hover:underline">Create Account</a>
        <span id="dividerBack" class="text-gray-400 mx-2 hidden">|</span>
        <a href="#" id="showLogin" class="text-primary font-medium hover:underline hidden">Back to Login</a>
    </div>

</div>

<script>
// Get elements
const loginForm = document.getElementById('loginForm');
const resetForm = document.getElementById('resetForm');
const createForm = document.getElementById('createForm');

const showReset = document.getElementById('showReset');
const showCreate = document.getElementById('showCreate');
const showLogin = document.getElementById('showLogin');
const dividerBack = document.getElementById('dividerBack');

// Show Reset Form
showReset.addEventListener('click', function(e){
    e.preventDefault();
    loginForm.classList.add('hidden');
    createForm.classList.add('hidden');
    resetForm.classList.remove('hidden');
    showReset.classList.add('hidden');
    showCreate.classList.add('hidden');
    showLogin.classList.remove('hidden');
    dividerBack.classList.remove('hidden');
});

// Show Create Form
showCreate.addEventListener('click', function(e){
    e.preventDefault();
    loginForm.classList.add('hidden');
    resetForm.classList.add('hidden');
    createForm.classList.remove('hidden');
    showReset.classList.add('hidden');
    showCreate.classList.add('hidden');
    showLogin.classList.remove('hidden');
    dividerBack.classList.remove('hidden');
});

// Show Login Form
showLogin.addEventListener('click', function(e){
    e.preventDefault();
    resetForm.classList.add('hidden');
    createForm.classList.add('hidden');
    loginForm.classList.remove('hidden');
     showReset.classList.remove('hidden');
    showCreate.classList.remove('hidden');
    showLogin.classList.add('hidden');
});
</script>

</body>
</html>