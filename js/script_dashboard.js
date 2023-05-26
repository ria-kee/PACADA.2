
// window.onload = function() {
//     var randomText = document.getElementById('randomText');
//     var texts = [
//         'Have a nice day at work.',
//         'Enjoy your day!',
//         'Stay productive!',
//         'Make it a great day!',
//         'Wishing you a successful day.',
//         'Hope you have an amazing day!',
//         'Stay focused and motivated!',
//         'May your day be filled with success.',
//         'Sending positive vibes for your day!',
//         'Remember to take breaks and relax.'
//     ];
//
//     var randomIndex = Math.floor(Math.random() * texts.length);
//     randomText.textContent = texts[randomIndex];
// };

window.onload = function() {
    var randomText = document.getElementById('randomText');
    var texts = [
        'Have a nice day at work.',
        'Enjoy your day!',
        'Stay productive!',
        'Make it a great day!',
        'Wishing you a successful day.',
        'Hope you have an amazing day!',
        'Stay focused and motivated!',
        'May your day be filled with success.',
        'Sending positive vibes for your day!',
        'Remember to take breaks and relax.'
    ];

    // Get the current date
    var date = new Date();
    // Use the date to generate a random index
    var randomIndex = date.getDate() % texts.length;
    randomText.textContent = texts[randomIndex];
};



// Set the name variable
var name = "Jaz";

// Array of greetings
var greetings = [
    "Kamusta, " + name + "!",
    "Hello, " + name + "!",
    "Hi there, " + name + "!",
    "Greetings, " + name + "!",
    "Best regards, " + name + "!",
    "Nice to see you, " + name + "!",
    "Hey there, " + name + "!",
    "Hola, " + name + "!",
    "Bonjour, " + name + "!",
    "Welcome, " + name + "!",
    "Good day, " + name + "!",
    "How are you doing, " + name + "?",
    "Hey, " + name + ", what's new?"
];

// Get the current date
var date = new Date();
// Use the date to generate a random index
var randomIndex = date.getDate() % greetings.length;
// Select the random greeting
var randomGreeting = greetings[randomIndex];

// Get the <h2> element by its ID
var greetingElement = document.getElementById("greeting");

// Set the text of the <h2> element to the random greeting
greetingElement.innerHTML = randomGreeting;

// Update the name in the <h2> element
document.getElementById("name").textContent = name;














// // Set the name variable
// var name = "Jaz";
//
// // Array of greetings
// var greetings = [
//     "Hello, " + name + "!",
//     "Hi there, " + name + "!",
//     "Greetings, " + name + "!",
//     "Best regards, " + name + "!",
//     "Nice to see you, " + name + "!",
//     "Hey there, " + name + "!",
//     "Hola, " + name + "!",
//     "Bonjour, " + name + "!",
//     "Welcome, " + name + "!",
//     "Good day, " + name + "!",
//     "How are you doing, " + name + "?",
//     "Hey, " + name + ", what's new?"
// ];
//
// // Get the <h2> element by its ID
// var greetingElement = document.getElementById("greeting");
//
// // Select a random greeting
// var randomGreeting = greetings[Math.floor(Math.random() * greetings.length)];
//
// // Set the text of the <h2> element to the random greeting
// greetingElement.innerHTML = randomGreeting;
//
// // Update the name in the <h2> element
// document.getElementById("name").textContent = name;












const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");

menuBtn.addEventListener('click',() =>{
    sideMenu.style.display = 'block';
})

closeBtn.addEventListener('click',() =>{
    sideMenu.style.display = 'none';
})

