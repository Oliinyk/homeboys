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


// --- Initialize Swiper ---
var swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// From Our People swiper
var swiper2 = new Swiper(".mySwiper2", {
    spaceBetween: 30,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
        enabled: false,
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
            spaceBetween: 40,
            navigation: {
                enabled: true,
            },
        },
    },
});

// Blog swiper
var swiper3 = new Swiper(".mySwiper3", {
    slidesPerView: 1.2,
    spaceBetween: 20,
    centeredSlides: true,
    // initialSlide: 0,
    navigation: {
        nextEl: ".swiper-blog-button-next",
        prevEl: ".swiper-blog-button-prev",
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
            spaceBetween: 30,
            centeredSlides: false,
        },
        992: {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: false,
        },
    },
});


// filter
function updateSlider(minInput, maxInput, rangeEl, maxValue, format) {
    const min = +minInput.value;
    const max = +maxInput.value;
    const left = (min / maxValue) * 100;
    const width = ((max - min) / maxValue) * 100;
    rangeEl.style.left = left + '%';
    rangeEl.style.width = width + '%';
}

// Price slider
const priceMin = document.getElementById('priceMinSlider');
const priceMax = document.getElementById('priceMaxSlider');
const priceRange = document.getElementById('priceRange');

priceMin.oninput = priceMax.oninput = () => updateSlider(priceMin, priceMax, priceRange, 500000);
updateSlider(priceMin, priceMax, priceRange, 500000);

// Size slider
const sizeMin = document.getElementById('sizeMinSlider');
const sizeMax = document.getElementById('sizeMaxSlider');
const sizeRange = document.getElementById('sizeRange');

sizeMin.oninput = sizeMax.oninput = () => updateSlider(sizeMin, sizeMax, sizeRange, 5000);
updateSlider(sizeMin, sizeMax, sizeRange, 5000);