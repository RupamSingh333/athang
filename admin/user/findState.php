<?php
include("../../system_config.php");
$country = $_REQUEST['country'];
$query = "SELECT district_id,district_name,state_id FROM district WHERE state_id='$country'";
$result = mysqli_query($link, $query);
?>
<form action="" method="post" required class="form-horizontal">

    <select name="user_district" class="form-control">
        <option>Select District</option>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <option value=<?php echo $row['district_id'] ?>><?php echo $row['district_name'] ?></option>
        <?php } ?>
    </select>

</form>