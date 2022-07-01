<?php include('connection.php');

$output= array();
$sql = "SELECT * FROM doctorapp";

$totalQuery = mysqli_query($con,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);
$columns = array(
	0 => 'fname',
	1 => 'lname',
	2 => 'email',
	3 => 'contact',
	4 => 'docapp',
    5 => 'timeslot',

);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE fname like '%".$search_value."%'";
    $sql .= " OR lname like '%".$search_value."%'";
	$sql .= " OR email like '%".$search_value."%'";
	$sql .= " OR contact like '%".$search_value."%'";
	$sql .= " OR docapp like '%".$search_value."%'";
    $sql .= " OR timeslot like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($con,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['fname'];
	$sub_array[] = $row['lname'];
	$sub_array[] = $row['email'];
	$sub_array[] = $row['contact'];
	$sub_array[] = $row['docapp'];
    $sub_array[] = $row['timeslot'];
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['fname'].'"  class="btn btn-info btn-sm editbtn" >Edit</a>  <a href="javascript:void();" data-id="'.$row['fname'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
