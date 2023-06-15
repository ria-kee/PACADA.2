<div class="profile">
    <div class="info">
        <p>Hello, <b><?php echo $_SESSION['admin_FirstName']; ?>!</b></p>
        <small class="text-muted">
            <?php
            if($_SESSION['is_superadmin'] === 1){
                echo 'Super Administrator';
            }
            else{
                echo 'Administrator';
            }

            ?></small>
    </div>
    <div class="profile-photo">
        <img src="data:image/jpeg;base64,<?php echo $_SESSION['admin_Profile']; ?>" alt="User Profile">
    </div>
</div>