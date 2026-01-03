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

// Our Display Homes slider
const gallerySlider = new Swiper('.gallerySlider', {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    // autoplay: {
    //     delay: 6000,
    //     disableOnInteraction: false,
    // },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    }
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



// Filter
// Initializing sliders
function initSlider(minId, maxId, rangeId, minDisplay, maxDisplay, max, formatFn) {
    const minSlider = document.getElementById(minId);
    const maxSlider = document.getElementById(maxId);
    const range = document.getElementById(rangeId);
    const minBox = document.getElementById(minDisplay);
    const maxBox = document.getElementById(maxDisplay);

    function update() {
        let minVal = parseInt(minSlider.value);
        let maxVal = parseInt(maxSlider.value);

        // We do not allow crossing
        if (minVal > maxVal - (max * 0.02)) {
            minVal = maxVal - (max * 0.02);
            minSlider.value = minVal;
        }

        // Updating the text
        minBox.textContent = formatFn(minVal);
        maxBox.textContent = formatFn(maxVal);

        // Updating the red line
        const left = (minVal / max) * 100;
        const width = ((maxVal - minVal) / max) * 100;
        range.style.left = left + '%';
        range.style.width = width + '%';
    }

    minSlider.oninput = maxSlider.oninput = update;
    update();
}

// Formatting values
const formatPrice = (val) => '$ ' + val.toLocaleString('en-US');
const formatSize = (val) => val.toLocaleString('en-US') + ' ft²';

// Initialization Price
initSlider('priceMinSlider', 'priceMaxSlider', 'priceRange', 'priceMin', 'priceMax', 500000, formatPrice);

// Initialization Size
initSlider('sizeMinSlider', 'sizeMaxSlider', 'sizeRange', 'sizeMin', 'sizeMax', 5000, formatSize);

// Counters
function initCounter(valueId, downId, upId, min = 0, max = 10) {
    let count = parseInt(document.getElementById(valueId).textContent);
    const valueEl = document.getElementById(valueId);
    const downBtn = document.getElementById(downId);
    const upBtn = document.getElementById(upId);

    function update() {
        valueEl.textContent = count;
        downBtn.disabled = count <= min;
        upBtn.disabled = count >= max;
    }

    downBtn.onclick = () => {
        if (count > min) {
            count--;
            update();
        }
    };

    upBtn.onclick = () => {
        if (count < max) {
            count++;
            update();
        }
    };

    update();
}

initCounter('bedsValue', 'bedsDown', 'bedsUp');
initCounter('bathsValue', 'bathsDown', 'bathsUp');