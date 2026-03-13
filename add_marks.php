<?php
session_start();
include "db.php";
if(!isset($_SESSION['faculty_id'])){
header("Location: faculty_login.php");
exit();
}

$subject_id=$_SESSION['subject_id'];

if(isset($_POST['submit'])){
$student_id=$_POST['student_id'];
$internal=$_POST['internal'];
$external=$_POST['external'];
$total=$internal+$external;
$status=($total>=40)?"PASS":"FAIL";

mysqli_query($conn,"INSERT INTO marks (student_id,subject_id,internal,external,total,result_status)
VALUES ('$student_id','$subject_id','$internal','$external','$total','$status')
ON DUPLICATE KEY UPDATE internal='$internal',external='$external',total='$total',result_status='$status'");

echo "Saved Successfully!";
}

$students=mysqli_query($conn,"SELECT * FROM students");
?>

<form method="post">
<select name="student_id">
<?php
while($row=mysqli_fetch_assoc($students)){
echo "<option value='".$row['student_id']."'>".$row['name']."</option>";
}
?>
</select><br>
Internal: <input type="number" name="internal"><br>
External: <input type="number" name="external"><br>
<input type="submit" name="submit">
</form>