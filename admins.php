
<?php include_once "header/active_admins.php";?>
<link rel="stylesheet" href="css/style_admins.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<div class="grid-container">
    <div class="grid-item">
        <h3>What are you looking for?</h3>
    </div>

    <div class="grid-item">
        <h3>Category</h3>
    </div>

    <div class="grid-item">

    </div>

    <div class="grid-item">
        <div class="search">
        <span class="material-symbols-rounded">search</span>

        <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
        </div>
    </div>

    <div class="grid-item">
        <div class="dropdown">
        <select class="category">
            <option value="option1" selected>All</option>
            <option value="option2">Name</option>
            <option value="option3">Email</option>
            <option value="option3" >Department</option>
        </select>
        </div>
    </div>

    <div class="grid-item">
        <button>Search</button>
    </div>

</div>


