
const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

menuBtn.addEventListener('click',() =>{
    sideMenu.style.display = 'block';
})

closeBtn.addEventListener('click',() =>{
    sideMenu.style.display = 'none';
})

function displayDateTime() {
    var currentDate = new Date();
    var dateString = currentDate.toDateString();
    var timeString = currentDate.toLocaleTimeString();

    document.getElementById("date").innerHTML = dateString;
    document.getElementById("time").innerHTML = timeString;
}

// Call the function once the page is loaded
window.onload = displayDateTime;