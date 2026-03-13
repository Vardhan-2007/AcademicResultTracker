<?php
session_start();
include "db.php";

if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

// Dashboard Stats
$total_students = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as count FROM students"))['count'];
$total_faculty = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as count FROM faculty"))['count'];
$total_subjects = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as count FROM subjects"))['count'];
$total_backlogs = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as count FROM marks WHERE result_status='FAIL'"))['count'];

/* ===== NEW ANALYTICS ===== */

// Pass & Fail Count
$total_pass = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as count FROM marks WHERE result_status='PASS'"))['count'];

$total_fail = $total_backlogs;

// Subject-wise Performance
$subject_query = mysqli_query($conn,"
SELECT subjects.subject_name,
SUM(CASE WHEN marks.result_status='PASS' THEN 1 ELSE 0 END) as pass_count,
SUM(CASE WHEN marks.result_status='FAIL' THEN 1 ELSE 0 END) as fail_count
FROM marks
JOIN subjects ON marks.subject_id = subjects.subject_id
GROUP BY subjects.subject_name
");

$subjects = [];
$subject_pass = [];
$subject_fail = [];

while($row = mysqli_fetch_assoc($subject_query)){
    $subjects[] = $row['subject_name'];
    $subject_pass[] = $row['pass_count'];
    $subject_fail[] = $row['fail_count'];
}

// Department-wise Student Count
$dept_query = mysqli_query($conn,"
SELECT department, COUNT(*) as total 
FROM students 
GROUP BY department
");

$departments = [];
$dept_count = [];

while($row = mysqli_fetch_assoc($dept_query)){
    $departments[] = $row['department'];
    $dept_count[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* === YOUR ORIGINAL CSS UNCHANGED === */
html, body { height:100%; margin:0; padding:0; background:linear-gradient(135deg,#f5f7fa,#e4ecf5); }
.container-fluid { padding:0 !important; }
.row { margin:0 !important; }
.container-fluid > .row { min-height:100vh; }
body { font-family:'Segoe UI',sans-serif; animation:fadeInPage 0.8s ease-in-out; }
@keyframes fadeInPage{ from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);} }
.sidebar{ min-height:100vh; background:linear-gradient(180deg,#ff512f,#dd2476); padding-top:20px; transition:0.4s; box-shadow:4px 0 15px rgba(0,0,0,0.15);}
.sidebar a{ color:white; display:block; padding:12px 20px; text-decoration:none; font-weight:500; transition:0.3s;}
.sidebar a:hover{ background:rgba(255,255,255,0.2); border-radius:8px; transform:translateX(6px);}
.card-custom{ border-radius:15px; transition:0.3s; animation:slideUp 0.6s ease;}
@keyframes slideUp{ from{opacity:0; transform:translateY(20px);} to{opacity:1; transform:translateY(0);} }
.card-custom:hover{ transform:translateY(-8px); box-shadow:0 15px 30px rgba(0,0,0,0.25);}
.table tbody tr{ transition:0.3s ease;}
.table tbody tr:hover{ background:#f0f8ff !important; transform:scale(1.01);}
.fail-highlight{ background:linear-gradient(90deg,#ffb3b3,#ff4d4d) !important; color:#7a0000;}
.card{ backdrop-filter:blur(5px);}
</style>
</head>

<body class="bg-light">

<div class="container-fluid">
<div class="row">

<!-- SIDEBAR -->
<div class="col-md-3 sidebar text-white">
<h4 class="text-center">Admin Panel 👑</h4>
<a href="#">Dashboard</a>
<a href="logout.php">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="col-md-9 p-4">

<h2 class="mb-4">Dashboard Overview</h2>

<!-- STATS -->
<div class="row">
<div class="col-md-3">
<div class="card card-custom bg-primary text-white p-3 shadow">
<h5>Total Students</h5>
<h3><?php echo $total_students; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom bg-success text-white p-3 shadow">
<h5>Total Faculty</h5>
<h3><?php echo $total_faculty; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom bg-warning text-dark p-3 shadow">
<h5>Total Subjects</h5>
<h3><?php echo $total_subjects; ?></h3>
</div>
</div>

<div class="col-md-3">
<div class="card card-custom bg-danger text-white p-3 shadow">
<h5>Total Backlogs</h5>
<h3><?php echo $total_backlogs; ?></h3>
</div>
</div>
</div>

<!-- STUDENTS TABLE -->
<div class="card card-custom mt-5 shadow">
<div class="card-header bg-primary text-white">All Students</div>
<div class="card-body">
<table class="table table-bordered">
<tr class="table-dark">
<th>ID</th><th>Name</th><th>Roll</th><th>Email</th><th>Department</th>
</tr>
<?php
$res = mysqli_query($conn,"SELECT * FROM students");
while($row = mysqli_fetch_assoc($res)){
echo "<tr>
<td>".$row['student_id']."</td>
<td>".$row['name']."</td>
<td>".$row['roll_no']."</td>
<td>".$row['email']."</td>
<td>".$row['department']."</td>
</tr>";
}
?>
</table>
</div>
</div>

<!-- FACULTY TABLE -->
<div class="card card-custom mt-5 shadow">
<div class="card-header bg-success text-white">All Faculty</div>
<div class="card-body">
<table class="table table-bordered">
<tr class="table-dark">
<th>ID</th><th>Name</th><th>Email</th><th>Subject ID</th>
</tr>
<?php
$res = mysqli_query($conn,"SELECT * FROM faculty");
while($row = mysqli_fetch_assoc($res)){
echo "<tr>
<td>".$row['faculty_id']."</td>
<td>".$row['name']."</td>
<td>".$row['email']."</td>
<td>".$row['subject_id']."</td>
</tr>";
}
?>
</table>
</div>
</div>

<!-- MARKS TABLE -->
<div class="card card-custom mt-5 shadow">
<div class="card-header bg-warning">All Results</div>
<div class="card-body">
<table class="table table-bordered">
<tr class="table-dark">
<th>Student</th><th>Subject</th><th>Total</th><th>Status</th>
</tr>
<?php
$query = "SELECT students.name, subjects.subject_name, marks.total, marks.result_status
FROM marks
JOIN students ON marks.student_id = students.student_id
JOIN subjects ON marks.subject_id = subjects.subject_id";

$res = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($res)){
$class = ($row['result_status']=="FAIL") ? "fail-highlight" : "";
echo "<tr class='$class'>
<td>".$row['name']."</td>
<td>".$row['subject_name']."</td>
<td>".$row['total']."</td>
<td>".$row['result_status']."</td>
</tr>";
}
?>
</table>
</div>
</div>

<!-- ===== NEW ANALYTICS SECTION ===== -->

<div class="card card-custom mt-5 shadow">
<div class="card-header bg-dark text-white">Pass vs Backlog</div>
<div class="card-body">
<canvas id="pieChart"></canvas>
</div>
</div>

<div class="card card-custom mt-5 shadow">
<div class="card-header bg-info text-white">Subject Performance</div>
<div class="card-body">
<canvas id="barChart"></canvas>
</div>
</div>

<div class="card card-custom mt-5 shadow">
<div class="card-header bg-secondary text-white">Department Distribution</div>
<div class="card-body">
<canvas id="deptChart"></canvas>
</div>
</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Pie
new Chart(document.getElementById('pieChart'), {
type:'pie',
data:{labels:['Pass','Backlog'],
datasets:[{data:[<?php echo $total_pass; ?>,<?php echo $total_fail; ?>],
backgroundColor:['#28a745','#dc3545']}]}
});

// Subject
new Chart(document.getElementById('barChart'), {
type:'bar',
data:{labels:<?php echo json_encode($subjects); ?>,
datasets:[
{label:'Pass',data:<?php echo json_encode($subject_pass); ?>,backgroundColor:'#28a745'},
{label:'Backlog',data:<?php echo json_encode($subject_fail); ?>,backgroundColor:'#dc3545'}
]}
});

// Department
new Chart(document.getElementById('deptChart'), {
type:'bar',
data:{labels:<?php echo json_encode($departments); ?>,
datasets:[{label:'Students',data:<?php echo json_encode($dept_count); ?>,
backgroundColor:'#007bff'}]}
});
</script>

</body>
</html>