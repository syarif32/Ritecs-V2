@extends('layouts.main')

@section('content')

    <div class="header-carousel owl-carousel">
        @forelse ($carousels as $carousel)
            <div class="header-carousel-item bg-primary">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-7 animated fadeInLeft">
                                <div class="text-sm-center text-md-start">
                                    <h4 class="text-white text-uppercase fw-bold mb-4">{{ $carousel->pre_title }}</h4>
                                    <!--<h6 class="text-white fw-bold mb-4">Terdaftar pada Kementrian Hukum dan Hak Asasi Manusia Republik Indonesia <br>Nomor AHU-0009449.AH.01.07.TAHUN 2023</h6>-->
                                    @if($carousel->subtitle)
                            <h6 class="text-white fw-bold mb-4">{!! nl2br(e($carousel->subtitle)) !!}</h6>
                            @endif
                                    <h1 class="display-1 text-white mb-4">{{ $carousel->title }}</h1>
                                    <p class="mb-5 fs-5">{{ $carousel->description }}</p>
                                    <div class="d-flex justify-content-center justify-content-md-start flex-shrink-0 mb-4">
                                        @if($carousel->button1_text && $carousel->button1_url)
                                            <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="{{ $carousel->button1_url }}"><i class="fas fa-play-circle me-2"></i>{{ $carousel->button1_text }}</a>
                                        @endif
                                        @if($carousel->button2_text && $carousel->button2_url)
                                            <a class="btn btn-dark rounded-pill py-3 px-4 px-md-5 ms-2" href="{{ $carousel->button2_url }}">{{ $carousel->button2_text }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 animated fadeInRight">
                                <div class="calrousel-img" style="object-fit: cover;">
                                    <img src="{{ asset('storage/' . $carousel->image_path) }}" class="img-fluid w-100" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="header-carousel-item bg-primary">
                <div class="carousel-caption">
                    <p>Data carousel belum diatur.</p>
                </div>
            </div>
        @endforelse
    </div>
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
    <div class="container-fluid blog py-5" id="blog">
        <div class="container py-5 text-center">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h1 class="display-4 mb-4">News And Updates</h1>
                <p class="mb-0">Dapatkan informasi terbaru seputar penerbitan buku dan jurnal, rilis terbaru, serta aktivitas RITECS.</p>
            </div>
           <div class="row g-4 justify-content-center text-start">
                @forelse ($journals as $journal)
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="blog-item rounded">
                        <div class="blog-img rounded-top">
                            <img src="{{ asset($journal->cover_path) }}" class="img-fluid rounded-top w-100" alt="{{ $journal->title }}">
                        </div>
                        <div class="blog-content h-100 rounded p-3 d-grid align-content-between">
                            <a href="{{ $journal->url_path }}" target="_blank" class="h6 d-inline-block mb-2">{{ Str::limit($journal->title, 55) }}</a>
                            <a href="{{ $journal->url_path }}" target="_blank" class="p-0 text-dark small">Detail jurnal<i class="fa fa-arrow-right ms-2 small"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-muted fs-5">Jurnal tidak ditemukan.</p>
                @endforelse
            </div>
        </div>
    </div>
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
     <!-- Team Start -->
    <!-- <div class="container-fluid team pb-5 pt-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Our Team</h4>
                <h1 class="display-4 mb-4">Meet Our Expert Team Members</h1>
                <p class="mb-0">
                    Kami memiliki tim ahli yang berdedikasi untuk memberikan layanan terbaik dalam penerbitan buku dan
                    jurnal. Setiap anggota tim kami memiliki keahlian khusus yang mendukung visi dan misi RITECS.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="team-item">
                        <div class="team-img">
                            <img src="assets/img/team-1.jpg" class="img-fluid rounded-top w-100" alt="">
                            <div class="team-icon">
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                        class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                        class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                        class="fab fa-instagram"></i></a>
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
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-twitter"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-2" href=""><i
                                        class="fab fa-linkedin-in"></i></a>
                                <a class="btn btn-primary btn-sm-square rounded-pill mb-0" href=""><i
                                        class="fab fa-instagram"></i></a>
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

    <!-- Testimonial Start -->
    <!-- <div class="container-fluid testimonial pb-5 mt-5">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h4 class="text-primary wow fadeInUp" data-wow-delay="0.2s">Testimonial</h4>
                <h1 class="display-5 mb-4 wow fadeInUp" data-wow-delay="0.4s">What Our Customers Are Saying</h1>
                <p class="mb-0 wow fadeInUp" data-wow-delay="0.6s">
                    Kami bangga telah membantu banyak penulis dan akademisi dalam menerbitkan karya mereka. Berikut adalah
                    beberapa testimoni dari klien kami yang puas dengan layanan RITECS.
                </p>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
                <div class="testimonial-item bg-light rounded">
                    <div class="row g-0">
                        <div class="col-4  col-lg-4 col-xl-3">
                            <div class="h-100">
                                <img src="assets/img/testimonial-1.jpg" class="img-fluid h-100 rounded"
                                    style="object-fit: cover;" alt="">
                            </div>
                        </div>
                        <div class="col-8 col-lg-8 col-xl-9">
                            <div class="d-flex flex-column my-auto text-start p-4">
                                <h4 class="text-dark mb-0">Client Name</h4>
                                <p class="mb-3">Profession</p>
                                <div class="d-flex text-primary mb-3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <p class="mb-0">
                                    "Pelayanan RITECS sangat profesional dan responsif. Proses penerbitan buku saya berjalan
                                    lancar, mulai dari penyuntingan hingga terbit ber-ISBN. Sangat direkomendasikan untuk
                                    penulis pemula maupun profesional!"
                                </p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-light rounded">
                    <div class="row g-0">
                        <div class="col-4  col-lg-4 col-xl-3">
                            <div class="h-100">
                                <img src="assets/img/testimonial-2.jpg" class="img-fluid h-100 rounded"
                                    style="object-fit: cover;" alt="">
                            </div>
                        </div>
                        <div class="col-8 col-lg-8 col-xl-9">
                            <div class="d-flex flex-column my-auto text-start p-4">
                                <h4 class="text-dark mb-0">Client Name</h4>
                                <p class="mb-3">Profession</p>
                                <div class="d-flex text-primary mb-3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-body"></i>
                                </div>
                                <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim error
                                    molestiae aut modi corrupti fugit eaque rem nulla incidunt temporibus quisquam,
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-light rounded">
                    <div class="row g-0">
                        <div class="col-4  col-lg-4 col-xl-3">
                            <div class="h-100">
                                <img src="assets/img/testimonial-3.jpg" class="img-fluid h-100 rounded"
                                    style="object-fit: cover;" alt="">
                            </div>
                        </div>
                        <div class="col-8 col-lg-8 col-xl-9">
                            <div class="d-flex flex-column my-auto text-start p-4">
                                <h4 class="text-dark mb-0">Client Name</h4>
                                <p class="mb-3">Profession</p>
                                <div class="d-flex text-primary mb-3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star text-body"></i>
                                    <i class="fas fa-star text-body"></i>
                                </div>
                                <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim error
                                    molestiae aut modi corrupti fugit eaque rem nulla incidunt temporibus quisquam,
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Testimonial End -->
     <!-- pop up start -->
      <!-- <div class="modal fade" id="ojsPopupModal" tabindex="-1" aria-labelledby="ojsPopupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ojsPopupModalLabel">Informasi Publikasi Jurnal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>
                    Temukan riset terbaru dan publikasi ilmiah berkualitas di Open Journal System (OJS) kami. Kami berkomitmen untuk menyebarkan pengetahuan dan inovasi di bidang Computer Science.
                </p>
                <p class="mb-0">
                    Kunjungi sekarang untuk mengakses artikel-artikel terbaru!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('journal') }}" class="btn btn-primary rounded-pill {{ in_array($title ?? '', ['Jurnal', 'Detail Jurnal']) ? 'active' : '' }}">Jurnal Kami</a>
            </div>
        </div>
    </div>
</div> -->

    <!-- pop up end -->
   @if (session('status'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('status') }}",
            confirmButtonColor: '#3085d6'
        });
    });
</script>
@endif


    @endsection