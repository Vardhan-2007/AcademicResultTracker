<?php
session_start();
include "db.php";
if(!isset($_SESSION['faculty_id'])){
header("Location: faculty_login.php");
exit();
}

$subject_id=$_SESSION['subject_id'];
$subject=mysqli_fetch_assoc(mysqli_query($conn,"SELECT subject_name FROM subjects WHERE subject_id=$subject_id"));

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as total FROM marks WHERE subject_id=$subject_id
"))['total'];

$pass = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as pass FROM marks 
WHERE subject_id=$subject_id AND result_status='PASS'
"))['pass'];

$fail = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as fail FROM marks 
WHERE subject_id=$subject_id AND result_status='FAIL'
"))['fail'];

$pass_percentage = $total > 0 ? round(($pass/$total)*100,2) : 0;

$avg_marks = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT AVG(total) as avg_marks FROM marks 
WHERE subject_id=$subject_id
"))['avg_marks'];
$avg_marks = round($avg_marks,2);

$highest = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT MAX(total) as highest FROM marks 
WHERE subject_id=$subject_id
"))['highest'];

$lowest = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT MIN(total) as lowest FROM marks 
WHERE subject_id=$subject_id
"))['lowest'];

$top_query = mysqli_query($conn,"
SELECT students.name, marks.total
FROM marks
JOIN students ON marks.student_id=students.student_id
WHERE marks.subject_id=$subject_id
ORDER BY marks.total DESC
LIMIT 3
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Faculty Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
html, body {
height:100%;
margin:0;
padding:0;
overflow-x:hidden;
}

.container-fluid{ padding:0 !important; }
.row{ margin:0 !important; }

body{
font-family:'Inter',sans-serif;
background: linear-gradient(135deg,#141e30,#243b55);
background-size:200% 200%;
animation: bgMove 10s ease infinite;
color:#f8fafc;
}

@keyframes bgMove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

.sidebar{
min-height:100vh;
position:fixed;
width:25%;
left:0;
top:0;
background:rgba(0,0,0,0.6);
backdrop-filter:blur(10px);
padding-top:40px;
}

.col-md-9{
margin-left:25%;
width:75%;
}

.sidebar h4{ color:white; font-weight:600; }

.sidebar a{
display:block;
color:#cbd5e1;
padding:12px 25px;
margin:10px 15px;
border-radius:12px;
text-decoration:none;
transition:0.3s;
}

.sidebar a:hover{
background:linear-gradient(90deg,#00c6ff,#0072ff);
color:white;
transform:translateX(6px);
}

.card-premium{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(15px);
border-radius:20px;
padding:28px;
box-shadow:0 15px 35px rgba(0,0,0,0.4);
transition:0.4s;
}

.card-premium:hover{ transform:translateY(-5px); }

.table{
color:#f8fafc;
border-collapse:separate;
border-spacing:0 10px;
}

.table tbody tr{
background:rgba(255,255,255,0.08);
transition:0.3s;
}

.table tbody tr:hover{
background:rgba(0,114,255,0.3);
transform:scale(1.01);
}

.pass-row{background:rgba(16,185,129,0.15);}
.fail-row{background:rgba(220,38,38,0.2);}
</style>
</head>

<body>

<div class="container-fluid">
<div class="row">

<div class="col-md-3 sidebar text-center">
<h4><i class="bi bi-person-workspace"></i> Faculty Panel</h4>
<a href="add_marks.php"><i class="bi bi-plus-circle"></i> Add Marks</a>
<a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="col-md-9 p-5">

<!-- SUBJECT HEADER -->
<div class="card-premium mb-4">
<h3><?php echo $subject['subject_name']; ?></h3>
<p class="text-secondary">Monitor student academic performance</p>

<div>
<span class="badge bg-primary">Total: <?php echo $total; ?></span>
<span class="badge bg-success">Pass: <?php echo $pass; ?></span>
<span class="badge bg-danger">Fail: <?php echo $fail; ?></span>
</div>
</div>

<!-- STUDENT TABLE -->
<div class="card-premium">
<h5 class="mb-4"><i class="bi bi-people-fill"></i> Student Results</h5>

<table class="table align-middle text-center">
<thead>
<tr>
<th>#</th>
<th>Student</th>
<th>Total</th>
<th>Status</th>
</tr>
</thead>
<tbody>

<?php
$query="SELECT students.name,marks.total,marks.result_status
FROM marks
JOIN students ON marks.student_id=students.student_id
WHERE marks.subject_id=$subject_id";

$res=mysqli_query($conn,$query);
$counter=1;

while($row=mysqli_fetch_assoc($res)){
$status=$row['result_status'];

if($status=="PASS"){
$badge="<span class='badge bg-success'>PASS</span>";
$rowClass="pass-row";
}else{
$badge="<span class='badge bg-danger'>FAIL</span>";
$rowClass="fail-row";
}

echo "<tr class='$rowClass'>
<td>".$counter++."</td>
<td>".$row['name']."</td>
<td>".$row['total']."</td>
<td>".$badge."</td>
</tr>";
}
?>

</tbody>
</table>
</div>

<!-- ===== ADVANCED ANALYTICS SECTION ===== -->

<div class="card-premium mt-5">

<h4 class="mb-4">
<i class="bi bi-graph-up-arrow"></i> Subject Analytics
</h4>

<div class="row text-center mb-4">

<div class="col-md-3">
<h6>Pass Percentage</h6>
<h3 class="text-success"><?php echo $pass_percentage; ?>%</h3>
</div>

<div class="col-md-3">
<h6>Average Marks</h6>
<h3><?php echo $avg_marks; ?></h3>
</div>

<div class="col-md-3">
<h6>Highest Marks</h6>
<h3 class="text-info"><?php echo $highest; ?></h3>
</div>

<div class="col-md-3">
<h6>Lowest Marks</h6>
<h3 class="text-danger"><?php echo $lowest; ?></h3>
</div>

</div>

<hr class="mb-4">

<h5 class="mb-3">🏆 Top 3 Students</h5>

<ul class="list-group mb-4">
<?php while($row=mysqli_fetch_assoc($top_query)){ ?>
<li class="list-group-item d-flex justify-content-between align-items-center">
<span><?php echo $row['name']; ?></span>
<span class="badge bg-primary"><?php echo $row['total']; ?></span>
</li>
<?php } ?>
</ul>

<canvas id="facultyChart"></canvas>

</div>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('facultyChart'), {
type:'bar',
data:{
labels:['Pass','Fail'],
datasets:[{
label:'Students',
data:[<?php echo $pass; ?>,<?php echo $fail; ?>],
backgroundColor:['#22c55e','#ef4444']
}]
},
options:{
responsive:true,
plugins:{ legend:{display:false} },
scales:{ y:{beginAtZero:true} }
}
});
</script>

</body>
</html>