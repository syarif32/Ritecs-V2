
@extends('layouts.main')

@section('content')


        <!-- Header Start -->
        <div class="container-fluid bg-breadcrumb">
            <div class="container text-center py-5" style="max-width: 900px;">
                <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">About Us</h4>
                <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active text-primary">About</li>
                </ol>    
            </div>
        </div>
        <!-- Header End -->


        <!-- About Start -->
        <div class="container-fluid bg-light about pb-5 pt-5">
        <div class="container pb-5">
            <div class="row g-5">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                   <div class="about-item-content bg-white rounded p-5 h-100">
                        <h4 class="text-primary">Tentang Kami</h4>
                        <h1 class="display-4 mb-4">VISI & MISI</h1>
                        {!! $vision !!}
                        {!! $mission !!}
                        <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('about') }}">More Information</a>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-white rounded p-5 h-100">
                            <div class="row g-4 justify-content-center">
                                <div class="col-12">

                                <div class="rounded bg-light">

                                    @php

                                        $imageUrl = ($faq_image && Storage::disk('public')->exists($faq_image))
                                            ? asset('storage/' . $faq_image)
                                            : asset('assets/img/tim.png'); 
                                    @endphp
                                    <img src="{{ $imageUrl }}" class="img-fluid rounded w-100" alt="Tentang Kami">
                                </div>
                            </div>
                               <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up">{{ $membershipCount }}</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Membership</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up">{{ $bookCount }}</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Buku</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up">{{ $journalCount }}</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Jurnal</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter-item bg-light rounded p-3 h-100">
                                    <div class="counter-counting">
                                        <span class="text-primary fs-2 fw-bold"
                                            data-toggle="counter-up">{{ $teamCount }}</span>
                                        <span class="h1 fw-bold text-primary">+</span>
                                    </div>
                                    <h4 class="mb-0 text-dark">Team Members</h4>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
             
            </div>
        </div>
    </div>
        <!-- About End -->


        <!-- Feature Start -->
        <div class="container-fluid feature bg-light py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Layanan Kami</h4>
                    <h1 class="display-4 mb-4">Apa yang Kami Tawarkan</h1>
                    <p class="mb-0">Kami menyediakan berbagai layanan penerbitan buku dan jurnal, mulai dari penyuntingan, tata letak, desain grafis, hingga penerbitan ber-ISBN. Tim kami siap membantu Anda mewujudkan karya ilmiah dan kreatif Anda.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-book-open fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Penerbitan Buku</h4>
                            <p class="mb-4">Kami menyediakan layanan penerbitan buku lengkap, mulai dari penyuntingan, tata letak, desain grafis, hingga penerbitan ber-ISBN
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4 {{ ($title ?? '') === 'Petunjuk Penulis' ? 'active' : '' }}" href="{{ route('petunjuk-penulis') }}#petunjuk-penulis">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-newspaper fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Penerbitan Jurnal</h4>
                            <p class="mb-4"> Kami menyediakan layanan penerbitan jurnal ilmiah yang profesional, mulai dari proses penyuntingan, tata letak, hingga pendaftaran ISSN. 
    Tim kami siap membantu penulis dan peneliti dalam mempublikasikan hasil karya ilmiahnya agar dapat diakses secara luas dan diakui secara akademik.
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ route('layanan-journal') }}#layanan-jurnal">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Membership</h4>
                            <p class="mb-4">
                                Bergabunglah dengan komunitas kami untuk mendapatkan akses ke berbagai layanan dan sumber daya penerbitan. Dapatkan keuntungan eksklusif sebagai anggota.
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4 {{ ($title ?? '') === 'Membership' ? 'active' : '' }}" href="{{ route('membership') }}#petunjuk-penulis">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Pusat Pelatihan</h4>
                            <p class="mb-4">
                                Tingkatkan keterampilan dan pengetahuan Anda melalui program pelatihan, workshop, dan seminar interaktif yang dirancang oleh instruktur berpengalaman.
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4 {{ ($title ?? '') === 'Membership' ? 'active' : '' }}" href="{{ route('training-center') }}#training">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.8s">
                <div class="feature-item h-100 p-4 pt-0">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-copyright fa-3x"></i>
                    </div>
                    <h4 class="mb-4">Layanan HAKI</h4>
                    <p class="mb-4">
                        Lindungi karya dan inovasi Anda. Kami menyediakan layanan pendampingan lengkap untuk pendaftaran Hak Atas Kekayaan Intelektual.
                    </p>
                    <a class="btn btn-primary rounded-pill py-2 px-4 {{ ($title ?? '') === 'Layanan HAKI' ? 'active' : '' }}" href="{{ route('layanan-haki') }}">Learn More</a>
                </div>
            </div>
                    <!-- <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-th-large fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Tata Letak Halaman</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea hic laborum odit
                                pariatur...
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Learn More</a>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="1s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-drafting-compass fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Design Grafis Ilustrasi</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea hic laborum odit
                                pariatur...
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Learn More</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeInUp" data-wow-delay="1.2s">
                        <div class="feature-item h-100 p-4 pt-0">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-language fa-3x"></i>
                            </div>
                            <h4 class="mb-4">Translate&Proofreading</h4>
                            <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea hic laborum odit
                                pariatur...
                            </p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Learn More</a>
                        </div>
                    </div> -->
                </div>
            
            </div>
        </div>
        <!-- Feature End -->

        <!-- FAQs Start -->
         <div class="container-fluid faq-section bg-light py-5">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-xl-6 wow fadeInLeft" data-wow-delay="0.2s">
                    <div class="h-100">
                        <div class="mb-5">
                            <h4 class="text-primary">Some Important FAQ's</h4>
                            <h1 class="display-5 mb-0">Pertanyaan umum tentang layanan dan penerbitan di RITECS.</h1>
                        </div>
                        <div class="accordion" id="accordionExample">
                            @forelse($home_faqs as $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                        <button class="accordion-button border-0 {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                            Q: {{ $faq->question }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionExample">
                                        <div class="accordion-body rounded">A: {{ $faq->answer }}</div>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada FAQ.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 wow fadeInRight" data-wow-delay="0.4s">
                    <img src="{{ asset('storage/' . $faq_image) }}" class="img-fluid w-100" alt="">
                </div>
            </div>
        </div>
    </div>
        <!-- FAQs End -->


        <!-- Team Start -->
        <!-- <div class="container-fluid team py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Our Team</h4>
                    <h1 class="display-4 mb-4">Meet Our Expert Team Members</h1>
                    <p class="mb-0">Tim RITECS terdiri dari profesional berpengalaman di bidang penerbitan, desain, dan akademik, siap mendukung setiap langkah perjalanan publikasi Anda.
                    </p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="assets/img/team-1.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">David James</h4>
                                <p class="mb-0">Profession</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="assets/img/team-2.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">David James</h4>
                                <p class="mb-0">Profession</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="assets/img/team-3.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">David James</h4>
                                <p class="mb-0">Profession</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="team-item">
                            <div class="team-img">
                                <img src="assets/img/team-4.jpg" class="img-fluid rounded-top w-100" alt="">
                                <div class="team-icon">
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                            <div class="team-title p-4">
                                <h4 class="mb-0">David James</h4>
                                <p class="mb-0">Profession</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="container-fluid team pb-5 pt-5">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            
            <h4 class="text-primary">{{ $settings['team_pre_title'] ?? 'Our Team' }}</h4>
            <h1 class="display-4 mb-4">{{ $settings['team_title'] ?? 'Meet Our Expert Team Members' }}</h1>
            <p class="mb-0">
                {{ $settings['team_description'] ?? 'Tim kami terdiri dari para profesional yang berdedikasi.' }}
            </p>
        </div>

        <div class="row g-4">
            
            @forelse ($teams as $team)
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="{{ asset('storage/' . $team->img_path) }}" alt="{{ $team->name }}" class="img-fluid rounded-top w-100">
                            <div class="team-icon">
                                @if($team->facebook_url)
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="{{ $team->facebook_url }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if($team->twitter_url)
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="{{ $team->twitter_url }}" target="_blank"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if($team->linkedin_url)
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href="{{ $team->linkedin_url }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if($team->instagram_url)
                                    <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href="{{ $team->instagram_url }}" target="_blank"><i class="fab fa-instagram"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="team-title p-4">
                            <h4 class="mb-0">{{ $team->name }}</h4>
                            <p class="mb-0">{{ $team->position }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Data tim belum tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
        <!-- Team End -->
@endsection