//  HEADER
(function () {

    const burger = document.querySelector('.burgerBtn');
    const burgerLabel = burger?.querySelector('.burger-label');
    const nav = document.getElementById('mainNav');
    const overlay = document.getElementById('navOverlay');
    const dropdownBg = document.getElementById('dropdownBg');
    const dropdownButtons = document.querySelectorAll('.has-dropdown > button');
    const siteHeader = document.querySelector('.site-header');

    if (!siteHeader || !burger || !nav || !burgerLabel) return;

    const DESKTOP_BREAKPOINT = 992;
    const HEADER_OFFSET = 120;

    let lastScrollY = window.scrollY;
    let scrollTicking = false;

    // ---------------- HELPERS ----------------

    const isDesktop = () => window.innerWidth >= DESKTOP_BREAKPOINT;

    const setBurgerLabel = (isOpen) => {
        burgerLabel.textContent = isOpen ? 'CLOSE' : 'MENU';
    };

    const closeAllDropdowns = () => {
        document
            .querySelectorAll('.has-dropdown.open')
            .forEach(d => d.classList.remove('open'));

        if (dropdownBg) {
            dropdownBg.classList.remove('active');
            dropdownBg.style.height = '';
        }
    };

    const openMobileMenu = () => {
        nav.classList.add('open');
        overlay?.classList.add('active');
        burger.classList.add('active');
        setBurgerLabel(true);
        document.body.style.overflow = 'hidden';
    };

    const closeMobileMenu = () => {
        nav.classList.remove('open');
        overlay?.classList.remove('active');
        burger.classList.remove('active');
        setBurgerLabel(false);
        document.body.style.overflow = '';
        closeAllDropdowns();
    };

    const toggleMobileMenu = () => {
        nav.classList.contains('open')
            ? closeMobileMenu()
            : openMobileMenu();
    };

    // ---------------- HEADER SCROLL ----------------

    const handleScroll = () => {
        const currentScroll = window.scrollY;

        if (nav.classList.contains('open')) return;

        if (currentScroll <= HEADER_OFFSET) {
            siteHeader.classList.remove('is-hidden');
            lastScrollY = currentScroll;
            return;
        }

        siteHeader.classList.toggle(
            'is-hidden',
            currentScroll > lastScrollY
        );

        lastScrollY = currentScroll;
    };

    window.addEventListener('scroll', () => {
        if (!scrollTicking) {
            window.requestAnimationFrame(() => {
                handleScroll();
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    });

    // ---------------- EVENTS ----------------

    burger.addEventListener('click', toggleMobileMenu);
    overlay?.addEventListener('click', closeMobileMenu);

    // ---------------- DROPDOWNS ----------------

    dropdownButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const parent = button.closest('.has-dropdown');
            const menu = parent.querySelector('.dropdown-menu');
            const isOpen = parent.classList.contains('open');

            closeAllDropdowns();

            if (!isOpen) {
                parent.classList.add('open');

                if (isDesktop() && dropdownBg && menu) {
                    dropdownBg.style.height = `${menu.offsetHeight}px`;
                    dropdownBg.classList.add('active');
                }
            }
        });
    });

    // close dropdown on outside click
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.has-dropdown')) {
            closeAllDropdowns();
        }
    });

    // ---------------- RESIZE ----------------

    window.addEventListener('resize', () => {
        if (isDesktop()) {
            closeMobileMenu();
        } else {
            closeAllDropdowns();
        }
    });

})();


// --- Initialize Swiper ---
var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
        delay: 5000,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

// From Our People swiper
let storiesSlider;
const swiperEl = document.querySelector('.stories-swiper');

function initStoriesSwiper() {
    if (!swiperEl) return;
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        // Turn off swiper
        if (storiesSlider) {
            storiesSlider.destroy(true, true);
            storiesSlider = null;
        }

        swiperEl.classList.add('is-static');

        // showing only the last 2
        const slides = swiperEl.querySelectorAll('.swiper-slide');
        slides.forEach((slide, index) => {
            slide.style.display =
                index < slides.length - 2 ? 'none' : 'block';
        });

    } else {
        // return all slides
        const slides = swiperEl.querySelectorAll('.swiper-slide');
        slides.forEach(slide => slide.style.display = '');

        swiperEl.classList.remove('is-static');

        // initialize swiper
        storiesSlider = new Swiper(".stories-swiper", {
            spaceBetween: 30,
            loop: true,
            slidesPerView: 2,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
}

// init
initStoriesSwiper();
window.addEventListener('resize', initStoriesSwiper);


// Blog swiper
if (document.querySelector('.blog-slider')) {
    var blogSlider = new Swiper(".blog-slider", {
        slidesPerView: 1.2,
        spaceBetween: 20,
        centeredSlides: true,
        // loop: true,
        initialSlide: 1,
        navigation: {
            nextEl: ".swiper-blog-button-next",
            prevEl: ".swiper-blog-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
                // centeredSlides: true,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                centeredSlides: false,
            },
        },
    });
}

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
    autoplay: {
        delay: 5000,
    },
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


document.addEventListener('DOMContentLoaded', function () {

    // Filter
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

            // Save per_page from the current URL if it exists
            const currentUrl = new URL(window.location.href);
            const perPage = currentUrl.searchParams.get('per_page');
            if (perPage) {
                params.set('per_page', perPage);
            }

            const query = params.toString();
            window.location.href = query
                ? `${form.action}?${query}`
                : form.action;
        });
    }


    // sort-switcher add to URL
    const sortButtons = document.querySelectorAll('.sort-switcher');
    if (!sortButtons.length) return;

    const url = new URL(window.location.href);
    const params = url.searchParams;

    // 1. Initialization from URL
    const currentSort = params.get('sort');

    if (currentSort) {
        sortButtons.forEach(btn => {
            btn.classList.toggle('active', btn.dataset.sort === currentSort);
        });
    }

    // 2. Click on the sort buttons
    sortButtons.forEach(btn => {
        btn.addEventListener('click', () => {

            const sortValue = btn.dataset.sort;

            // UI
            sortButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // update URL
            params.set('sort', sortValue);

            // redirect with all existing parameters
            window.history.pushState({}, '', `${url.pathname}?${params.toString()}`);
            window.location.reload();
        });
    });

});

// Show All button
const showAllBtn = document.querySelector('.show-all-btn');
if (showAllBtn) {
    showAllBtn.addEventListener('click', function() {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        
        // Add or update the per_page parameter
        params.set('per_page', '-1');
        
        // Redirect with all existing parameters
        window.location.href = `${url.pathname}?${params.toString()}`;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Customer Guidelines slider with progressbar
    const CustomerGuidelinesSwiper = new Swiper('.guidelines-swiper', {
        slidesPerView: 1,
        spaceBetween: 60,
        navigation: {
            nextEl: '.custom-next',
            prevEl: '.custom-prev',
        },
        on: {
            slideChange: function () {
                updateGuidelinesProgress(this.activeIndex);
            },
            init: function () {
                updateGuidelinesProgress(this.activeIndex);
            }
        }
    });

    function updateGuidelinesProgress(index) {
        // Update the progress bar segments
        const segments = document.querySelectorAll('.progress-segment');
        segments.forEach((segment, i) => {
            if (i < index) {
                segment.classList.add('completed');
                segment.classList.remove('active');
            } else if (i === index) {
                segment.classList.add('active');
                segment.classList.remove('completed');
            } else {
                segment.classList.remove('active', 'completed');
            }
        });

        // Updating active steps
        const stepItems = document.querySelectorAll('.step-item');
        stepItems.forEach((stepItem, i) => {
            if (i < index) {
                stepItem.classList.add('completed');
                stepItem.classList.remove('active');
            } else if (i === index) {
                stepItem.classList.add('active');
                stepItem.classList.remove('completed');
            } else {
                stepItem.classList.remove('active', 'completed');
            }
        });
    }

    // Adding a click step by step
    document.querySelectorAll('.step-item').forEach((item, index) => {
        item.addEventListener('click', function() {
            CustomerGuidelinesSwiper.slideTo(index);
        });
    });

    // Initializing progress for the first slide
    updateGuidelinesProgress(0);

});

// Footer Nav
document.addEventListener('DOMContentLoaded', function() {
    const dropdownButtons = document.querySelectorAll('.footer-nav .has-dropdown .f-nav-link');
    
    if (dropdownButtons.length > 0) {
        dropdownButtons[0].classList.add('open');
    }
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isOpen = this.classList.contains('open');
            
            dropdownButtons.forEach(btn => {
                btn.classList.remove('open');
            });
            
            if (!isOpen) {
                this.classList.add('open');
            }
        });
    });
});

// Show more/less button in content
document.addEventListener('DOMContentLoaded', function() {
    processReadMoreBlocks();
    
    function processReadMoreBlocks() {
        const content = document.querySelector('.entry-content, .wp-block-post-content, article, .content-section .content-wrap');
        if (!content) return;
        
        const html = content.innerHTML;
        
        // Option 1: Comment <!-- wp:read-more -->
        if (html.includes('<!-- wp:read-more')) {
            const parts = html.split(/<!-- wp:read-more.*?-->/);
            
            if (parts.length > 1) {
                createReadMoreStructure(content, parts[0], parts.slice(1).join(''));
                return;
            }
        }
        
        // Option 2: HTML element <a class="wp-block-read-more">
        const readMoreLink = content.querySelector('a.wp-block-read-more');
        if (readMoreLink) {
            // Find all elements before and after the link
            const parent = readMoreLink.parentElement;
            const allNodes = Array.from(parent.childNodes);
            const linkIndex = allNodes.indexOf(readMoreLink);
            
            // We collect content before and after
            const beforeNodes = allNodes.slice(0, linkIndex);
            const afterNodes = allNodes.slice(linkIndex + 1);
            
            let visibleContent = '';
            beforeNodes.forEach(node => {
                visibleContent += node.nodeType === 1 ? node.outerHTML : node.textContent;
            });
            
            let hiddenContent = '';
            afterNodes.forEach(node => {
                hiddenContent += node.nodeType === 1 ? node.outerHTML : node.textContent;
            });
            
            createReadMoreStructure(parent, visibleContent, hiddenContent);
        }
    }
    
    function createReadMoreStructure(container, visibleContent, hiddenContent) {
        container.innerHTML = `
            <div class="read-more-wrapper">
                ${visibleContent}
                <div class="read-more-content collapsed" style="max-height: 0; opacity: 0;">
                    ${hiddenContent}
                </div>
                <button class="btn primary-btn show-all-btn readMoreBtn">
                    Show All
                </button>
            </div>
        `;
        
        const btn = container.querySelector('.readMoreBtn');
        const collapsible = container.querySelector('.read-more-content');
        
        // give height to the content
        collapsible.style.maxHeight = 'none';
        collapsible.style.opacity = '1';
        const fullHeight = collapsible.scrollHeight;
        collapsible.style.maxHeight = '0';
        collapsible.style.opacity = '0';
        
        btn.addEventListener('click', function() {
            if (collapsible.classList.contains('collapsed')) {
                // opening
                collapsible.classList.remove('collapsed');
                collapsible.style.maxHeight = fullHeight + 'px';
                collapsible.style.opacity = '1';
                this.textContent = 'Show Less';
                this.classList.add('read-less');
            } else {
                // closing
                collapsible.classList.add('collapsed');
                collapsible.style.maxHeight = '0';
                collapsible.style.opacity = '0';
                this.textContent = 'Show All';
                this.classList.remove('read-less');
                
                // scroll to the button
                setTimeout(() => {
                    btn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }, 100);
            }
        });
    }
    
    // Update height when window is resized
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            const collapsible = document.querySelector('.read-more-content');
            if (collapsible && !collapsible.classList.contains('collapsed')) {
                collapsible.style.maxHeight = 'none';
                const newHeight = collapsible.scrollHeight;
                collapsible.style.maxHeight = newHeight + 'px';
            }
        }, 250);
    });
});

// Form send
document.addEventListener('wpcf7submit', function(event) {
    // console.log(event);
    
    const targetFormId = '92032';
    
    if (targetFormId == event.detail.contactFormId) {
        if ('mail_sent' === event.detail.status) {
            // Create success message block
            const successMessage = document.createElement('div');
            successMessage.className = 'form-success-message';
            successMessage.innerHTML = `
                <button class='form-success-close' aria-label='Close message'>&times;</button>
                <h2 class='title-section'>Thank You!</h2>
                <p>We will be in touch with you shortly</p>
            `;
            
            // Find the contact form wrapper and insert the message
            const contactWrap = event.target.closest('.contact-wrap');
            if (contactWrap) {
                contactWrap.appendChild(successMessage);
                
                // Add close functionality
                const closeButton = successMessage.querySelector('.form-success-close');
                closeButton.addEventListener('click', function() {
                    successMessage.remove();
                });
            }
        }
    }
}, false);
