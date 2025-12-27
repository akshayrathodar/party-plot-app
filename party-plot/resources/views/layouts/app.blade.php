<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no, date=no, email=no, address=no">
    <title>@yield('title', 'Party Plot Listing Platform')</title>

    @stack('meta')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('theme/assets/img/fav-icon.svg') }}" type="image/gif" sizes="20x20">

    <!-- CSS Files -->
    <link href="{{ asset('theme/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/boxicons.min.css') }}" rel="stylesheet">
    <!-- Font Awesome 7.0.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/fontawesome.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/solid.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('theme/assets/css/calendar-css.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/leaflet.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/assets/css/swiper-bundle.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    @include('components.header')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <!-- List Your Venue Modal -->
    <div class="modal fade enquiry-modal" id="listVenueModal" tabindex="-1" aria-labelledby="listVenueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L1 11M1 1L11 11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <div class="modal-header">
                    <h4 class="modal-title" id="listVenueModalLabel">List Your Venue</h4>
                    <p>Fill in the details below and we'll get back to you soon!</p>
                </div>
                <div class="modal-body">
                    <form id="listVenueForm" class="enquiry-form-wrapper">
                        @csrf
                        <div class="form-inner">
                            <label>
                                <i class="fa-solid fa-user me-2"></i>Your Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="venue-request-name" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-inner">
                            <label>
                                <i class="fa-solid fa-city me-2"></i>City <span class="text-danger">*</span>
                            </label>
                            <div class="select-wrapper">
                                <select name="city" id="venue-request-city" required>
                                    <option value="">Select City</option>
                                    @php
                                        $cities = \App\Models\PartyPlot::where('status', 'active')
                                            ->whereIn('listing_status', ['approved', 'pending'])
                                            ->whereNotNull('city')
                                            ->distinct()
                                            ->pluck('city')
                                            ->filter()
                                            ->sort()
                                            ->values();
                                    @endphp
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}">{{ $city }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <input type="text" name="city_other" id="venue-request-city-other" placeholder="Enter your city" style="display: none;">
                        </div>
                        <div class="form-inner">
                            <label>
                                <i class="fa-solid fa-phone me-2"></i>Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="phone" id="venue-request-phone" placeholder="Enter mobile number" required>
                            <small class="form-text d-block mt-2">
                                <i class="fa-solid fa-info-circle me-1"></i>10-digit number or +91XXXXXXXXXX
                            </small>
                        </div>
                        <div class="form-inner text-center mt-4">
                            <button type="submit" class="primary-btn1 w-100">
                                <span>
                                    <i class="fa-solid fa-paper-plane me-2"></i>Submit Request
                                </span>
                                <span>
                                    <i class="fa-solid fa-paper-plane me-2"></i>Submit Request
                                </span>
                            </button>
                            <button type="button" class="primary-btn1 transparent mt-3 w-100" data-bs-dismiss="modal">
                                <span>Cancel</span>
                                <span>Cancel</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="{{ asset('theme/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('theme/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom-calendar.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom-range-calendar.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/select-dropdown.js') }}"></script>
    <script src="{{ asset('theme/assets/js/slick.js') }}"></script>
    <script src="{{ asset('theme/assets/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/leaflet.js') }}"></script>
    <script src="{{ asset('theme/assets/js/range-slider.js') }}"></script>
    <script src="{{ asset('theme/assets/js/dropzone-min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('theme/assets/js/helper.js') }}"></script>
    <script src="{{ asset('theme/assets/js/custom.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('listVenueForm');
        const citySelect = document.getElementById('venue-request-city');
        const cityOtherInput = document.getElementById('venue-request-city-other');

        // Handle city dropdown change
        if (citySelect && cityOtherInput) {
            citySelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    cityOtherInput.classList.add('show');
                    cityOtherInput.setAttribute('required', 'required');
                } else {
                    cityOtherInput.classList.remove('show');
                    cityOtherInput.removeAttribute('required');
                    cityOtherInput.value = '';
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                const originalSpans = submitBtn.querySelectorAll('span');
                const originalFirstSpan = originalSpans.length > 0 ? originalSpans[0].innerHTML : '';
                const originalSecondSpan = originalSpans.length > 1 ? originalSpans[1].innerHTML : '';

                // Validate form
                const name = formData.get('name');
                let city = formData.get('city');
                const cityOther = formData.get('city_other');
                let phone = formData.get('phone');

                // Handle "other" city option
                if (city === 'other') {
                    if (!cityOther || cityOther.trim() === '') {
                        if (typeof showToast === 'function') {
                            showToast('Please enter your city name.', 'error');
                        } else {
                            alert('Please enter your city name.');
                        }
                        return;
                    }
                    city = cityOther.trim();
                    formData.set('city', city);
                }

                if (!name || !city || !phone) {
                    if (typeof showToast === 'function') {
                        showToast('Please fill in all required fields.', 'error');
                    } else {
                        alert('Please fill in all required fields.');
                    }
                    return;
                }

                // Normalize phone number
                phone = phone.replace(/\s+/g, '').replace(/-/g, '');

                // Validate mobile number
                let phoneRegex;
                let normalizedPhone = phone;

                if (phone.startsWith('+91')) {
                    normalizedPhone = phone.substring(3);
                    phoneRegex = /^[6-9]\d{9}$/;
                    if (!phoneRegex.test(normalizedPhone)) {
                        if (typeof showToast === 'function') {
                            showToast('Please enter a valid mobile number. After +91, it should be 10 digits starting with 6, 7, 8, or 9.', 'error');
                        } else {
                            alert('Please enter a valid mobile number.');
                        }
                        return;
                    }
                } else {
                    phoneRegex = /^[6-9]\d{9}$/;
                    if (!phoneRegex.test(phone)) {
                        if (typeof showToast === 'function') {
                            showToast('Please enter a valid 10-digit mobile number starting with 6, 7, 8, or 9, or use format +91XXXXXXXXXX.', 'error');
                        } else {
                            alert('Please enter a valid mobile number.');
                        }
                        return;
                    }
                    normalizedPhone = phone;
                }

                formData.set('phone', normalizedPhone);

                // Show loading state
                submitBtn.disabled = true;
                if (originalSpans.length >= 2) {
                    originalSpans[0].innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Submitting...';
                    originalSpans[1].innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Submitting...';
                } else {
                    submitBtn.innerHTML = '<span><i class="fa-solid fa-spinner fa-spin me-2"></i>Submitting...</span>';
                }

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                                document.querySelector('input[name="_token"]')?.value;

                // Submit to backend
                fetch('{{ route("venue-requests.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal
                        const modalElement = document.getElementById('listVenueModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) {
                            modal.hide();
                        }

                        // Show success toast
                        if (typeof showToast === 'function') {
                            showToast(data.message || 'Thank you! Your request has been submitted successfully. We will contact you soon.', 'success');
                        } else {
                            alert(data.message || 'Thank you! Your request has been submitted successfully.');
                        }

                        // Reset form
                        form.reset();
                    } else {
                        if (typeof showToast === 'function') {
                            showToast('Error: ' + (data.message || 'Something went wrong. Please try again.'), 'error');
                        } else {
                            alert('Error: ' + (data.message || 'Something went wrong. Please try again.'));
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('Thank you! Your request has been submitted. We will contact you soon.', 'success');
                    } else {
                        alert('Thank you! Your request has been submitted. We will contact you soon.');
                    }
                    form.reset();

                    // Close modal
                    const modalElement = document.getElementById('listVenueModal');
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    if (originalSpans.length >= 2) {
                        originalSpans[0].innerHTML = originalFirstSpan;
                        originalSpans[1].innerHTML = originalSecondSpan;
                    } else {
                        submitBtn.innerHTML = originalText;
                    }
                });
            });
        }
    });
    </script>

    <style>
    /* Custom Modal Styling for List Venue */
    #listVenueModal.enquiry-modal .modal-dialog {
        max-width: 600px;
    }

    #listVenueModal.enquiry-modal .modal-content {
        border-radius: 20px;
        padding: 50px 40px;
        position: relative;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 576px) {
        #listVenueModal.enquiry-modal .modal-content {
            border-radius: 15px;
            padding: 40px 25px;
        }
    }

    #listVenueModal.enquiry-modal .close-btn {
        width: 36px;
        height: 36px;
        background-color: #F0F0F0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        top: 20px;
        right: 20px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    #listVenueModal.enquiry-modal .close-btn:hover {
        background-color: var(--primary-color1);
    }

    #listVenueModal.enquiry-modal .close-btn svg {
        stroke: var(--title-color);
        transition: all 0.3s ease;
    }

    #listVenueModal.enquiry-modal .close-btn:hover svg {
        stroke: var(--white-color);
    }

    #listVenueModal.enquiry-modal .modal-header {
        display: block;
        text-align: center;
        padding: 0;
        border: none;
        margin-bottom: 35px;
    }

    #listVenueModal.enquiry-modal .modal-header h4 {
        font-family: var(--font-poppins);
        font-size: 28px;
        font-weight: 600;
        color: var(--title-color);
        margin-bottom: 12px;
    }

    #listVenueModal.enquiry-modal .modal-header p {
        font-size: 15px;
        color: var(--text-color);
        margin: 0;
        opacity: 0.8;
    }

    #listVenueModal.enquiry-modal .modal-body {
        padding: 0;
    }

    #listVenueModal.enquiry-modal .enquiry-form-wrapper {
        padding: 0;
    }

    #listVenueModal.enquiry-modal .form-inner {
        margin-bottom: 25px;
    }

    #listVenueModal.enquiry-modal .form-inner label {
        display: block;
        font-family: var(--font-poppins);
        font-size: 14px;
        font-weight: 500;
        color: var(--title-color);
        margin-bottom: 10px;
    }

    #listVenueModal.enquiry-modal .form-inner label i {
        color: var(--primary-color1);
    }

    #listVenueModal.enquiry-modal .form-inner input {
        width: 100%;
        padding: 14px 18px;
        background-color: #F0F0F0;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 15px;
        font-family: var(--font-roboto);
        color: var(--title-color);
        transition: all 0.3s ease;
    }

    #listVenueModal.enquiry-modal .form-inner input:focus {
        outline: none;
        background-color: var(--white-color);
        border-color: var(--primary-color1);
        box-shadow: 0 0 0 3px rgba(23, 129, 254, 0.1);
    }

    #listVenueModal.enquiry-modal .form-inner input::placeholder {
        color: var(--text-color);
        opacity: 0.6;
    }

    /* Select Dropdown Styling */
    #listVenueModal.enquiry-modal .form-inner .select-wrapper {
        position: relative;
        width: 100%;
    }

    #listVenueModal.enquiry-modal .form-inner .select-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 18px;
        transform: translateY(-50%);
        width: 12px;
        height: 8px;
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23110F0F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-size: contain;
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 1;
    }

    #listVenueModal.enquiry-modal .form-inner .select-wrapper:focus-within::after {
        background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%231781FE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    }

    #listVenueModal.enquiry-modal .form-inner select {
        width: 100%;
        padding: 14px 45px 14px 18px;
        background-color: #F0F0F0;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 15px;
        font-family: var(--font-roboto);
        color: var(--title-color);
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
    }

    #listVenueModal.enquiry-modal .form-inner select:focus {
        outline: none;
        background-color: var(--white-color);
        border-color: var(--primary-color1);
        box-shadow: 0 0 0 3px rgba(23, 129, 254, 0.1);
    }

    #listVenueModal.enquiry-modal .form-inner select option {
        padding: 12px;
        background-color: var(--white-color);
        color: var(--title-color);
        font-size: 15px;
    }

    #listVenueModal.enquiry-modal .form-inner select option:first-child {
        color: var(--text-color);
        opacity: 0.7;
    }

    #listVenueModal.enquiry-modal .form-inner #venue-request-city-other {
        display: none;
        width: 100%;
        padding: 14px 18px;
        background-color: #F0F0F0;
        border: 1px solid transparent;
        border-radius: 10px;
        font-size: 15px;
        font-family: var(--font-roboto);
        color: var(--title-color);
        transition: all 0.3s ease;
        margin-top: 12px;
    }

    #listVenueModal.enquiry-modal .form-inner #venue-request-city-other.show {
        display: block;
    }

    #listVenueModal.enquiry-modal .form-inner #venue-request-city-other:focus {
        outline: none;
        background-color: var(--white-color);
        border-color: var(--primary-color1);
        box-shadow: 0 0 0 3px rgba(23, 129, 254, 0.1);
    }

    #listVenueModal.enquiry-modal .form-inner #venue-request-city-other::placeholder {
        color: var(--text-color);
        opacity: 0.6;
    }

    #listVenueModal.enquiry-modal .form-inner .form-text {
        font-size: 12px;
        color: var(--text-color);
        opacity: 0.7;
        margin-top: 8px;
    }

    #listVenueModal.enquiry-modal .form-inner .form-text i {
        color: var(--primary-color1);
    }

    #listVenueModal.enquiry-modal .primary-btn1.w-100 {
        width: 100%;
        margin-bottom: 0;
    }

    #listVenueModal.enquiry-modal .primary-btn1.transparent {
        background: transparent;
        border: 1px solid var(--borders-color);
        color: var(--title-color);
    }

    #listVenueModal.enquiry-modal .primary-btn1.transparent:hover {
        border-color: var(--primary-color1);
        color: var(--white-color);
    }

    #listVenueModal.enquiry-modal .primary-btn1:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    </style>

    @stack('scripts')
</body>
</html>
