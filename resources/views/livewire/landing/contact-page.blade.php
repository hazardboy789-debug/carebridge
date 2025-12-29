<div>
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        <h1 class="heading-title">Online Medical Consultation</h1>
                        <p class="mb-0 lead">
                            Connect with certified Sri Lankan doctors from the comfort of your home. 
                            CareBridge provides secure, convenient, and affordable telemedicine services 
                            for all your healthcare needs across Sri Lanka.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Page Title -->

    <!-- Consultation Features -->
    <div class="container consultation-features" data-aos="fade-up">
        <div class="row text-center mb-5">
            <div class="col-lg-12">
                <h2>Why Choose CareBridge Online Consultation?</h2>
                <p class="text-muted">Experience healthcare reimagined for the digital age</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <i class="bi bi-clock-history"></i>
                    <h4>24/7 Availability</h4>
                    <p>Consult with doctors anytime, anywhere across Sri Lanka</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <i class="bi bi-shield-check"></i>
                    <h4>Certified Doctors</h4>
                    <p>All doctors verified by Sri Lanka Medical Council</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <i class="bi bi-prescription2"></i>
                    <h4>Digital Prescriptions</h4>
                    <p>Get e-prescriptions delivered to your phone or email</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-card">
                    <i class="bi bi-truck"></i>
                    <h4>Medicine Delivery</h4>
                    <p>Get prescribed medicines delivered to your doorstep</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="info-box">
                        <i class="bi bi-geo-alt"></i>
                        <h3>Head Office</h3>
                        <p>CareBridge Health Solutions<br>
                        123 Medical Square, Colombo 07<br>
                        Sri Lanka</p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="info-box">
                        <i class="bi bi-telephone"></i>
                        <h3>Call Us</h3>
                        <p>General Inquiries: +94 11 234 5678<br>
                        Emergency Support: +94 76 123 4567<br>
                        Consultation Hotline: 1999 (Toll-free)</p>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="info-box">
                        <i class="bi bi-envelope"></i>
                        <h3>Email Us</h3>
                        <p>consultation@carebridge.lk<br>
                        support@carebridge.lk<br>
                        doctors@carebridge.lk</p>
                    </div>
                </div>
            </div>

            <!-- Consultation Steps -->
            <div class="steps-container" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-center mb-5">How Online Consultation Works</h3>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="step-item">
                            <div class="step-number">1</div>
                            <div>
                                <h4>Register & Book Appointment</h4>
                                <p>Create your CareBridge account and select a doctor based on specialty, availability, or ratings.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">2</div>
                            <div>
                                <h4>Connect via Video/Audio</h4>
                                <p>At your scheduled time, connect with the doctor through our secure video consultation platform.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div>
                                <h4>Consult with Doctor</h4>
                                <p>Discuss your health concerns, share symptoms, and get professional medical advice.</p>
                            </div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">4</div>
                            <div>
                                <h4>Receive Prescription & Follow-up</h4>
                                <p>Get digital prescription and follow-up advice. Schedule next appointment if needed.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row gy-4 mt-4">
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798511757586!2d79.85743247460554!3d6.914019018370761!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25963120c31d7%3A0x2d3d3b2b4e6e4f5d!2sColombo%2007%2C%20Sri%20Lanka!5e0!3m2!1sen!2s!4v1692395638095!5m2!1sen!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
                    <form wire:submit.prevent="submitForm" class="php-email-form">
                        <h3 class="mb-4">Schedule a Consultation</h3>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <input type="text" wire:model="name" class="form-control" placeholder="Your Full Name" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="tel" wire:model="phone" class="form-control" placeholder="Phone Number" required>
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <input type="email" wire:model="email" class="form-control" placeholder="Email Address" required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <select wire:model="specialty" class="form-control" required>
                                    <option value="" disabled selected>Select Medical Specialty</option>
                                    <option value="general">General Physician</option>
                                    <option value="pediatrics">Pediatrics</option>
                                    <option value="cardiology">Cardiology</option>
                                    <option value="dermatology">Dermatology</option>
                                    <option value="psychiatry">Psychiatry</option>
                                    <option value="gynecology">Gynecology</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('specialty') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <textarea wire:model="symptoms" class="form-control" rows="5" placeholder="Brief description of symptoms or health concern" required></textarea>
                                @error('symptoms') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input wire:model="terms" class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">terms and conditions</a> and understand that this is not an emergency service.
                                    </label>
                                    @error('terms') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                @if (session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                
                                <div wire:loading wire:target="submitForm" class="loading">Processing your request...</div>
                                
                                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary">
                                    <span wire:loading.remove wire:target="submitForm">Request Consultation</span>
                                    <span wire:loading wire:target="submitForm">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Consultation CTA -->
            <div class="consultation-cta" data-aos="zoom-in" data-aos-delay="200">
                <h2>Need Immediate Medical Advice?</h2>
                <p class="lead mb-4">Connect with a doctor in less than 30 minutes. No need to wait in queues or travel to clinics.</p>
                <button wire:click="startInstantConsultation" class="cta-button" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="startInstantConsultation">Start Instant Consultation Now</span>
                    <span wire:loading wire:target="startInstantConsultation">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Redirecting...
                    </span>
                </button>
                <p class="mt-3">Available 24/7 • SLMC Certified Doctors • Prescription Delivery</p>
            </div>

            <div class="social-links text-center mt-5" data-aos="zoom-in" data-aos-delay="700">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                <a href="#" class="youtube"><i class="bi bi-youtube"></i></a>
                <a href="#" class="whatsapp"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    :root {
        --primary-color: #1a76d1;
        --secondary-color: #0d4d8c;
        --accent-color: #34b7f1;
        --light-bg: #f8fafc;
        --text-dark: #2d3748;
        --text-light: #718096;
    }
    
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
    }
    
    .page-title {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 100px 0 60px;
        margin-bottom: 40px;
    }
    
    .heading-title {
        font-weight: 700;
        font-size: 3rem;
        margin-bottom: 20px;
    }
    
    .section {
        padding: 80px 0;
    }
    
    .contact {
        background-color: var(--light-bg);
    }
    
    .info-box {
        background: white;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        border-radius: 10px;
        height: 100%;
        transition: transform 0.3s ease;
        border-top: 4px solid var(--primary-color);
    }
    
    .info-box:hover {
        transform: translateY(-10px);
    }
    
    .info-box i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .info-box h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--secondary-color);
    }
    
    .map-container {
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .map-container iframe {
        width: 100%;
        height: 100%;
        min-height: 400px;
        border: none;
    }
    
    .php-email-form {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }
    
    .form-control {
        padding: 12px 15px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(52, 183, 241, 0.2);
    }
    
    button[type="submit"], .btn-primary {
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        color: white;
        border: none;
        padding: 14px 40px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        margin-top: 10px;
    }
    
    button[type="submit"]:hover, .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(52, 183, 241, 0.3);
    }
    
    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        margin: 0 10px;
        font-size: 1.2rem;
        transition: all 0.3s;
    }
    
    .social-links a:hover {
        background: var(--secondary-color);
        transform: translateY(-5px);
    }
    
    .consultation-features {
        background-color: white;
        padding: 60px 0;
        border-radius: 15px;
        margin-top: 40px;
    }
    
    .feature-card {
        text-align: center;
        padding: 30px 20px;
        border-radius: 10px;
        transition: all 0.3s;
        margin-bottom: 30px;
    }
    
    .feature-card:hover {
        background-color: var(--light-bg);
        transform: translateY(-10px);
    }
    
    .feature-card i {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .feature-card h4 {
        color: var(--secondary-color);
        margin-bottom: 15px;
    }
    
    .steps-container {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        margin-top: 40px;
    }
    
    .step-item {
        display: flex;
        margin-bottom: 30px;
        align-items: flex-start;
    }
    
    .step-number {
        background: var(--primary-color);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin-right: 20px;
        flex-shrink: 0;
    }
    
    .consultation-cta {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 60px 0;
        border-radius: 15px;
        margin-top: 60px;
        text-align: center;
    }
    
    .consultation-cta h2 {
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .cta-button {
        background: white;
        color: var(--primary-color);
        border: none;
        padding: 15px 40px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        margin-top: 20px;
    }
    
    .cta-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 768px) {
        .heading-title {
            font-size: 2.2rem;
        }
        
        .map-container iframe {
            min-height: 300px;
        }
        
        .steps-container {
            padding: 20px;
        }
    }
    
    .loading {
        display: none;
        color: var(--primary-color);
        font-weight: bold;
    }
    
    .text-danger {
        font-size: 0.875rem;
        margin-top: -15px;
        margin-bottom: 15px;
        display: block;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS (Animate on Scroll)
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });
</script>
@endpush