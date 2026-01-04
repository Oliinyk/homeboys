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
    // Форматування значень
    const formatters = {
        price: (val) => '$ ' + parseInt(val).toLocaleString('en-US'),
        size: (val) => parseInt(val).toLocaleString('en-US') + ' ft²'
    };

    // Ініціалізація всіх слайдерів
    document.querySelectorAll('.filter-group').forEach(group => {
        const inputs = group.querySelectorAll('.js-range-input');
        if (inputs.length !== 2) return;

        const [minInput, maxInput] = inputs;
        const range = group.querySelector('.js-slider-range');
        const displays = group.querySelectorAll('.js-value-display');
        
        if (!range || displays.length !== 2) return;

        const [minDisplay, maxDisplay] = displays;
        const min = parseInt(minInput.min);
        const max = parseInt(minInput.max);
        const type = minInput.dataset.type;
        const format = formatters[type];

        function update() {
            let minVal = parseInt(minInput.value);
            let maxVal = parseInt(maxInput.value);
            
            // Мінімальна різниця 2% від діапазону
            const minGap = (max - min) * 0.02;
            if (minVal > maxVal - minGap) {
                minVal = maxVal - minGap;
                minInput.value = Math.max(min, minVal);
            }
            
            minVal = parseInt(minInput.value);
            maxVal = parseInt(maxInput.value);
            
            // Оновлюємо відображення
            minDisplay.textContent = format(minVal);
            maxDisplay.textContent = format(maxVal);
            
            // Оновлюємо червону лінію
            const leftPercent = ((minVal - min) / (max - min)) * 100;
            const widthPercent = ((maxVal - minVal) / (max - min)) * 100;
            range.style.left = leftPercent + '%';
            range.style.width = widthPercent + '%';
        }

        minInput.addEventListener('input', update);
        maxInput.addEventListener('input', update);
        update();
    });

    // Ініціалізація всіх лічильників (тільки стрілочки, ввід заборонений)
    document.querySelectorAll('.counter-group').forEach(group => {
        const input = group.querySelector('.js-counter-input');
        const downBtn = group.querySelector('.js-counter-down');
        const upBtn = group.querySelector('.js-counter-up');
        
        if (!input || !downBtn || !upBtn) return;
        
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        
        function update() {
            const val = parseInt(input.value);
            downBtn.disabled = val <= min;
            upBtn.disabled = val >= max;
        }
        
        downBtn.addEventListener('click', () => {
            const val = parseInt(input.value);
            if (val > min) {
                input.value = val - 1;
                update();
            }
        });
        
        upBtn.addEventListener('click', () => {
            const val = parseInt(input.value);
            if (val < max) {
                input.value = val + 1;
                update();
            }
        });
        
        update();
    });
});
