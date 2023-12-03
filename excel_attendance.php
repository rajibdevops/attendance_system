<?php // Load the database configuration file 
require('db.php');
 
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "attendance-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('Log ID', 'Employee Code','Employee Name', 'Designation', 'Org type', 'workstation', 'In/Out time',  'geo-location','Employee Remarks','Supervisor note category','Supervisor Note'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $con->query("SELECT * FROM attendance_log INNER JOIN employee ON attendance_log.emp_id=employee.employee_code INNER JOIN workstation ON attendance_log.workstation_id=workstation.workstation_id INNER JOIN designation ON attendance_log.emp_designation_id=designation.designation_id INNER JOIN organization_category ON attendance_log.org_category=organization_category.category_id"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc()){  
        $lineData = array($row['log_id'],$row['employee_code'], $row['employee_name'], $row['designation'], $row['category'], $row['workstation'], $row['emp_time'], $row['emp_geo'],$row['remarks'],$row['supervisor_note_category'],$row['supervisor_note']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;
?>