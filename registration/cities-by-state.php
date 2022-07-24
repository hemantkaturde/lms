<?php
include_once('../db/config.php');
$state_id = $_POST["state_id"];
$sql = "SELECT * FROM tbl_cities where state_id=$state_id" ;
$result = $conn->query($sql);

?>
<option value="">Select City</option>
<?php
while($row = mysqli_fetch_array($result)) {
?>
    <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
<?php
}
?>