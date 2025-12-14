//  HEADER
const burger = document.getElementById('burgerBtn');
const nav = document.getElementById('mainNav');
const closeNav = document.getElementById('closeNav');
const overlay = document.getElementById('navOverlay');
const dropdowns = document.querySelectorAll('.has-dropdown > button');

// Open mobile menu
burger.addEventListener('click', () => {
    nav.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// Close mobile menu
function closeMobileMenu() {
    nav.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
}

closeNav.addEventListener('click', closeMobileMenu);
overlay.addEventListener('click', closeMobileMenu);

// Dropdown toggle on click (works for both mobile and desktop)
dropdowns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation();
        const parent = btn.parentElement;
        const isOpen = parent.classList.contains('open');
        
        // Close all other dropdowns
        document.querySelectorAll('.has-dropdown').forEach(dropdown => {
            if (dropdown !== parent) {
                dropdown.classList.remove('open');
            }
        });
        
        // Toggle current dropdown
        parent.classList.toggle('open');
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('.has-dropdown')) {
        document.querySelectorAll('.has-dropdown').forEach(dropdown => {
            dropdown.classList.remove('open');
        });
    }
});

// Close mobile menu on window resize to desktop
window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
        closeMobileMenu();
    }
});