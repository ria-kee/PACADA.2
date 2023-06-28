// Get the parent <ul> element
const navList = document.querySelector('nav ul');

// Add click event listener to the parent <ul> element
navList.addEventListener('click', (event) => {
    // Check if the clicked element is an <a> tag
    if (event.target.tagName === 'A') {
        // Remove active class from all <li> elements
        navItems.forEach(item => {
            item.classList.remove('active');
        });

        // Add active class to the parent <li> element of the clicked <a> tag
        event.target.parentNode.classList.add('active');
    }
});
