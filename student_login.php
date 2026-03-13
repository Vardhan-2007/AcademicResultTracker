<?php
include "db.php";
session_start();
$error="";

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $query=mysqli_query($conn,"SELECT * FROM students WHERE email='$email' AND password='$password'");
    if(mysqli_num_rows($query)>0){
        $row=mysqli_fetch_assoc($query);
        $_SESSION['student_id']=$row['student_id'];
        header("Location: student_dashboard.php");
        exit();
    } else {
        $error="Invalid Student Credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

html,body{
height:100%;
margin:0;
font-family:'Segoe UI',sans-serif;
overflow:hidden;
}

/* Animated Gradient */
body{
background:linear-gradient(-45deg,#1e3c72,#2a5298,#0f2027,#203a43);
background-size:400% 400%;
animation:gradientFlow 12s ease infinite;
display:flex;
justify-content:center;
align-items:center;
}

@keyframes gradientFlow{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

/* Floating Light Blobs */
body::before, body::after{
content:"";
position:absolute;
width:350px;
height:350px;
border-radius:50%;
background:radial-gradient(circle,rgba(255,255,255,0.2),transparent 60%);
animation:floatBlob 10s ease-in-out infinite;
}

body::before{ top:-100px; left:-100px; }
body::after{ bottom:-100px; right:-100px; animation-delay:5s; }

@keyframes floatBlob{
0%{transform:translateY(0px);}
50%{transform:translateY(40px);}
100%{transform:translateY(0px);}
}

/* Login Card */
.login-card{
position:relative;
background:rgba(255,255,255,0.15);
backdrop-filter:blur(20px);
padding:40px;
border-radius:20px;
width:380px;
box-shadow:0 20px 50px rgba(0,0,0,0.5);
animation:cardEnter 1s ease;
transition:transform 0.3s ease;
}

/* 3D Tilt Effect */
.login-card:hover{
transform:translateY(-5px) scale(1.02);
}

@keyframes cardEnter{
from{opacity:0; transform:scale(0.9);}
to{opacity:1; transform:scale(1);}
}

.login-card h3{
text-align:center;
color:white;
margin-bottom:25px;
letter-spacing:1px;
}

/* Inputs */
.form-control{
border-radius:12px;
background:rgba(255,255,255,0.25);
border:none;
color:white;
padding:12px;
transition:all 0.3s ease;
}

.form-control::placeholder{color:#e0e0e0;}

.form-control:focus{
background:rgba(255,255,255,0.35);
box-shadow:0 0 15px rgba(255,255,255,0.6);
color:white;
transform:scale(1.02);
}

/* Button */
.btn-login{
background:linear-gradient(90deg,#00c6ff,#0072ff);
border:none;
border-radius:12px;
width:100%;
padding:12px;
color:white;
font-weight:600;
letter-spacing:1px;
transition:all 0.3s ease;
}

.btn-login:hover{
transform:translateY(-4px);
box-shadow:0 15px 30px rgba(0,114,255,0.6);
}

.btn-login:active{
transform:scale(0.96);
}

/* Error */
.error-msg{
color:#ffd6d6;
text-align:center;
margin-bottom:15px;
}

</style>
</head>

<body>

<div class="login-card">

<h3>Student Login</h3>

<?php if($error!=""){ ?>
<div class="error-msg"><?php echo $error; ?></div>
<?php } ?>

<form method="POST">
<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="Email" required>
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<button type="submit" name="login" class="btn btn-login">Login</button>
</form>

</div>

</body>
</html>