<div>
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-10">
                        <h1 class="heading-title">Our Medical Specialists</h1>
                        <p class="mb-0 lead">
                            Meet our team of experienced Sri Lankan doctors dedicated to providing 
                            exceptional healthcare. All specialists are certified by the Sri Lanka 
                            Medical Council and available for both in-person and online consultations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Page Title -->

    <!-- Doctors Section -->
    <section id="doctors" class="doctors section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <!-- Filterable Doctor Directory -->
            <div class="doctor-directory mb-5">
                <div class="directory-bar p-3 p-md-4 rounded-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-5">
                            <label for="doctor-search" class="form-label mb-1">Search Doctors</label>
                            <div class="position-relative">
                                <i class="bi bi-search search-icon"></i>
                                <input id="doctor-search" type="text" class="form-control search-input" placeholder="Search by name, specialty, or hospital">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label mb-1">Specialty</label>
                            <select class="form-select">
                                <option value="*">All Specialties</option>
                                <option value=".filter-cardiology">Cardiology</option>
                                <option value=".filter-pediatrics">Pediatrics</option>
                                <option value=".filter-dermatology">Dermatology</option>
                                <option value=".filter-gastroenterology">Gastroenterology</option>
                                <option value=".filter-neurology">Neurology</option>
                                <option value=".filter-orthopedics">Orthopedics</option>
                                <option value=".filter-oncology">Oncology</option>
                                <option value=".filter-psychiatry">Psychiatry</option>
                            </select>
                        </div>
                        <div class="col-lg-3 d-grid">
                            <button class="btn btn-appointment">Search Doctors</button>
                        </div>
                    </div>
                </div>

                <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                    <ul class="directory-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
                        <li data-filter="*" class="filter-active">All Specialties</li>
                        <li data-filter=".filter-cardiology">Cardiology</li>
                        <li data-filter=".filter-pediatrics">Pediatrics</li>
                        <li data-filter=".filter-dermatology">Dermatology</li>
                        <li data-filter=".filter-gastroenterology">Gastroenterology</li>
                        <li data-filter=".filter-neurology">Neurology</li>
                        <li data-filter=".filter-orthopedics">Orthopedics</li>
                    </ul><!-- End Directory Filters -->

                    <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="300">

                        <!-- Cardiology -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-cardiology">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Asiri Perera" loading="lazy">
                                    <span class="tag">Senior Consultant</span>
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Asiri Perera</h3>
                                    <p class="doctor-title">Consultant Cardiologist • MBBS, MD, FRCP</p>
                                    <p class="doctor-desc">Specializes in interventional cardiology with 15+ years experience at Colombo National Hospital.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Cardiology</span>
                                        <span class="badge hospital">Colombo National Hospital</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Pediatrics -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-pediatrics">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1594824434340-7e7dfc37cabb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Nirmali Silva" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Nirmali Silva</h3>
                                    <p class="doctor-title">Pediatric Specialist • MBBS, DCH, MD</p>
                                    <p class="doctor-desc">Expert in childhood diseases and vaccinations with special focus on neonatal care.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Pediatrics</span>
                                        <span class="badge hospital">Lady Ridgeway Hospital</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Dermatology -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-dermatology">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1527613426441-4da17471b66d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Ruvini Fernando" loading="lazy">
                                    <span class="tag alt">Skin Cancer Specialist</span>
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Ruvini Fernando</h3>
                                    <p class="doctor-title">Consultant Dermatologist • MBBS, MD, DVD</p>
                                    <p class="doctor-desc">Expert in tropical skin diseases, cosmetic dermatology, and laser treatments.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Dermatology</span>
                                        <span class="badge hospital">Nawaloka Hospital</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Orthopedics -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-orthopedics">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Shanaka Rathnayake" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Shanaka Rathnayake</h3>
                                    <p class="doctor-title">Orthopedic Surgeon • MBBS, MS, FRCS</p>
                                    <p class="doctor-desc">Specializes in joint replacements and sports injuries with 12 years of surgical experience.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Orthopedics</span>
                                        <span class="badge hospital">Asiri Surgical Hospital</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Gastroenterology -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-gastroenterology">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Chathura Gunawardena" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Chathura Gunawardena</h3>
                                    <p class="doctor-title">Gastroenterologist • MBBS, MD, DM</p>
                                    <p class="doctor-desc">Expert in endoscopic procedures and liver diseases. Special interest in hepatology.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Gastroenterology</span>
                                        <span class="badge hospital">Lanka Hospitals</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Neurology -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-neurology">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Dilshan Rajapakse" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Dilshan Rajapakse</h3>
                                    <p class="doctor-title">Neurologist • MBBS, MD, DM</p>
                                    <p class="doctor-desc">Specializes in stroke management, epilepsy, and movement disorders.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Neurology</span>
                                        <span class="badge hospital">Neurology Institute Sri Lanka</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Psychiatry -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-psychiatry">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Anoma Jayasinghe" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Anoma Jayasinghe</h3>
                                    <p class="doctor-title">Consultant Psychiatrist • MBBS, MD</p>
                                    <p class="doctor-desc">Specializes in anxiety, depression, and stress-related disorders with cognitive therapy.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Psychiatry</span>
                                        <span class="badge hospital">National Institute of Mental Health</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                        <!-- Oncology -->
                        <div class="col-lg-3 col-md-6 doctor-item isotope-item filter-oncology">
                            <article class="doctor-card h-100">
                                <figure class="doctor-media">
                                    <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid" alt="Dr. Sanjaya Bandara" loading="lazy">
                                </figure>
                                <div class="doctor-content">
                                    <h3 class="doctor-name">Dr. Sanjaya Bandara</h3>
                                    <p class="doctor-title">Oncologist • MBBS, MD, DM</p>
                                    <p class="doctor-desc">Specializes in medical oncology with expertise in chemotherapy and targeted therapies.</p>
                                    <div class="doctor-meta">
                                        <span class="badge dept">Oncology</span>
                                        <span class="badge hospital">Apeksha Hospital Maharagama</span>
                                    </div>
                                    <div class="doctor-actions">
                                        <a href="#" class="btn btn-sm btn-appointment">Book Appointment</a>
                                        <a href="#" class="btn btn-sm btn-soft">View Profile</a>
                                    </div>
                                </div>
                            </article>
                        </div><!-- End Directory Item -->

                    </div><!-- End Directory Items Container -->
                </div>
            </div><!-- End Filterable Doctor Directory -->

            <!-- Featured Doctor Profile -->
            <div class="single-profile mt-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5" data-aos="fade-right" data-aos-delay="150">
                        <div class="profile-media">
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" class="img-fluid" alt="Prof. Ranjith De Silva">
                            <div class="availability">
                                <i class="bi bi-circle-fill me-1 text-success"></i> Available for Online Consultation
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                        <div class="profile-content">
                            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                <span class="badge role">Professor of Medicine</span>
                                <span class="badge years">25+ Years Experience</span>
                                <span class="badge cert">SLMC Certified</span>
                            </div>
                            <h3 class="name mb-1">Prof. Ranjith De Silva</h3>
                            <p class="title mb-3">Senior Consultant Physician • MBBS, MD, FRCP</p>
                            <p class="bio mb-3">Professor De Silva is a distinguished physician with over 25 years of clinical experience. He served as the Head of the Department of Medicine at Colombo University and has published extensively in international medical journals. Special interests include diabetes management, hypertension, and preventive cardiology.</p>
                            <ul class="list-unstyled highlights mb-4">
                                <li><i class="bi bi-mortarboard"></i> Former Head - Department of Medicine, Colombo University</li>
                                <li><i class="bi bi-hospital"></i> Consultant Physician - Colombo National Hospital</li>
                                <li><i class="bi bi-award"></i> Recipient of Presidential Award for Medical Excellence (2020)</li>
                                <li><i class="bi bi-globe"></i> Available in English, Sinhala & Tamil</li>
                            </ul>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="#" class="btn btn-appointment"><i class="bi bi-calendar2-check me-1"></i> Book Appointment</a>
                                <a href="#" class="btn btn-soft"><i class="bi bi-camera-video me-1"></i> Online Consultation</a>
                                <a href="#" class="btn btn-outline-primary"><i class="bi bi-file-earmark-text me-1"></i> View Publications</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Featured Doctor Profile -->

            <!-- Sri Lankan Medical Specialists (Compact View) -->
            <div class="compact-view mt-5">
                <h3 class="text-center mb-4">More Sri Lankan Specialists</h3>
                <div class="row g-3">
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1594824434340-7e7dfc37cabb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Kamala Wijeratne" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Kamala Wijeratne</h6>
                                <small class="text-muted">Obstetrics & Gynecology</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="150">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Priyantha Gunaratne" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Priyantha Gunaratne</h6>
                                <small class="text-muted">General Surgery</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1527613426441-4da17471b66d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Samadhi Rajapaksha" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Samadhi Rajapaksha</h6>
                                <small class="text-muted">Endocrinology</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="250">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Lakshman Perera" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Lakshman Perera</h6>
                                <small class="text-muted">Urology</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="300">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Nadeeka Gamage" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Nadeeka Gamage</h6>
                                <small class="text-muted">Rheumatology</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="350">
                        <div class="minimal-card text-center">
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=200&q=80" alt="Dr. Roshan Mendis" class="avatar img-fluid" loading="lazy">
                            <div class="info">
                                <h6 class="mb-0">Dr. Roshan Mendis</h6>
                                <small class="text-muted">Pulmonology</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Compact View -->

            <!-- Doctor with Tabs (Sri Lankan Context) -->
            <div class="profile-tabs mt-5">
                <div class="row g-4">
                    <div class="col-lg-4" data-aos="fade-right" data-aos-delay="150">
                        <div class="tab-profile-card">
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" class="img-fluid rounded-3" alt="Dr. Tharindu Jayawardena" loading="lazy">
                            <div class="pt-3">
                                <h4 class="mb-1">Dr. Tharindu Jayawardena</h4>
                                <p class="mb-2">Consultant Pediatrician • MBBS, MD, DCH</p>
                                <div class="d-flex gap-2">
                                    <span class="badge cert">SLMC Certified</span>
                                    <span class="badge years">18 Years Experience</span>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-1"><i class="bi bi-hospital me-1"></i> Lady Ridgeway Hospital</p>
                                    <p class="mb-0"><i class="bi bi-telephone me-1"></i> +94 77 123 4567</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8" data-aos="fade-left" data-aos-delay="200">
                        <ul class="nav nav-pills mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#sri-doc-tab-1" type="button" role="tab">Specializations</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sri-doc-tab-2" type="button" role="tab">Availability</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sri-doc-tab-3" type="button" role="tab">Languages</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="sri-doc-tab-1" role="tabpanel">
                                <h5>Areas of Expertise</h5>
                                <p>Dr. Jayawardena specializes in pediatric care with particular focus on:</p>
                                <ul class="list-unstyled mb-0">
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Neonatal intensive care</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Childhood vaccinations and immunization</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Pediatric infectious diseases</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Growth and development monitoring</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i> Childhood asthma and allergies</li>
                                </ul>
                                <div class="mt-3">
                                    <h6>Education & Training:</h6>
                                    <p>MBBS - University of Colombo, MD Pediatrics - PGIM, DCH - Royal College of Physicians</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sri-doc-tab-2" role="tabpanel">
                                <h5>Consultation Schedule</h5>
                                <div class="schedule-grid">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Monday</strong>
                                                <span>9:00 AM - 1:00 PM</span>
                                                <small class="text-success">Available</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Tuesday</strong>
                                                <span>2:00 PM - 6:00 PM</span>
                                                <small class="text-success">Available</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Wednesday</strong>
                                                <span>9:00 AM - 12:00 PM</span>
                                                <small class="text-success">Available</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Thursday</strong>
                                                <span>Online Only</span>
                                                <small class="text-info">Telemedicine</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Friday</strong>
                                                <span>9:00 AM - 1:00 PM</span>
                                                <small class="text-success">Available</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="slot">
                                                <strong>Saturday</strong>
                                                <span>9:00 AM - 12:00 PM</span>
                                                <small class="text-warning">Limited Slots</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="#" class="btn btn-appointment"><i class="bi bi-calendar-event me-1"></i> Book Appointment</a>
                                    <a href="#" class="btn btn-outline-primary ms-2"><i class="bi bi-camera-video me-1"></i> Schedule Online</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sri-doc-tab-3" role="tabpanel">
                                <h5>Languages Spoken</h5>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="language-item text-center p-3 border rounded">
                                            <i class="bi bi-translate fs-1 text-primary"></i>
                                            <h6 class="mt-2">Sinhala</h6>
                                            <small>Native Proficiency</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="language-item text-center p-3 border rounded">
                                            <i class="bi bi-translate fs-1 text-primary"></i>
                                            <h6 class="mt-2">English</h6>
                                            <small>Professional Proficiency</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="language-item text-center p-3 border rounded">
                                            <i class="bi bi-translate fs-1 text-primary"></i>
                                            <h6 class="mt-2">Tamil</h6>
                                            <small>Conversational</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <h6>Consultation Notes:</h6>
                                    <ul>
                                        <li>All consultations include follow-up advice via CareBridge app</li>
                                        <li>Digital prescriptions available immediately after consultation</li>
                                        <li>Emergency consultations available via CareBridge emergency line</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Doctor Profile with Tabs -->

        </div>
    </section><!-- /Doctors Section -->
</div>

@push('styles')
<style>
    :root {
        --primary-color: #1a76d1;
        --secondary-color: #0d4d8c;
        --accent-color: #34b7f1;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --light-bg: #f8fafc;
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
    
    .doctor-directory {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .directory-bar {
        background: var(--light-bg);
        border: 1px solid #e2e8f0;
    }
    
    .search-input {
        padding-left: 40px;
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    
    .btn-appointment {
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-appointment:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 183, 241, 0.3);
        color: white;
    }
    
    .btn-soft {
        background: var(--light-bg);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-soft:hover {
        background: var(--primary-color);
        color: white;
    }
    
    .doctor-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .doctor-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .doctor-media {
        position: relative;
        overflow: hidden;
        height: 250px;
    }
    
    .doctor-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .doctor-card:hover .doctor-media img {
        transform: scale(1.05);
    }
    
    .tag {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--primary-color);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .tag.alt {
        background: var(--success-color);
    }
    
    .doctor-content {
        padding: 20px;
    }
    
    .doctor-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 5px;
    }
    
    .doctor-title {
        color: #64748b;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    
    .doctor-desc {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    .badge.dept {
        background: rgba(52, 183, 241, 0.1);
        color: var(--accent-color);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .badge.hospital {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 5px;
    }
    
    .doctor-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
    }
    
    .single-profile {
        background: white;
        border-radius: 15px;
        padding: 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .profile-media {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .profile-media img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }
    
    .availability {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(255,255,255,0.95);
        padding: 10px 20px;
        font-weight: 600;
        color: var(--success-color);
    }
    
    .badge.role {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .badge.years {
        background: rgba(255, 193, 7, 0.1);
        color: var(--warning-color);
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .badge.cert {
        background: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .name {
        font-size: 2rem;
        font-weight: 700;
        color: var(--secondary-color);
    }
    
    .title {
        color: #64748b;
        font-size: 1.1rem;
    }
    
    .bio {
        font-size: 1rem;
        line-height: 1.6;
        color: #475569;
    }
    
    .highlights li {
        padding: 5px 0;
        color: #475569;
    }
    
    .highlights i {
        color: var(--primary-color);
        margin-right: 10px;
    }
    
    .compact-view {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .minimal-card {
        background: var(--light-bg);
        border-radius: 10px;
        padding: 20px;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .minimal-card:hover {
        background: white;
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 3px solid var(--primary-color);
        padding: 3px;
    }
    
    .profile-tabs {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .tab-profile-card {
        background: var(--light-bg);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        height: 100%;
    }
    
    .tab-profile-card img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 20px;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .nav-pills .nav-link {
        color: var(--secondary-color);
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        margin-right: 10px;
    }
    
    .nav-pills .nav-link.active {
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        color: white;
    }
    
    .schedule-grid .slot {
        background: var(--light-bg);
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: all 0.3s;
    }
    
    .schedule-grid .slot:hover {
        background: rgba(52, 183, 241, 0.1);
        transform: translateY(-2px);
    }
    
    .schedule-grid .slot strong {
        display: block;
        color: var(--secondary-color);
        font-weight: 700;
    }
    
    .schedule-grid .slot span {
        color: #64748b;
        font-size: 0.9rem;
    }
    
    .directory-filters {
        list-style: none;
        padding: 0;
        margin: 30px 0;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .directory-filters li {
        padding: 8px 20px;
        background: var(--light-bg);
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        color: #64748b;
        transition: all 0.3s;
    }
    
    .directory-filters li.filter-active,
    .directory-filters li:hover {
        background: linear-gradient(to right, var(--primary-color), var(--accent-color));
        color: white;
    }
    
    .isotope-item {
        display: none;
    }
    
    @media (max-width: 768px) {
        .heading-title {
            font-size: 2rem;
        }
        
        .doctor-actions {
            flex-direction: column;
        }
        
        .directory-filters {
            justify-content: center;
        }
        
        .single-profile {
            padding: 20px;
        }
        
        .profile-media img {
            height: 300px;
        }
    }
</style>
@endpush