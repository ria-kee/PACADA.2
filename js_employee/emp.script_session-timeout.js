// Set the inactivity timeout duration (in milliseconds)
const inactivityTimeoutDuration = 15 * 60 * 1000; // 15 minutes
// const inactivityTimeoutDuration = 1 * 60 * 1000; // 1 minute


// Variable to store the timeout ID
let inactivityTimeoutId;

// Function to reset the inactivity timeout
function resetInactivityTimeout() {
    clearTimeout(inactivityTimeoutId);
    inactivityTimeoutId = setTimeout(logout, inactivityTimeoutDuration);
}

// Function to handle user activity
function handleUserActivity() {
    resetInactivityTimeout();
    // Additional code to handle user activity, if needed
}

// Function to handle logout or session destruction
function logout() {
    // Perform session destruction or logout actions using AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'employee_logout.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Redirect to the login page after successful logout
            window.location.href = 'employee-login.php';
        } else {
            console.error('Logout failed.');
        }
    };
    xhr.send();
}

// Event listeners to track user activity
document.addEventListener('mousemove', handleUserActivity);
document.addEventListener('mousedown', handleUserActivity);
document.addEventListener('keypress', handleUserActivity);
document.addEventListener('touchstart', handleUserActivity);

// Start the inactivity timeout on page load
resetInactivityTimeout();
