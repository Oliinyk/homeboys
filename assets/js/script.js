//  HEADER
const burger = document.getElementById('burgerBtn');
const nav = document.getElementById('mainNav');
const closeNav = document.getElementById('closeNav');
const overlay = document.getElementById('navOverlay');
const dropdowns = document.querySelectorAll('.has-dropdown > button');

// Header hide / show on scroll
const siteHeader = document.querySelector('.site-header');
let lastScrollY = window.scrollY;
const headerOffset = 120; // px before hide

window.addEventListener('scroll', () => {
    if (!siteHeader) return;

    // do not hide header when mobile menu is open
    if (nav.classList.contains('open')) return;

    const currentScroll = window.scrollY;

    // always show header near top
    if (currentScroll <= headerOffset) {
        siteHeader.classList.remove('is-hidden');
        lastScrollY = currentScroll;
        return;
    }

    if (currentScroll > lastScrollY) {
        // scroll down
        siteHeader.classList.add('is-hidden');
    } else {
        // scroll up
        siteHeader.classList.remove('is-hidden');
    }

    lastScrollY = currentScroll;
});


// Open mobile menu
burger.addEventListener('click', () => {
    nav.classList.add('open');
    overlay.classList.add('active');
    burger.classList.add('active');
    document.body.style.overflow = 'hidden';
});

// Close mobile menu
function closeMobileMenu() {
    nav.classList.remove('open');
    overlay.classList.remove('active');
    burger.classList.remove('active');
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

// gallery-thumbs-slider
// thumbnail slider
const galleryThumbs = new Swiper('.gallery-thumbs', {
    spaceBetween: 0,
    slidesPerView: 'auto',
    watchSlidesProgress: true,
    allowTouchMove: false,
    simulateTouch: false,
});

// main slider
const galleryMain = new Swiper('.gallery-main', {
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    thumbs: {
        swiper: galleryThumbs
    },
    preventClicks: false,
    preventClicksPropagation: false,
});

// click on thumbnails
const thumbSlides = document.querySelectorAll('.gallery-thumbs .swiper-slide');
thumbSlides.forEach((thumb, index) => {
    thumb.addEventListener('click', () => {
        galleryMain.slideTo(index);
    });
});

// Fancybox
const fancyItems = Array.from(
    document.querySelectorAll('.js-fancybox-item')
).map(el => ({
    src: el.getAttribute('href'),
    type: 'image',
}));

document.addEventListener('click', function (e) {
    const link = e.target.closest('.js-fancybox-item');
    if (!link) return;
    e.preventDefault();
    e.stopPropagation();
    const activeIndex = galleryMain.realIndex ?? galleryMain.activeIndex;

    Fancybox.show(fancyItems, {
        startIndex: activeIndex,
        Thumbs: false,
        Toolbar: {
            display: ["close"]
        }
    });
}, true);

// Filter
document.addEventListener('DOMContentLoaded', function () {

    // RANGE + INPUT SYNC
    const formatters = {
        price: {
            format: v => '$ ' + Number(v).toLocaleString('en-US'),
            parse: v => parseInt(v.replace(/[^\d]/g, ''), 10)
        },
        size: {
            format: v => Number(v).toLocaleString('en-US') + ' ft²',
            parse: v => parseInt(v.replace(/[^\d]/g, ''), 10)
        }
    };

    document.querySelectorAll('.filter-group').forEach(group => {
        const ranges = group.querySelectorAll('.js-range-input');
        const inputs = group.querySelectorAll('.js-value-input');
        const rangeLine = group.querySelector('.js-slider-range');

        if (ranges.length !== 2 || inputs.length !== 2 || !rangeLine) return;

        const [minRange, maxRange] = ranges;
        const [minInput, maxInput] = inputs;

        const min = +minRange.min;
        const max = +minRange.max;
        const type = minRange.dataset.type;
        const { format, parse } = formatters[type];

        const minGap = (max - min) * 0.02;

        function clampValues() {
            let minVal = +minRange.value;
            let maxVal = +maxRange.value;

            if (minVal > maxVal - minGap) {
                minVal = maxVal - minGap;
                minRange.value = minVal;
            }

            if (maxVal < minVal + minGap) {
                maxVal = minVal + minGap;
                maxRange.value = maxVal;
            }
        }

        function updateUI() {
            const minVal = +minRange.value;
            const maxVal = +maxRange.value;

            minInput.value = format(minVal);
            maxInput.value = format(maxVal);

            const left = ((minVal - min) / (max - min)) * 100;
            const width = ((maxVal - minVal) / (max - min)) * 100;

            rangeLine.style.left = left + '%';
            rangeLine.style.width = width + '%';
        }

        // RANGE → INPUT
        minRange.addEventListener('input', () => {
            clampValues();
            updateUI();
        });

        maxRange.addEventListener('input', () => {
            clampValues();
            updateUI();
        });

        // INPUT → RANGE
        function handleTextInput(e, isMin) {
            let val = parse(e.target.value);

            if (isNaN(val)) {
                updateUI();
                return;
            }

            val = Math.max(min, Math.min(max, val));

            if (isMin) {
                minRange.value = val;
            } else {
                maxRange.value = val;
            }

            clampValues();
            updateUI();
        }

        minInput.addEventListener('blur', e => handleTextInput(e, true));
        maxInput.addEventListener('blur', e => handleTextInput(e, false));

        minInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') e.target.blur();
        });

        maxInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') e.target.blur();
        });

        updateUI();
    });


    // COUNTERS (BEDS / BATHS)
    document.querySelectorAll('.counter-group').forEach(group => {
        const input = group.querySelector('.js-counter-input');
        const downBtn = group.querySelector('.js-counter-down');
        const upBtn = group.querySelector('.js-counter-up');

        if (!input || !downBtn || !upBtn) return;

        const min = +input.min;
        const max = +input.max;

        function update() {
            const val = +input.value;
            downBtn.disabled = val <= min;
            upBtn.disabled = val >= max;
        }

        downBtn.addEventListener('click', () => {
            let val = +input.value;
            if (val > min) {
                input.value = val - 1;
                update();
            }
        });

        upBtn.addEventListener('click', () => {
            let val = +input.value;
            if (val < max) {
                input.value = val + 1;
                update();
            }
        });

        update();
    });

    // FORM SUBMIT
    const form = document.querySelector('.filter-container');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const params = new URLSearchParams();

            for (let [key, value] of formData.entries()) {

                const field = form.querySelector(`[name="${key}"]`);

                // skip empty, -1, first option
                if (field && field.tagName === 'SELECT') {
                    if (value === '' || value === '-1' || field.selectedIndex === 0) {
                        continue;
                    }
                }

                // skip empty model
                if (key === 'model' && value.trim() === '') {
                    continue;
                }

                params.append(key, value);
            }

            const query = params.toString();
            window.location.href = query
                ? `${form.action}?${query}`
                : form.action;
        });
    }
});
