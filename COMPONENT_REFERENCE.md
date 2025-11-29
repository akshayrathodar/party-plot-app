# Gofly Theme - Quick Component Reference Guide

## CSS Classes Quick Reference

### Layout Classes
```
.container          - Bootstrap container
.mb-100             - Margin bottom 100px
.mb-50              - Margin bottom 50px
.mb-40              - Margin bottom 40px
.row                - Bootstrap row
.col-lg-4           - Bootstrap column (large, 4 columns)
.col-md-6           - Bootstrap column (medium, 6 columns)
```

### Section Classes
```
.home1-banner-section
.home1-offer-section
.home1-destination-section
.home1-service-section
.home1-travel-package-section
.home1-offer-banner-section
.home1-location-search-section
.home1-blog-section
.home1-testimonial-section
.home1-faq-section
.counter-section
.partner-section
```

### Card Classes
```
.destination-card   - Destination listing card
.package-card       - Travel package card
.service-card       - Service feature card
.blog-card          - Blog post card
.testimonial-card   - Customer testimonial card
.location-card      - Location display card
```

### Button Classes
```
.primary-btn1       - Primary button style
.primary-btn1.black-bg  - Black background variant
.primary-btn1.two   - Secondary style variant
```

### Form Classes
```
.search-area        - Search form wrapper
.form-inner         - Form inner container
.filter-wrapper     - Filter/search wrapper
```

### Navigation Classes
```
.topbar-area        - Top header bar
.header-area        - Main header
.main-menu          - Main navigation menu
.menu-list          - Menu items list
.menu-item-has-children  - Menu item with dropdown
.sub-menu           - Dropdown submenu
.mega-menu          - Mega menu container
```

### Slider Classes
```
.home1-offer-slider
.home1-destination-slider
.swiper             - Swiper container
.slider-pagi-wrap   - Pagination wrapper
```

### Typography Classes
```
.section-title      - Section heading wrapper
.text-center        - Center aligned text
.text-left          - Left aligned text
```

### Utility Classes
```
.wow                - WOW.js animation trigger
.animate            - Animation class
.fadeInDown         - Fade in down animation
.d-lg-block         - Display large and up
.d-none             - Hide element
.d-flex             - Flexbox display
```

---

## HTML Structure Patterns

### Destination Card Pattern
```html
<div class="destination-card">
    <div class="destination-img">
        <img src="..." alt="...">
    </div>
    <div class="destination-content">
        <h5>Location Name</h5>
        <p>Country/Region</p>
        <div class="rating-area">
            <span class="rating">4.5</span>
            <div class="stars">★★★★★</div>
        </div>
        <div class="price-area">
            <span class="price">From $299</span>
        </div>
    </div>
</div>
```

### Package Card Pattern
```html
<div class="package-card">
    <div class="package-img">
        <img src="..." alt="...">
        <div class="package-badge">Popular</div>
    </div>
    <div class="package-content">
        <h5>Package Title</h5>
        <div class="package-location">
            <i class="bi bi-geo-alt"></i>
            <span>Location</span>
        </div>
        <div class="package-duration">
            <i class="bi bi-clock"></i>
            <span>5 Days</span>
        </div>
        <div class="package-rating">
            <span>4.8</span>
            <div class="stars">★★★★★</div>
        </div>
        <div class="package-features">
            <ul>
                <li>Feature 1</li>
                <li>Feature 2</li>
            </ul>
        </div>
        <div class="package-price">
            <span class="old-price">$999</span>
            <span class="new-price">$799</span>
        </div>
        <a href="..." class="primary-btn1">Book Now</a>
    </div>
</div>
```

### Section Title Pattern
```html
<div class="section-title text-center">
    <h2>Section Title</h2>
    <p>Section description or subtitle</p>
</div>
```

### Swiper Slider Pattern
```html
<div class="swiper home1-offer-slider">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <!-- Slide content -->
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div>
```

### Accordion/FAQ Pattern
```html
<div class="accordion" id="faqAccordion">
    <div class="accordion-item">
        <h5 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button">
                Question Text
            </button>
        </h5>
        <div class="accordion-collapse collapse show">
            <div class="accordion-body">
                Answer text
            </div>
        </div>
    </div>
</div>
```

---

## JavaScript Initialization Patterns

### Swiper Slider
```javascript
var swiper = new Swiper(".home1-offer-slider", {
    slidesPerView: 1,
    speed: 1500,
    spaceBetween: 24,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        576: { slidesPerView: 2 },
        768: { slidesPerView: 3 },
        992: { slidesPerView: 3 },
    },
});
```

### Counter Animation
```javascript
$(".counter").counterUp({
    delay: 10,
    time: 1000,
});
```

### FancyBox Gallery
```javascript
$('[data-fancybox="gallery-01"]').fancybox({
    buttons: ["close"],
    loop: false,
    protect: true,
});
```

### Nice Select Dropdown
```javascript
$('select').niceSelect();
```

### Date Range Picker
```javascript
$('input[name="daterange"]').daterangepicker({
    opens: 'left'
});
```

---

## Common Icon Usage

### Bootstrap Icons (bi)
- `bi-geo-alt` - Location
- `bi-clock` - Time/Duration
- `bi-star-fill` - Rating star
- `bi-person` - User/Person
- `bi-calendar` - Date
- `bi-search` - Search
- `bi-arrow-right` - Arrow
- `bi-caret-down-fill` - Dropdown arrow
- `bi-x` - Close
- `bi-plus` - Plus/Expand

### Boxicons (bx)
- Various icon options available

---

## Form Input Patterns

### Search Input
```html
<form class="search-area">
    <div class="form-inner">
        <button type="submit">
            <svg>...</svg>
        </button>
        <input type="text" placeholder="Search...">
    </div>
</form>
```

### Date Picker Input
```html
<input type="text" class="form-control datepicker" placeholder="Check In">
```

### Select Dropdown
```html
<select class="form-select nice-select">
    <option>Option 1</option>
    <option>Option 2</option>
</select>
```

---

## Animation Classes (WOW.js)

```
wow animate fadeInDown
wow animate fadeInUp
wow animate fadeInLeft
wow animate fadeInRight
wow animate zoomIn
wow animate slideInUp
```

**Data Attributes:**
- `data-wow-delay="200ms"` - Animation delay
- `data-wow-duration="1500ms"` - Animation duration

---

## Responsive Breakpoints

```css
/* Mobile */
280px
386px

/* Tablet */
576px
768px

/* Desktop */
992px
1200px
1400px
```

**Bootstrap Classes:**
- `d-lg-none` - Hide on large screens
- `d-lg-block` - Show on large screens
- `d-md-none` - Hide on medium screens
- `col-lg-4` - 4 columns on large screens
- `col-md-6` - 6 columns on medium screens

---

## Color Usage Guide

### Primary Colors
- `--primary-color1` (#1781FE) - Main blue
- `--primary-color2` (#0EA9D0) - Cyan
- `--primary-color3` (#285340) - Green
- `--primary-color4` (#1B2072) - Dark blue

### Text Colors
- `--title-color` (#110F0F) - Headings
- `--text-color` (#525252) - Body text
- `--white-text-color` (#AAAAAA) - Light text

### Usage in Classes
- `.primary-btn1` - Uses primary-color1
- `.black-bg` - Black background variant
- Text colors applied via CSS variables

---

## Common Layout Patterns

### Grid Layout (3 columns)
```html
<div class="row gy-lg-5 gy-4">
    <div class="col-lg-4 col-md-6">
        <!-- Card content -->
    </div>
    <div class="col-lg-4 col-md-6">
        <!-- Card content -->
    </div>
    <div class="col-lg-4 col-md-6">
        <!-- Card content -->
    </div>
</div>
```

### Grid Layout (4 columns)
```html
<div class="row">
    <div class="col-lg-3 col-md-6">
        <!-- Card content -->
    </div>
    <!-- Repeat 4 times -->
</div>
```

### Full Width Section
```html
<div class="section-name mb-100">
    <div class="container">
        <div class="row">
            <!-- Content -->
        </div>
    </div>
</div>
```

---

## File Structure Reference

### CSS Files
- `style.css` - Main stylesheet (all components)
- `bootstrap.min.css` - Bootstrap framework
- `animate.min.css` - Animation library
- `swiper-bundle.min.css` - Swiper slider
- `slick.css` - Slick slider
- `jquery.fancybox.min.css` - Lightbox
- `daterangepicker.css` - Date picker
- `nice-select.css` - Custom selects
- `leaflet.css` - Maps

### JavaScript Files
- `custom.js` - Main custom scripts
- `jquery-3.7.1.min.js` - jQuery library
- `bootstrap.min.js` - Bootstrap JS
- `swiper-bundle.min.js` - Swiper slider
- `slick.js` - Slick slider
- `jquery.fancybox.min.js` - Lightbox
- `gsap.min.js` - Animation library
- `wow.min.js` - Scroll animations
- `daterangepicker.min.js` - Date picker
- `jquery.nice-select.min.js` - Custom selects

---

## Quick Tips

1. **Always wrap sections in `.container`** for proper spacing
2. **Use `.mb-100` or `.mb-50`** for section spacing
3. **Add `.wow animate fadeInDown`** for scroll animations
4. **Use Swiper for sliders** - it's the primary slider library
5. **Cards should be in responsive grid** - use Bootstrap columns
6. **Buttons use `.primary-btn1`** class
7. **Section titles use `.section-title`** class
8. **Mobile menu toggles** via `.sidebar-button` click
9. **Sticky header** activates on scroll automatically
10. **Date pickers** require jQuery UI initialization

---

## Component Dependencies

### Destination Card Requires:
- Swiper (if in slider)
- FancyBox (for image gallery)

### Package Card Requires:
- Swiper (for image slider)
- Counter (for price animation)

### Forms Require:
- jQuery UI (date pickers)
- Nice Select (dropdowns)
- Custom validation scripts

### Sliders Require:
- Swiper.js library
- Custom initialization in `custom.js`

---

This reference guide should help you quickly identify and use components when building the Laravel application.



