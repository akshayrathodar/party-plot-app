# Laravel Blade Components Extraction List

This document lists all reusable components that should be extracted from the HTML theme into Laravel Blade components.

---

## 1. Layout Components

### 1.1 Main Layout
**File:** `resources/views/layouts/app.blade.php`
- Base HTML structure
- Meta tags
- CSS includes
- JavaScript includes
- Magic cursor div
- Back to top button

### 1.2 Header Component
**File:** `resources/views/components/header.blade.php`
**Props:**
- `$logo` - Logo image path
- `$menuItems` - Navigation menu items
- `$showSearch` - Boolean for search bar
- `$showLanguage` - Boolean for language selector

**Includes:**
- Topbar area
- Main header
- Navigation menu
- Mobile menu
- Search functionality
- Language selector
- Login button

### 1.3 Footer Component
**File:** `resources/views/components/footer.blade.php`
**Props:**
- `$footerLogo` - Footer logo
- `$contactInfo` - Contact information
- `$quickLinks` - Footer links
- `$socialLinks` - Social media links

**Includes:**
- Footer widgets
- Newsletter subscription
- Social links
- Copyright text
- Payment icons

---

## 2. Card Components

### 2.1 Destination Card
**File:** `resources/views/components/cards/destination.blade.php`
**Props:**
- `$destination` - Destination model/array
- `$showRating` - Boolean (default: true)
- `$showPrice` - Boolean (default: true)
- `$size` - Size variant (default, large, small)

**Data Structure:**
```php
[
    'id' => 1,
    'name' => 'Paris, France',
    'country' => 'France',
    'image' => 'path/to/image.jpg',
    'rating' => 4.5,
    'price_from' => 299,
    'slug' => 'paris-france'
]
```

### 2.2 Package Card
**File:** `resources/views/components/cards/package.blade.php`
**Props:**
- `$package` - Package model/array
- `$showBadge` - Boolean (default: true)
- `$showSlider` - Boolean for image slider (default: true)
- `$variant` - Style variant (default, featured)

**Data Structure:**
```php
[
    'id' => 1,
    'title' => 'Paris City Tour',
    'slug' => 'paris-city-tour',
    'location' => 'Paris, France',
    'duration' => '5 Days',
    'images' => ['img1.jpg', 'img2.jpg'],
    'rating' => 4.8,
    'price' => 799,
    'discount_price' => 599,
    'badge' => 'Popular',
    'features' => ['Breakfast', 'Hotel', 'Guide']
]
```

### 2.3 Service Card
**File:** `resources/views/components/cards/service.blade.php`
**Props:**
- `$service` - Service model/array
- `$icon` - Icon class or SVG
- `$link` - Optional link URL

**Data Structure:**
```php
[
    'id' => 1,
    'title' => '24/7 Support',
    'description' => 'Round the clock customer support',
    'icon' => 'bi-headset',
    'link' => '/support'
]
```

### 2.4 Blog Card
**File:** `resources/views/components/cards/blog.blade.php`
**Props:**
- `$post` - Blog post model/array
- `$showAuthor` - Boolean (default: true)
- `$showDate` - Boolean (default: true)
- `$excerptLength` - Number of words (default: 20)

**Data Structure:**
```php
[
    'id' => 1,
    'title' => 'Best Travel Destinations',
    'slug' => 'best-travel-destinations',
    'excerpt' => 'Lorem ipsum...',
    'image' => 'path/to/image.jpg',
    'category' => 'Travel Tips',
    'author' => 'John Doe',
    'published_at' => '2024-01-15'
]
```

### 2.5 Testimonial Card
**File:** `resources/views/components/cards/testimonial.blade.php`
**Props:**
- `$testimonial` - Testimonial model/array
- `$showImage` - Boolean (default: true)
- `$showRating` - Boolean (default: true)

**Data Structure:**
```php
[
    'id' => 1,
    'name' => 'John Doe',
    'designation' => 'Travel Enthusiast',
    'image' => 'path/to/image.jpg',
    'rating' => 5,
    'content' => 'Amazing experience...',
    'location' => 'New York, USA'
]
```

---

## 3. Section Components

### 3.1 Section Title
**File:** `resources/views/components/sections/title.blade.php`
**Props:**
- `$title` - Section title (required)
- `$subtitle` - Section subtitle/description
- `$align` - Text alignment (center, left, right) (default: 'center')
- `$tag` - HTML tag (h1, h2, h3) (default: 'h2')

### 3.2 Banner Section
**File:** `resources/views/components/sections/banner.blade.php`
**Props:**
- `$title` - Banner title
- `$subtitle` - Banner subtitle
- `$background` - Background image/video path
- `$backgroundType` - Type: 'image' or 'video' (default: 'image')
- `$ctaText` - Call-to-action button text
- `$ctaLink` - Call-to-action button link
- `$overlay` - Boolean for dark overlay (default: true)

### 3.3 Offer Section
**File:** `resources/views/components/sections/offers.blade.php`
**Props:**
- `$offers` - Collection of offers
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$slider` - Boolean for slider layout (default: true)

### 3.4 Destination Section
**File:** `resources/views/components/sections/destinations.blade.php`
**Props:**
- `$destinations` - Collection of destinations
- `$regions` - Available regions for tabs
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$showTabs` - Boolean for tab navigation (default: true)
- `$perSlide` - Number of items per slide (default: 4)

### 3.5 Package Section
**File:** `resources/views/components/sections/packages.blade.php`
**Props:**
- `$packages` - Collection of packages
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$columns` - Grid columns (3 or 4) (default: 3)
- `$showFilter` - Boolean for filter options

### 3.6 Service Section
**File:** `resources/views/components/sections/services.blade.php`
**Props:**
- `$services` - Collection of services
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$columns` - Grid columns (default: 4)

### 3.7 Testimonial Section
**File:** `resources/views/components/sections/testimonials.blade.php`
**Props:**
- `$testimonials` - Collection of testimonials
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$slider` - Boolean for slider layout (default: true)
- `$background` - Background image path (optional)

### 3.8 Blog Section
**File:** `resources/views/components/sections/blog.blade.php`
**Props:**
- `$posts` - Collection of blog posts
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$columns` - Grid columns (default: 3)
- `$limit` - Number of posts to show (default: 6)

### 3.9 FAQ Section
**File:** `resources/views/components/sections/faq.blade.php`
**Props:**
- `$faqs` - Collection of FAQs
- `$title` - Section title
- `$subtitle` - Section subtitle
- `$accordionId` - Unique accordion ID (default: 'faqAccordion')

### 3.10 Counter Section
**File:** `resources/views/components/sections/counter.blade.php`
**Props:**
- `$counters` - Collection of counter items
- `$background` - Background image path (optional)

**Data Structure:**
```php
[
    [
        'icon' => 'bi-people',
        'number' => 10000,
        'suffix' => '+',
        'label' => 'Happy Customers'
    ],
    // ...
]
```

### 3.11 Partner/Logo Section
**File:** `resources/views/components/sections/partners.blade.php`
**Props:**
- `$partners` - Collection of partner logos
- `$title` - Section title (optional)
- `$slider` - Boolean for slider layout (default: true)

---

## 4. Form Components

### 4.1 Search Form
**File:** `resources/views/components/forms/search.blade.php`
**Props:**
- `$placeholder` - Input placeholder text
- `$action` - Form action URL
- `$method` - HTTP method (default: 'GET')
- `$showButton` - Boolean for submit button (default: true)

### 4.2 Booking Form
**File:** `resources/views/components/forms/booking.blade.php`
**Props:**
- `$action` - Form action URL
- `$method` - HTTP method (default: 'POST')
- `$packageId` - Pre-selected package ID (optional)
- `$showGuests` - Boolean for guest selector (default: true)
- `$showRooms` - Boolean for room selector (default: true)

### 4.3 Contact Form
**File:** `resources/views/components/forms/contact.blade.php`
**Props:**
- `$action` - Form action URL
- `$method` - HTTP method (default: 'POST')
- `$showSubject` - Boolean for subject field (default: true)

### 4.4 Newsletter Form
**File:** `resources/views/components/forms/newsletter.blade.php`
**Props:**
- `$action` - Form action URL
- `$placeholder` - Input placeholder
- `$buttonText` - Submit button text

---

## 5. Slider Components

### 5.1 Swiper Wrapper
**File:** `resources/views/components/sliders/swiper.blade.php`
**Props:**
- `$slides` - Collection of slide items
- `$sliderClass` - Custom slider class name
- `$slidesPerView` - Number of slides per view (default: 1)
- `$autoplay` - Boolean for autoplay (default: true)
- `$pagination` - Boolean for pagination (default: true)
- `$navigation` - Boolean for navigation arrows (default: false)
- `$breakpoints` - Custom breakpoints array
- `$spaceBetween` - Space between slides (default: 24)

**Slot:** Slide content

### 5.2 Swiper Slide
**File:** `resources/views/components/sliders/slide.blade.php`
**Props:**
- `$active` - Boolean for active slide (default: false)

**Slot:** Slide content

---

## 6. Navigation Components

### 6.1 Breadcrumb
**File:** `resources/views/components/navigation/breadcrumb.blade.php`
**Props:**
- `$items` - Array of breadcrumb items
- `$homeText` - Home link text (default: 'Home')
- `$homeUrl` - Home URL (default: '/')

**Data Structure:**
```php
[
    ['text' => 'Home', 'url' => '/'],
    ['text' => 'Destinations', 'url' => '/destinations'],
    ['text' => 'Paris', 'url' => null] // null = current page
]
```

### 6.2 Pagination
**File:** `resources/views/components/navigation/pagination.blade.php`
**Props:**
- `$paginator` - Laravel paginator instance
- `$view` - Pagination view (default: 'default')

---

## 7. UI Components

### 7.1 Button
**File:** `resources/views/components/ui/button.blade.php`
**Props:**
- `$type` - Button type (button, submit, link) (default: 'button')
- `$variant` - Style variant (primary, secondary, black) (default: 'primary')
- `$size` - Size (small, medium, large) (default: 'medium')
- `$href` - Link URL (if type is 'link')
- `$icon` - Icon class (optional)
- `$iconPosition` - Icon position (left, right) (default: 'left')
- `$disabled` - Boolean for disabled state

**Slot:** Button text/content

### 7.2 Badge
**File:** `resources/views/components/ui/badge.blade.php`
**Props:**
- `$text` - Badge text
- `$variant` - Style variant (primary, success, danger, etc.)
- `$position` - Position (top-left, top-right, etc.) (optional)

### 7.3 Rating
**File:** `resources/views/components/ui/rating.blade.php`
**Props:**
- `$rating` - Rating value (0-5)
- `$maxRating` - Maximum rating (default: 5)
- `$showNumber` - Boolean to show numeric rating (default: true)
- `$size` - Star size (small, medium, large) (default: 'medium')

### 7.4 Modal
**File:** `resources/views/components/ui/modal.blade.php`
**Props:**
- `$id` - Modal ID (required)
- `$title` - Modal title
- `$size` - Modal size (small, medium, large) (default: 'medium')
- `$showClose` - Boolean for close button (default: true)

**Slots:**
- `trigger` - Button/content that opens modal
- `content` - Modal body content
- `footer` - Modal footer content

### 7.5 Accordion
**File:** `resources/views/components/ui/accordion.blade.php`
**Props:**
- `$id` - Accordion ID (required)
- `$items` - Array of accordion items
- `$allowMultiple` - Boolean for multiple open items (default: false)

**Data Structure:**
```php
[
    [
        'id' => 'item1',
        'title' => 'Question 1',
        'content' => 'Answer 1',
        'open' => false
    ],
    // ...
]
```

### 7.6 Tab Navigation
**File:** `resources/views/components/ui/tabs.blade.php`
**Props:**
- `$id` - Tabs ID (required)
- `$tabs` - Array of tab items
- `$variant` - Style variant (pills, tabs) (default: 'pills')

**Data Structure:**
```php
[
    [
        'id' => 'tab1',
        'title' => 'Tab 1',
        'active' => true,
        'content' => 'Tab content'
    ],
    // ...
]
```

---

## 8. Filter Components

### 8.1 Filter Tabs
**File:** `resources/views/components/filters/tabs.blade.php`
**Props:**
- `$filters` - Array of filter options
- `$activeFilter` - Currently active filter ID
- `$onChange` - JavaScript callback function name

**Data Structure:**
```php
[
    ['id' => 'all', 'label' => 'All', 'active' => true],
    ['id' => 'europe', 'label' => 'Europe', 'active' => false],
    // ...
]
```

### 8.2 Price Range Filter
**File:** `resources/views/components/filters/price-range.blade.php`
**Props:**
- `$min` - Minimum price (default: 0)
- `$max` - Maximum price (default: 10000)
- `$step` - Price step (default: 100)

---

## 9. Utility Components

### 9.1 Back to Top
**File:** `resources/views/components/utilities/back-to-top.blade.php`
**Props:**
- `$showAfter` - Scroll position to show button (default: 400)

### 9.2 Loading Spinner
**File:** `resources/views/components/utilities/loading.blade.php`
**Props:**
- `$size` - Spinner size (small, medium, large) (default: 'medium')
- `$text` - Loading text (optional)

### 9.3 Empty State
**File:** `resources/views/components/utilities/empty-state.blade.php`
**Props:**
- `$title` - Empty state title
- `$message` - Empty state message
- `$icon` - Icon class (optional)
- `$actionText` - Action button text (optional)
- `$actionUrl` - Action button URL (optional)

---

## 10. Map Components

### 10.1 Location Map
**File:** `resources/views/components/maps/location.blade.php`
**Props:**
- `$latitude` - Location latitude
- `$longitude` - Location longitude
- `$zoom` - Map zoom level (default: 10)
- `$markerTitle` - Marker title/tooltip
- `$height` - Map height (default: '400px')

---

## Component Usage Examples

### Example 1: Using Destination Card
```blade
<x-cards.destination 
    :destination="$destination" 
    :show-rating="true"
    :show-price="true"
/>
```

### Example 2: Using Package Section
```blade
<x-sections.packages 
    :packages="$packages"
    title="Popular Travel Packages"
    subtitle="Discover amazing destinations"
    :columns="3"
/>
```

### Example 3: Using Swiper Slider
```blade
<x-sliders.swiper 
    :slides="$destinations"
    slider-class="home1-destination-slider"
    :slides-per-view="4"
    :autoplay="true"
    :pagination="true"
>
    @foreach($destinations as $destination)
        <x-sliders.slide>
            <x-cards.destination :destination="$destination" />
        </x-sliders.slide>
    @endforeach
</x-sliders.swiper>
```

### Example 4: Using Section Title
```blade
<x-sections.title 
    title="Our Destinations"
    subtitle="Explore amazing places around the world"
    align="center"
/>
```

---

## Component Organization Structure

```
resources/views/
├── components/
│   ├── cards/
│   │   ├── destination.blade.php
│   │   ├── package.blade.php
│   │   ├── service.blade.php
│   │   ├── blog.blade.php
│   │   └── testimonial.blade.php
│   ├── sections/
│   │   ├── title.blade.php
│   │   ├── banner.blade.php
│   │   ├── offers.blade.php
│   │   ├── destinations.blade.php
│   │   ├── packages.blade.php
│   │   ├── services.blade.php
│   │   ├── testimonials.blade.php
│   │   ├── blog.blade.php
│   │   ├── faq.blade.php
│   │   ├── counter.blade.php
│   │   └── partners.blade.php
│   ├── forms/
│   │   ├── search.blade.php
│   │   ├── booking.blade.php
│   │   ├── contact.blade.php
│   │   └── newsletter.blade.php
│   ├── sliders/
│   │   ├── swiper.blade.php
│   │   └── slide.blade.php
│   ├── navigation/
│   │   ├── breadcrumb.blade.php
│   │   └── pagination.blade.php
│   ├── ui/
│   │   ├── button.blade.php
│   │   ├── badge.blade.php
│   │   ├── rating.blade.php
│   │   ├── modal.blade.php
│   │   ├── accordion.blade.php
│   │   └── tabs.blade.php
│   ├── filters/
│   │   ├── tabs.blade.php
│   │   └── price-range.blade.php
│   ├── utilities/
│   │   ├── back-to-top.blade.php
│   │   ├── loading.blade.php
│   │   └── empty-state.blade.php
│   ├── maps/
│   │   └── location.blade.php
│   ├── header.blade.php
│   └── footer.blade.php
└── layouts/
    └── app.blade.php
```

---

## Implementation Priority

### Phase 1 (Essential)
1. Layout components (app, header, footer)
2. Card components (destination, package)
3. Section title component
4. Button component
5. Basic form components

### Phase 2 (Important)
1. Section components (banner, destinations, packages)
2. Slider components
3. Blog and testimonial cards
4. Navigation components (breadcrumb, pagination)
5. FAQ accordion

### Phase 3 (Enhancement)
1. Filter components
2. Map components
3. Advanced UI components (modal, tabs)
4. Utility components
5. Counter and partner sections

---

This component list provides a complete roadmap for extracting and organizing the theme into reusable Laravel Blade components.



