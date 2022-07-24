<?php
include_once('../db/config.php');
$country_id = $_POST["country_id"];
$sql = "SELECT * FROM tbl_states where country_id=$country_id" ;
$result = $conn->query($sql);

?>
<option value="">Select State</option>
<?php
while($row = mysqli_fetch_array($result)) {
?>
    <option value="<?php echo $row["id"];?>"><?php echo $row["name"];?></option>
<?php
}
?>