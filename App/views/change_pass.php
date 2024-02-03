
    <div class="content">
        <div>
            <img src="/B_INVENTORY/App/images/avatar.jpg" alt="Avatar" class="avatar">
        </div>

        <header>Hello <?php session_start();
                        echo $_SESSION["username"] ?>,</header>

        <div id="req">
            The password should be at least 8 characters in length and should include at least
            one upper case letter, one number, and one special character.
        </div>



        <form method="post" action="/B_inventory/App/model/login_db.php" autocomplete="off">

            <div class="field  space">

                <input type="password" required placeholder="New Password" name="new_pass" class="password">

            </div>
            <div class="field">

                <input type="password" required placeholder="Confirm Password" name="con_pass" class="password">

            </div>
            <input type="hidden" name="username" value=<?php echo $_SESSION["username"] ?>>

            <div class="field">

                <input type="submit" name="pass_update" value="Submit" class="login_btn">

            </div>
        </form>
    </div>

