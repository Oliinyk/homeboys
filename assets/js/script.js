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


// Filter
document.addEventListener('DOMContentLoaded', function() {
    // Ініціалізація всіх слайдерів
    const sliderGroups = document.querySelectorAll('.filter-group');
    
    sliderGroups.forEach(group => {
        const minSlider = group.querySelector('.js-slider-min');
        const maxSlider = group.querySelector('.js-slider-max');
        
        if (!minSlider || !maxSlider) return;
        
        const range = group.querySelector('.slider-range');
        const minBox = group.querySelector('.value-box:first-of-type');
        const maxBox = group.querySelector('.value-box:last-of-type');
        const max = parseInt(maxSlider.max);
        
        // Визначаємо тип слайдера по name
        const isPrice = minSlider.name.includes('price');
        const formatFn = isPrice 
            ? (val) => '$ ' + val.toLocaleString('en-US')
            : (val) => val.toLocaleString('en-US') + ' ft²';
        
        function updateSlider() {
            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);
            
            // Не дозволяємо перетинатися
            if (minVal > maxVal - (max * 0.02)) {
                minVal = maxVal - (max * 0.02);
                minSlider.value = minVal;
            }
            
            // Оновлюємо текст
            if (minBox) minBox.textContent = formatFn(minVal);
            if (maxBox) maxBox.textContent = formatFn(maxVal);
            
            // Оновлюємо червону лінію
            if (range) {
                const left = (minVal / max) * 100;
                const width = ((maxVal - minVal) / max) * 100;
                range.style.left = left + '%';
                range.style.width = width + '%';
            }
        }
        
        minSlider.addEventListener('input', updateSlider);
        maxSlider.addEventListener('input', updateSlider);
        updateSlider();
    });
    
    // Ініціалізація всіх лічильників
    const counterGroups = document.querySelectorAll('.counter-group');
    
    counterGroups.forEach(group => {
        const input = group.querySelector('.js-counter-value');
        const downBtn = group.querySelector('.js-counter-down');
        const upBtn = group.querySelector('.js-counter-up');
        
        if (!input || !downBtn || !upBtn) return;
        
        const min = parseInt(input.min) || 0;
        const max = parseInt(input.max) || 10;
        
        function updateButtons() {
            const count = parseInt(input.value);
            downBtn.disabled = count <= min;
            upBtn.disabled = count >= max;
        }
        
        downBtn.addEventListener('click', function() {
            const current = parseInt(input.value);
            if (current > min) {
                input.value = current - 1;
                updateButtons();
            }
        });
        
        upBtn.addEventListener('click', function() {
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
                updateButtons();
            }
        });
        
        updateButtons();
    });
});