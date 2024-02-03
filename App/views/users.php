<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/login_db.php');


if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM LOGIN WHERE LOGIN_ID=$user_id");
    $record = mysqli_fetch_array($rec);
    $username = $record['LOGIN_USERNAME'];
    $role = $record['LOGIN_ROLE'];
    $user_id = $record['LOGIN_ID'];
}
?>

<table>
    <thead>
        <tr>
            <th>USERNAME</th>
            <th>ROLE</th>
            <th colspan="2">ACTION</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['LOGIN_USERNAME']; ?></td>
                <td><?php echo $row['LOGIN_ROLE']; ?></td>
                <td>
                    <a class="edit_btn" href="users.php?edit=<?php echo $row['LOGIN_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="reset_btn" href="../model/login_db.php?password_reset=<?php echo $row['LOGIN_ID']; ?>"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/login_db.php?user_del=<?php echo $row['LOGIN_ID']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
                
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/login_db.php" autocomplete="off">

    <input type="hidden" name="id" value="<?php echo $user_id; ?>">

    <div>
        <?php $role = array('1' => 'Admin', '2' => 'Cashier'); ?>
        <label>Role</label>
        <select name="role">
            <?php foreach ($role as $id => $value) { ?>

                <option value="<?php echo $value; ?>" <?php echo ($id == '2')

                                                            ? ' selected= "selected" ' : ''; ?>>

                    <?php echo $value; ?></option>


            <?php } ?>
        </select>


    </div>

    <div class="input-group">

        <label>USERNAME</label>
        <input class="input" type="text " required name="username" value="<?php echo $username; ?>">
        

    </div>
    

    <div class="input-group">

        <?php if ($edit_state == false) : ?>

            <button type="submit" name="register" class="btn">Register</button>
        <?php else : ?>
            <button type="submit" name="user_update" class="btn">Update</button>
        <?php endif ?>

    </div>
</form>