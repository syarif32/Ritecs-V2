<?php $__env->startSection('content'); ?>

<div class="container-fluid feature bg-light pb-0 pt-3">
    <div class="container mt-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h3 class="display-6 fw-bold mb-4">RITECS Journal Awarding</h3>
        </div>
        <div class="col-lg-10 col-xl-8 mx-auto wow fadeInUp" data-wow-delay="0.3s">
            <p class="text-muted text-center p-0 m-0">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptas unde necessitatibus accusantium dolorem tempore inventore explicabo sequi omnis placeat ut reiciendis fugit asperiores nam.</p>
            <p class="p-0 m-0 text-center"><a class="text-center" href="https://ritecs.org/journal/">Kunjungi Ritecs OJS: klik disini!</a></p>
        </div>
    </div>

    <div class="container-fluid blog p-0 m-0 pb-0 py-5 bg-light"id="idJournal">
        <div class="container p-0 m-0 w-100 m-auto">
            
            <?php if($selected): ?>
            <div class="card mb-3 h-100 border-0 shadow-none m-auto p-2 ps-4 pb-4 mb-5 position-relative" style="max-width: 1100px;">
                <div class="position-absolute bg-warning px-3 py-1 rounded" style="margin-left: -1.5rem !important; margin-top: -.5rem !important;">
                    <h4 class="display-6 fst-italic text-white p-0 m-0">#<?php echo e($selected->awarding_id); ?></h4>
                </div>
                <div class="row g-0 m-auto">
                    <div class="col-12 col-md-4 col-xl-3 pt-lg-2 pt-3">
                        <div class="blog-img rounded shadow">
                            <img id="selected-cover" src="<?php echo e(asset($selected->cover_path ?? 'assets/published/awarding/award_default.png')); ?>" 
                                class="img-fluid w-100 object-fit-contain rounded-start rounded-end" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-xl-9">
                        <div class="card-body ps-md-4 ps-lg-5 ps-2 pt-lg-3 pt-4">
                            <h3 class="d-inline-block mb-3"id="selected-title"><?php echo e($selected->title); ?></h3>

                            <div class="row">
                                <div class="col-12 col-lg-6 my-1">
                                    <div class="d-flex">
                                        <span class="text-dark bi bi-pen"></span>
                                        <div class="d-flex">
                                            <span class="ms-2">
                                                <span class="text-dark">Penulis:</span> 
                                                <span id="selected-penulis"><?php echo e($selected->penulis ?? '-'); ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 my-1">
                                    <div class="d-flex">
                                        <span class="text-dark bi bi-collection"></span>
                                        <div class="d-flex">
                                            <span class="ms-2">
                                                <span class="text-dark" >Volume:</span> 
                                                <span id="selected-volume"><?php echo e($selected->volume_no ?? '-'); ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 my-1">
                                    <div class="d-flex">
                                        <span class="text-dark bi bi-journal-text"></span>
                                        <div class="d-flex">
                                            <span class="ms-2">
                                                <span class="text-dark">Jenis Jurnal:</span>
                                                <span id="selected-jenis"><?php echo e($selected->jenis_jurnal ?? '-'); ?></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 my-1">
                                    <div class="d-flex">
                                        <span class="text-dark bi bi-link-45deg"></span>
                                        <div class="d-flex">
                                            <span class="ms-2">
                                                <span class="text-dark" >URL:</span> 
                                                <?php if($selected->url_path): ?>
                                                    <a href="<?php echo e($selected->url_path); ?>" target="_blank" id="selected-url"><?php echo e($selected->url_path); ?></a>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 my-1">
                                    <div class="d-flex">
                                        <span class="text-dark bi bi-tags"></span>
                                        <div class="d-flex align-items-center">
                                            <span class="ms-2">
                                                <span class="text-dark">Keywords:</span>
                                                <span id="selected-keywords">
                                                    <?php if($selected->keywords && $selected->keywords->count() > 0): ?>
                                                        <?php $__currentLoopData = $selected->keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span><?php echo e($key->name); ?><?php if(!$loop->last): ?>, <?php endif; ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12 my-2">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item p-0 border-0">
                                            <h2 class="accordion-header p-0 border-0">
                                                <button class="accordion-button bg-transparent text-dark p-0 py-2 rounded-0 outline-0 border-bottom-1 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Abstract
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show p-0 border-0" data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0 border-0 pt-1" id="selected-abstract">
                                                    <?php echo e($selected->abstract ?? '-'); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>


        </div>

        <div class="container-fluid bg-white p-5">
            <div class="container py-5">

                <div class="mb-5 text-start mt-4">
                    <h4 class="text-primary mb-0">Daftar Jurnal</h4>
                    <h3 class="display-6">Peraih Awarding</h3>
                </div>   

                <div class="row g-4 justify-content-start text-start">
                    <?php $__currentLoopData = $awardings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="blog-item rounded">
                            <div class="blog-img rounded-top">
                                <img src="<?php echo e(asset($award->cover_path ?? 'assets/published/awarding/award_default.png')); ?>" class="img-fluid rounded-top w-100" alt="">
                            </div>
                            <div class="blog-content h-100 rounded p-3 d-grid align-content-between">
                                <div class="card-body p-0 m-0">
                                    <a href="javascript:void(0)#idJournal" onclick="loadAwarding(<?php echo e($award->awarding_id); ?>)" 
                                    class="h6 d-inline-block mb-2"><?php echo e($award->title); ?></a>
                                    <div class="kata-kunci my-1">
                                        <p class="h6 small mb-0">Kata Kunci :</p>
                                        <?php $__currentLoopData = $award->keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="keywords-badge py-0 small my-1 ms-0 me-1"><?php echo e($keyword->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                
                                <a href="javascript:void(0)" onclick="loadAwarding(<?php echo e($award->awarding_id); ?>)" class="d-flex align-items-center p-0 text-dark">
                                <span class="small">Lihat Detail</span>
                                <i class="text-dark bi bi-arrow-up-short fw-bold h5 ms-1 p-0 m-0"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid feature bg-light py-5">
    <div class="container py-4">
        <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.7s">
            <div class="text-start wow fadeInUp" data-wow-delay="0.1s">
                <h3 class="display-6 fw-bold mb-4">RITECS Open Journal System</h3>
            </div>
            <p class="text-muted text-start p-0 m-0">
                Portal penerbitan jurnal ilmiah RITECS yang memfasilitasi publikasi penelitian dari berbagai disiplin ilmu dengan sistem akses terbuka, proses peninjauan sejawat yang ketat, dan kualitas terjamin</p>
            <p class="p-0 m-0 text-start"><a class="text-start" href="https://ritecs.org/journal/">Kunjungi Ritecs OJS: klik disini!</a></p>
        </div>
    </div>

    <div class="container blog py-3">
        <div class="row">
            <div class="col-lg-8">
                <div class="container ps-0">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <div class="text-muted">Menampilkan <?php echo e($journals->firstItem() ?? 0); ?>-<?php echo e($journals->lastItem() ?? 0); ?> dari <?php echo e($journals->total()); ?> hasil</div>
                        <div class="d-flex align-items-center">
                            <label for="sortBy" class="form-label me-2 mb-0 small text-muted">Urutkan:</label>
                            
                            <select class="form-select form-select-sm" id="sortBy" name="sort" style="width: auto;">
                                <option value="newest" <?php echo e(request('sort', 'newest') == 'newest' ? 'selected' : ''); ?>>Terbaru</option>
                                <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Terlama</option>
                                <option value="title_asc" <?php echo e(request('sort') == 'title_asc' ? 'selected' : ''); ?>>A-Z</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 justify-content-start text-start">
                            
                        <?php $__empty_1 = true; $__currentLoopData = $journals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $journal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-6 col-xxl-4 wow fadeInUp" data-wow-delay="0.6s">
                            <div class="blog-item rounded">
                                <div class="blog-img rounded-top">
                                    <img src="<?php echo e(asset($journal->cover_path)); ?>" class="img-fluid rounded-top w-100" alt="<?php echo e($journal->title); ?>">
                                </div>
                                <div class="blog-content h-100 rounded p-3 d-grid align-content-between">
                                    <div class="card-body p-0 m-0">
                                        <a href="<?php echo e($journal->url_path); ?>" target="_blank" class="h6 d-inline-block mb-2"><?php echo e(Str::limit($journal->title, 55)); ?></a>
                                        <?php if($journal->keywords->isNotEmpty()): ?>
                                        <div class="kata-kunci my-1">
                                            <p class="h6 small mb-0 ">Kata Kunci : </p>
                                            <?php $__currentLoopData = $journal->keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="keywords-badge py-0 small my-1 ms-0 me-1"><?php echo e($keyword->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?php echo e($journal->url_path); ?>" target="_blank" class="p-d-flex align-items-center  text-dark position-relative bottom-0"><span class="small">Detail jurnal</span><i class="text-dark bi bi-arrow-up-short fw-bold h5 ms-1 p-0 m-0"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12 text-center">
                            <p class="text-muted fs-5">Jurnal tidak ditemukan.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-5">
                        <?php echo e($journals->links()); ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="card-title mb-3 h5">Filter Kata Kunci</p>
                            <div class="list-group list-group-flush subject-list">
                                <a href="<?php echo e(route('journal', ['search' => request('search'), 'sort' => request('sort')])); ?>"
                                    class="list-group-item list-group-item-action py-1 my-1 small <?php echo e(!request('keyword') ? 'active' : ''); ?>">
                                    <i class="fas fa-star me-2"></i> Semua Kata Kunci
                                </a>
                                <?php $__currentLoopData = $keywords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('journal', ['keyword' => $keyword->name, 'search' => request('search'), 'sort' => request('sort')])); ?>"
                                    class="list-group-item list-group-item-action py-1 my-1 small <?php echo e(request('keyword') == $keyword->name ? 'active' : ''); ?>">
                                    <?php echo e($keyword->name); ?>

                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Base path ke folder assets (pakai Blade supaya otomatis sesuai env hosting)
const assetBase = `<?php echo e(asset('')); ?>`;

function loadAwarding(id) {
    fetch(`<?php echo e(url('/awardings')); ?>/${id}`) 
        .then(res => res.json())
        .then(data => {
            // Update cover dengan base asset path
            document.getElementById('selected-cover').src = data.cover_path 
                ? assetBase + data.cover_path 
                : assetBase + 'assets/published/awarding/award_default.png';

            // Update title
            document.getElementById('selected-title').innerText = data.title ?? '-';

            // Update penulis
            document.getElementById('selected-penulis').innerText = data.penulis ?? '-';

            // Update volume
            document.getElementById('selected-volume').innerText = data.volume_no ?? '-';

            // Update jenis jurnal
            document.getElementById('selected-jenis').innerText = data.jenis_jurnal ?? '-';

            // Update url
            let urlElement = document.getElementById('selected-url');
            if (data.url_path) {
                urlElement.innerHTML = `<a href="${data.url_path}" target="_blank">${data.url_path}</a>`;
            } else {
                urlElement.innerHTML = '-';
            }

            // Update keywords
            let keywordElement = document.getElementById('selected-keywords');
            if (data.keywords && data.keywords.length > 0) {
                keywordElement.innerHTML = data.keywords.map((k, i) => 
                    `${k.name}${i < data.keywords.length - 1 ? ', ' : ''}`
                ).join('');
            } else {
                keywordElement.innerText = '-';
            }

            // Update abstract
            document.getElementById('selected-abstract').innerText = data.abstract ?? '-';

            // Scroll ke atas
            document.getElementById('idJournal').scrollIntoView({ behavior: 'smooth' });
        })
        .catch(err => console.error(err));
}

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u604135968/domains/ritecs.org/config/resources/views/pages/awarding.blade.php ENDPATH**/ ?>