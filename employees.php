
<?php include_once "header/active_employees.php";?>
<link rel="stylesheet" href="css/style_employees.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



<div class="whole-container">
    <div class="body-container">
            <div class="grid-container body-item">
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
            <div class="button-container body-item">
                <div class="grid-item">
                    <h3>Actions</h3>
                </div>

                <div class="grid-tem"></div>

                <div class="grid-item button1">
                    <span class="material-symbols-rounded">person_add</span>
                    <button>Add Employee</button>
                </div>

                <div class="grid-item button2">
                    <span class="material-symbols-rounded">download</span>
                    <button>Download Excel</button>
                </div>
            </div>
        </div>
<!--END OF TOP-->

    <div class="table">
    </div>
</div>