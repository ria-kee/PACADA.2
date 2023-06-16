
<style>
    .profile{
        z-index: 9999;
        position: relative;
        justify-self: end ;
        display: flex;
        gap: 1rem;
        text-align: right;
        color: var(--color-light);
    }

    .profile:hover{
        cursor: pointer;
    }
</style>


<div class="profile" onclick="redirectToNewPage()">
    <div class="info">
        <p>Hello, <b><?php echo explode(' ', $_SESSION['admin_FirstName'])[0]; ?>!</b></p>
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


<script>
    function redirectToNewPage() {
        window.location.href = 'profile.php';
    }
</script>
