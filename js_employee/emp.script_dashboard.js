
$('#leaveBalanceTable').DataTable({
    serverSide: true,
    processing: true,
    paging: false,
    pageLength: 10,
    lengthChange: false,
    order: [],
    searching: false,
    info: false,
    ajax: {
        url: 'inc.employee_fetch_leave.php',
        type: 'post',
    },
    columnDefs: [{
        targets: '_all', // Target all columns
        orderable: false, // Disable sorting for all columns
    }],
});



$('#timeoffBalanceTable').DataTable({
    serverSide: true,
    processing: true,
    paging: false,
    pageLength: 10,
    lengthChange: false,
    order: [],
    searching: false,
    info: false,
    ajax: {
        url: 'inc.employee_fetch_timeoff.php',
        type: 'post',
    },
    columnDefs: [{
        targets: '_all', // Target all columns
        orderable: false, // Disable sorting for all columns
    }],
});

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
var name = adminFirstName;

// Array of greetings
var greetings = [
    "Kamusta, " + name + "?",
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


