<?php $__env->startSection('content'); ?>


<div class="container my-5">
        <div class="row g-4">

            <div class="col-lg-3">
                <div class="card p-3">
                    <nav class="nav flex-column sidebar-nav">
                        <a class="nav-link" href="<?php echo e(route('ircs-journal')); ?>"><i class="fas fa-arrow-left fa-fw"></i> Back</a>

                        <a class="nav-link active" href="ircs-journal#current-volume"><i class="fas fa-archive fa-fw"></i> Archive</a>
                    </nav>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="card p-4 p-md-5">

                    <div class="article-header">
                        <p class="text-primary fw-bold mb-2">Vol. 1, No. 1 (Agustus, 2025)</p>
                        <h1 class="article-title">Kombinasi Naive Bayes dan Chi-Square untuk Identifikasi SMS Penipuan</h1>
                        <p class="article-authors mb-2">Aditya Priadi Pradana, Arry Maulana Syarif, Ika Novita Dewi, Candra Irawan</p>
                        <p class="article-meta">Diterima: 11 Juli 2025; Direvisi: 19 Juli 2025; Disetujui: 23 Juli 2025; Diterbitkan: 1 Agustus 2025</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="article-section-title">Abstrak</h5>
                        <p class="abstract-text">
                            Ancaman kejahatan siber seperti SMS penipuan telah menjadi masalah serius yang berpotensi mengakibatkan kerugian finansial dan pencurian data pribadi. Penelitian ini bertujuan untuk merancang dan membangun sebuah sistem deteksi yang efektif guna mengklasifikasikan SMS penipuan secara akurat dengan memanfaatkan pendekatan machine learning (ML). Pendekatan yang digunakan adalah penerapan algoritma klasifikasi Naïve Bayes, sebuah metode probabilistik yang dikenal efisien untuk analisis teks. Proses penelitian diawali dengan pengumpulan dataset SMS yang relevan, diikuti oleh tahap pra-pemrosesan data yang komprehensif, mencakup case folding untuk menyeragamkan teks, normalisasi untuk standardisasi kata, stopwords removal untuk eliminasi kata-kata umum, serta stemming untuk mengubah kata ke bentuk dasarnya. Selanjutnya, fitur-fitur teks diekstraksi dan dibobot menggunakan metode Term Frequency-Inverse Document Frequency (TF-IDF), dan fitur yang paling signifikan diseleksi menggunakan Chi-Square untuk meningkatkan fokus model. Hasil pengujian dan evaluasi, yang didasarkan pada confusion matrix, menunjukkan performa model yang sangat baik, dengan keberhasilan mencapai tingkat akurasi sebesar 93%. Lebih lanjut, model ini juga menunjukkan keseimbangan yang kuat antara presisi (93%), recall (93%), dan F1-Score (93%). Capaian ini menegaskan bahwa model Naïve Bayes merupakan solusi yang andal dan valid untuk mengembangkan sistem perlindungan pengguna yang efektif terhadap ancaman SMS penipuan.
                        </p>
                    </div>
                    
                    <div class="mb-5">
                        <h5 class="article-section-title">Kata Kunci</h5>
                        <div>
                            <span class="keywords-badge">Naïve Bayes</span>
                            <span class="keywords-badge">TF-IDF</span>
                            <span class="keywords-badge">Chi-Square</span>
                            <span class="keywords-badge">Klasifikasi</span>
                            <span class="keywords-badge">SMS Penipuan</span>
                        </div>
                    </div>

                    <div class="d-flex flex-column flex-md-row gap-3 align-items-md-center">
                         <a href="#" class="btn btn-primary btn-download w-100 w-md-auto"><i class="fas fa-file-pdf me-2"></i> Full Article - PDF</a>
                    </div>
                    
                    <hr class="my-4">

                    <div>
                        <h5 class="article-section-title">Cara Mengutip</h5>
                        <div class="citation-box">
                           Pradana, A. P., Syarif, A. M., Dewi, I. N., & Irawan, C. (2025). Kombinasi naive bayes dan chi-square untuk identifikasi sms penipuan. IRCS: Integrative Research in Computer Science, 1(1), 1-22.
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/detail-jurnal.blade.php ENDPATH**/ ?>