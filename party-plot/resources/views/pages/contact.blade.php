@extends('layouts.app')

@section('title', 'Contact Us - Party Plot Listing Platform')

@section('content')
<!-- Breadcrumb Section Start-->
<div class="breadcrumb-section mb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End-->

<!--Contact Page Start-->
<div class="contact-page-section mb-100">
    <div class="container">
        <div class="row gy-4 mb-60">
            <div class="col-lg-4 col-md-6">
                <div class="single-contact">
                    <div class="icon">
                        <svg width="36" height="36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.9981 1.125C15.0037 1.12887 12.133 2.32012 10.0156 4.4375C7.89824 6.55489 6.70699 9.42557 6.70313 12.42C6.70312 16.2056 10.7587 22.2638 13.92 26.4037C9.99937 27.0562 7.51875 28.6087 7.51875 30.4706C7.51875 32.9794 12.0244 34.875 17.9981 34.875C23.9719 34.875 28.4831 32.9794 28.4831 30.4706C28.4831 28.6087 26.0025 27.0562 22.0762 26.4037C25.2375 22.2581 29.2931 16.2056 29.2931 12.42C29.2893 9.42557 28.098 6.55489 25.9806 4.4375C23.8632 2.32012 20.9926 1.12887 17.9981 1.125Z"/>
                        </svg>
                    </div>
                    <h4>Rajkot Office</h4>
                    <h6><span>Contact :</span> <a href="tel:+919876543210">+91 987 654 3210</a></h6>
                    <p>123 Main Street, Rajkot, Gujarat, India</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-contact two">
                    <div class="icon">
                        <svg width="36" height="36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.9981 1.125C15.0037 1.12887 12.133 2.32012 10.0156 4.4375C7.89824 6.55489 6.70699 9.42557 6.70313 12.42C6.70312 16.2056 10.7587 22.2638 13.92 26.4037C9.99937 27.0562 7.51875 28.6087 7.51875 30.4706C7.51875 32.9794 12.0244 34.875 17.9981 34.875C23.9719 34.875 28.4831 32.9794 28.4831 30.4706C28.4831 28.6087 26.0025 27.0562 22.0762 26.4037C25.2375 22.2581 29.2931 16.2056 29.2931 12.42C29.2893 9.42557 28.098 6.55489 25.9806 4.4375C23.8632 2.32012 20.9926 1.12887 17.9981 1.125Z"/>
                        </svg>
                    </div>
                    <h4>Ahmedabad Office</h4>
                    <h6><span>Contact :</span> <a href="tel:+919876543211">+91 987 654 3211</a></h6>
                    <p>456 Business Park, Ahmedabad, Gujarat, India</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-contact three">
                    <div class="icon">
                        <svg width="36" height="36" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.9981 1.125C15.0037 1.12887 12.133 2.32012 10.0156 4.4375C7.89824 6.55489 6.70699 9.42557 6.70313 12.42C6.70312 16.2056 10.7587 22.2638 13.92 26.4037C9.99937 27.0562 7.51875 28.6087 7.51875 30.4706C7.51875 32.9794 12.0244 34.875 17.9981 34.875C23.9719 34.875 28.4831 32.9794 28.4831 30.4706C28.4831 28.6087 26.0025 27.0562 22.0762 26.4037C25.2375 22.2581 29.2931 16.2056 29.2931 12.42C29.2893 9.42557 28.098 6.55489 25.9806 4.4375C23.8632 2.32012 20.9926 1.12887 17.9981 1.125Z"/>
                        </svg>
                    </div>
                    <h4>Surat Office</h4>
                    <h6><span>Contact :</span> <a href="tel:+919876543212">+91 987 654 3212</a></h6>
                    <p>789 Commercial Street, Surat, Gujarat, India</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="contact-form-wrap">
                        <div class="section-title text-center mb-60">
                            <h2>Get in Touch!</h2>
                            <p>We're excited to hear from you! Whether you have a question about our services, want to list your party plot, or need support.</p>
                        </div>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="row g-4 mb-60">
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" placeholder="Your Name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone" placeholder="+91 987 654 3210" value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-inner">
                                        <label>Subject <span class="text-danger">*</span></label>
                                        <select name="subject" required>
                                            <option value="">Select Subject</option>
                                            <option value="general" {{ old('subject') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                            <option value="list-plot" {{ old('subject') == 'list-plot' ? 'selected' : '' }}>List My Party Plot</option>
                                            <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Support</option>
                                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('subject')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>Message <span class="text-danger">*</span></label>
                                        <textarea name="message" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                                        @error('message')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" id="contactCheck" name="terms" required>
                                            <label class="form-check-label" for="contactCheck">
                                                I agree with the privacy policy & terms & conditions.
                                            </label>
                                        </div>
                                        @error('terms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <button type="submit" class="primary-btn1">
                                <span>
                                    Submit Now
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z"></path>
                                    </svg>
                                </span>
                                <span>
                                    Submit Now
                                    <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.73535 1.14746C9.57033 1.97255 9.32924 3.26406 9.24902 4.66797C9.16817 6.08312 9.25559 7.5453 9.70214 8.73633C9.84754 9.12406 9.65129 9.55659 9.26367 9.70215C8.9001 9.83849 8.4969 9.67455 8.32812 9.33398L8.29785 9.26367L8.19921 8.98438C7.73487 7.5758 7.67054 5.98959 7.75097 4.58203C7.77875 4.09598 7.82525 3.62422 7.87988 3.17969L1.53027 9.53027C1.23738 9.82317 0.762615 9.82317 0.469722 9.53027C0.176829 9.23738 0.176829 8.76262 0.469722 8.46973L6.83593 2.10254C6.3319 2.16472 5.79596 2.21841 5.25 2.24902C3.8302 2.32862 2.2474 2.26906 0.958003 1.79102L0.704097 1.68945L0.635738 1.65527C0.303274 1.47099 0.157578 1.06102 0.310542 0.704102C0.463655 0.347333 0.860941 0.170391 1.22363 0.28418L1.29589 0.310547L1.48828 0.387695C2.47399 0.751207 3.79966 0.827571 5.16601 0.750977C6.60111 0.670504 7.97842 0.428235 8.86132 0.262695L9.95312 0.0585938L9.73535 1.14746Z"></path>
                                    </svg>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Contact Page End-->

<!--Contact Map Section Start-->
<div class="contact-map-section">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.123456789!2d70.7890123456789!3d22.3034567890123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjLCsDE4JzEyLjQiTiA3MMKwNDcnMjAuNCJF!5e0!3m2!1sen!2sin!4v1234567890123!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
<!--Contact Map Section End-->
@endsection

