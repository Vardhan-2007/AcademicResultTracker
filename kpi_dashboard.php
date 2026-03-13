<?php
include "db.php";

/* ===== GLOBAL KPIs ===== */

$total_students = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM students"))['total'];

$total_branches = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(DISTINCT department) as total FROM students"))['total'];

$total_backlogs = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM marks WHERE result_status='FAIL'"))['total'];

/* ===== BRANCH LIST ===== */
$branches = mysqli_query($conn,"SELECT DISTINCT department FROM students");
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Performance Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== BACKGROUND ===== */
body{
margin:0;
height:100vh;
display:flex;
align-items:center;
justify-content:center;
font-family:'Segoe UI',sans-serif;
background: radial-gradient(circle at top right,#1f3c88,#070b34);
color:white;
}

/* ===== MAIN CARD ===== */
.main-card{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(20px);
border-radius:25px;
padding:50px;
width:900px;
box-shadow:0 20px 60px rgba(0,0,0,0.5);
animation:fadeIn 0.8s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

/* ===== KPI BOX ===== */
.kpi-box{
padding:30px;
border-radius:20px;
text-align:center;
font-weight:600;
transition:0.4s;
}

.kpi-box:hover{
transform:translateY(-8px);
box-shadow:0 15px 35px rgba(0,0,0,0.4);
}

.kpi1{background:linear-gradient(135deg,#4e73df,#1cc88a);}
.kpi2{background:linear-gradient(135deg,#f6c23e,#ff8c00);}
.kpi3{background:linear-gradient(135deg,#e74a3b,#ff4d6d);}

/* ===== BRANCH BADGES ===== */
.branch-badge{
background:rgba(255,255,255,0.15);
color:white;
padding:8px 14px;
border-radius:20px;
margin:5px;
display:inline-block;
font-weight:500;
transition:0.3s;
}

.branch-badge:hover{
background:rgba(255,255,255,0.3);
transform:translateY(-3px);
}

/* ===== BUTTON ===== */
.enter-btn{
background:linear-gradient(90deg,#00c6ff,#0072ff);
border:none;
padding:12px 30px;
border-radius:30px;
font-weight:600;
color:white;
transition:0.3s;
}

.enter-btn:hover{
transform:translateY(-3px);
box-shadow:0 10px 25px rgba(0,114,255,0.5);
}

.subtitle{
opacity:0.7;
}

</style>
</head>

<body>

<div class="main-card">

<h2 class="mb-4">🎓 Student Performance Dashboard</h2>

<div class="row mb-4">

<div class="col-md-4">
<div class="kpi-box kpi1">
<h5>Total Students</h5>
<h1><?php echo $total_students; ?></h1>
</div>
</div>

<div class="col-md-4">
<div class="kpi-box kpi2">
<h5>Total Branches</h5>
<h1><?php echo $total_branches; ?></h1>
</div>
</div>

<div class="col-md-4">
<div class="kpi-box kpi3">
<h5>Backlogs</h5>
<h1><?php echo $total_backlogs; ?></h1>
</div>
</div>

</div>

<!-- ===== AVAILABLE BRANCHES SECTION ===== -->

<div class="text-center mb-4">
<h6 class="mb-3">Available Branches:</h6>

<?php while($row=mysqli_fetch_assoc($branches)){ ?>
<span class="branch-badge">
<?php echo $row['department']; ?>
</span>
<?php } ?>

</div>

<div class="text-center p-4" style="background:rgba(255,255,255,0.05); border-radius:15px;">
<h5>Enter Smart Student Result Management System</h5>
<p class="subtitle">Explore toppers, averages and backlog details.</p>

<a href="index.php" class="btn enter-btn mt-3">
Enter System →
</a>
</div>

</div>

</body>
</html>