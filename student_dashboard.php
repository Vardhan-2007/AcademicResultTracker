<?php
session_start();
include "db.php";

if(!isset($_SESSION['student_id'])){
header("Location: student_login.php");
exit();
}

$id=$_SESSION['student_id'];
$student=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE student_id=$id"));

/* ===== ANALYTICS ===== */

$result_query=mysqli_query($conn,"
SELECT total,result_status 
FROM marks 
WHERE student_id=$id
");

$total_subjects=0;
$pass=0;
$fail=0;
$total_marks=0;

while($row=mysqli_fetch_assoc($result_query)){
$total_subjects++;
$total_marks += $row['total'];

if($row['result_status']=="PASS"){
$pass++;
}else{
$fail++;
}
}

$average=$total_subjects>0?round($total_marks/$total_subjects,2):0;
$cgpa=round($average/10,2);
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

<style>
    /* ===== REMOVE LEFT GAP COMPLETELY ===== */

body {
    margin: 0;
    overflow-x: hidden;
}

/* Remove bootstrap container spacing */
.container-fluid {
    padding: 0 !important;
}

.row {
    margin: 0 !important;
}

/* Make sidebar fixed */
.sidebar {
    min-height: 100vh;
    position: fixed;
    width: 25%;
    left: 0;
    top: 0;
}

/* Push main content beside sidebar */
.col-md-9 {
    margin-left: 25%;
    width: 75%;
}
/* ===== FIX WHITE SPACE ISSUE ===== */
html, body {
height:100%;
margin:0;
padding:0;
background:linear-gradient(135deg,#f5f7fa,#e4ecf5);
}

.container-fluid {
padding:0 !important;
}

.row {
margin:0 !important;
}

.container-fluid > .row {
min-height:100vh;
}

/* Ensure sidebar full height */
.sidebar{
min-height:100vh;
}
</style>

</head>

<body>

<div class="container-fluid">
<div class="row">

<div class="col-md-3 sidebar">
<h4 class="text-white text-center">Student Panel</h4>
<a href="#">Dashboard</a>
<a href="logout.php">Logout</a>
</div>

<div class="col-md-9 p-4">

<div class="card card-custom p-4 shadow">
<h3>Welcome, <?php echo $student['name']; ?> 👋</h3>
<p><strong>Roll:</strong> <?php echo $student['roll_no']; ?></p>
<p><strong>Email:</strong> <?php echo $student['email']; ?></p>
</div>

<div class="card card-custom mt-4 p-4 shadow">
<h4>Your Results</h4>

<table class="table table-bordered mt-3">
<tr class="table-dark">
<th>Subject</th>
<th>Total</th>
<th>Status</th>
</tr>

<?php
$query="SELECT subjects.subject_name,marks.total,marks.result_status 
FROM marks
JOIN subjects ON marks.subject_id=subjects.subject_id
WHERE marks.student_id=$id";

$res=mysqli_query($conn,$query);
while($row=mysqli_fetch_assoc($res)){
$class=($row['result_status']=="FAIL")?"fail-highlight":"";
echo "<tr class='$class'>
<td>".$row['subject_name']."</td>
<td>".$row['total']."</td>
<td>".$row['result_status']."</td>
</tr>";
}
?>
</table>

</div>

<!-- ===== PERFORMANCE SUMMARY ===== -->

<div class="card card-custom mt-5 p-4 shadow">
<h4>Performance Summary</h4>

<div class="row text-center mt-3">
<div class="col-md-3">
<h5>Total Subjects</h5>
<p><?php echo $total_subjects; ?></p>
</div>

<div class="col-md-3">
<h5>Pass</h5>
<p class="text-success"><?php echo $pass; ?></p>
</div>

<div class="col-md-3">
<h5>Backlogs</h5>
<p class="text-danger"><?php echo $fail; ?></p>
</div>

<div class="col-md-3">
<h5>Average Marks</h5>
<p><?php echo $average; ?></p>
</div>
</div>

<hr>

<h5>CGPA: <strong><?php echo $cgpa; ?></strong></h5>

<?php if($fail>0){ ?>
<div class="alert alert-danger mt-3">
⚠ You have <?php echo $fail; ?> backlog(s). Please improve your performance.
</div>
<?php } ?>

<canvas id="studentChart" class="mt-4"></canvas>

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('studentChart'), {
type:'pie',
data:{
labels:['Pass','Backlog'],
datasets:[{
data:[<?php echo $pass; ?>,<?php echo $fail; ?>],
backgroundColor:['#28a745','#dc3545']
}]
}
});
</script>

</body>
</html>