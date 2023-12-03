<?php
include_once("db.php");
$sql = "SELECT * FROM attendance_log INNER JOIN employee ON attendance_log.emp_id=employee.employee_code INNER JOIN workstation ON attendance_log.workstation_id=workstation.workstation_id INNER JOIN designation ON attendance_log.emp_designation_id=designation.designation_id INNER JOIN organization_category ON attendance_log.org_category=organization_category.category_id LIMIT 3";

$resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($conn));
$data = array();
while( $rows = mysqli_fetch_assoc($resultset) ) {
	$data[] = $rows;
}
$results = array(
	"sEcho" => 1,
"iTotalRecords" => count($data),
"iTotalDisplayRecords" => count($data),
  "aaData"=>$data);
echo json_encode($results);
exit;

?>