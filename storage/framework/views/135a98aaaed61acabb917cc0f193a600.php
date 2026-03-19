<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
  <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
    <i class="fe fe-x"><span class="sr-only"></span></i>
  </a>
  <nav class="navbar navbar-light w-100">
    <!-- nav bar -->
    <div class="w-100 mb-4 d-flex">
      <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="<?php echo e(route('home')); ?>">
        <img src="<?php echo e(asset('assets/img/logo/logo-text.webp')); ?>" id="logo" class="navbar-brand-img brand-lg" alt="">
      </a>
    </div>


    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Web Performance</span>
    </p>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      
      <li class="nav-item <?php echo e(in_array($title ?? '', ['Dashboard', '']) ? 'active' : ''); ?> dropdown">
        <a href="#dashboard" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-trello fe-16"></i>
          <span class="ml-3 item-text">Dashboard</span><span class="sr-only">(current)</span>
        </a>

        <!-- properti "show" untuk open dropdown -->
        <ul class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Dashboard', '']) ? 'show' : ''); ?>"
          id="dashboard">
          <li class="nav-item">
            <a class="nav-link <?php echo e(($title ?? '') === 'Dashboard' ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.dashboard')); ?>"><span class="ml-1 item-text">Control</span></a>
          </li>
        </ul>

      </li>

      <li class="nav-item <?php echo e(($title ?? '') === 'Data Traffic' ? 'active' : ''); ?>">
        <a class="nav-link disabled" href="<?php echo e(route('admin.dashboard')); ?>" aria-disabled="true">
          <i class="fe fe-activity fe-16"></i>
          <span class="ml-3 item-text">Data Traffic</span>
        </a>
      </li>
      <li class="nav-item <?php echo e(($title ?? '') === 'Analytics' ? 'active' : ''); ?>">
        <a class="nav-link disabled" href="<?php echo e(route('admin.dashboard')); ?>" aria-disabled="true">
          <i class="fe fe-pie-chart fe-16"></i>
          <span class="ml-3 item-text">Analytics</span>
        </a>
      </li>
    </ul>

    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Financial Manager</span>
    </p>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item <?php echo e(in_array($title ?? '', ['Memberships', 'Verify Transaction', 'Bank Data', 'Add Bank', 'Edit Bank', 'Inactive Memberships']) ? 'active' : ''); ?> dropdown">
        <a href="#financial" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-command fe-16"></i>
          <span class="ml-3 item-text">Transactions</span>
        </a>

        <!-- properti "show" untuk open dropdown -->
        <ul class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Memberships', 'Verify Transaction', 'Bank Data', 'Add Bank', 'Edit Bank', 'Inactive Memberships']) ? 'show' : ''); ?>"
          id="financial">
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Memberships', 'Verify Transaction']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.memberships')); ?>"><span class="ml-1 item-text">Membership Payment</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Inactive Memberships']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.memberships.trashed')); ?>"><span class="ml-1 item-text">Payment Trahsed</span></a>
          </li>

        </ul>

      </li>

      <li class="nav-item <?php echo e(in_array($title ?? '', ['Bank Data', 'Add Bank', 'Edit Bank']) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.banks.index')); ?>" >
          <i class="fe fe-credit-card fe-16"></i>
          <span class="ml-3 item-text">Banks Data</span>
        </a>
      </li>

      <li class="nav-item d-none <?php echo e(($title ?? '') === 'Refunds' ? 'active' : ''); ?>">
        <a class="nav-link disabled" href="#" aria-disabled="true">
          <i class="fe fe-refresh-ccw fe-16"></i>
          <span class="ml-3 item-text">Refunds</span>
        </a>
      </li>

    </ul>


    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Web Data Manager</span>
    </p>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item <?php echo e(in_array($title ?? '', ['Users Data', 'Edit User', 'Add User', 'NonActive Users Data', 'User Membership Data', 'Add User Membership', 'Edit User Membership']) ? 'active' : ''); ?> dropdown">
        <a href="#usersData" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-users fe-16"></i>
          <span class="ml-3 item-text">Users Data</span>
        </a>

        <!-- properti "show" untuk open dropdown -->
        <ul class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Users Data', 'Edit User', 'Add User', 'NonActive Users Data', 'User Membership Data', 'Add User Membership', 'Edit User Membership']) ? 'show' : ''); ?>"
          id="usersData">
          <li class="nav-item">
            <a class="nav-link <?php echo e(($title ?? '') === 'Users Data' ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.users.index')); ?>"><span class="ml-1 item-text">All Users</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(($title ?? '') === 'NonActive Users Data' ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.users.nonactiveusers')); ?>"><span class="ml-1 item-text">Nonactive</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['User Membership Data', 'Add User Membership', 'Edit User Membership']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.manageUserMemberships.index')); ?>"><span class="ml-1 item-text">Membership</span></a>
          </li>
          
        </ul>

      </li>
      <li class="nav-item <?php echo e(in_array($title ?? '', ['Role Management', 'History Log']) ? 'active' : ''); ?> dropdown">
        <a href="#accessManager" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-shield fe-16"></i> 
          <span class="ml-3 item-text">Admin & Access</span>
        </a>

        <ul class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Role Management', 'History Log']) ? 'show' : ''); ?>"
          id="accessManager">
          
          
          <li class="nav-item">
            <a class="nav-link <?php echo e(($title ?? '') === 'Role Management' ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.usersmanagement.index')); ?>">
              <span class="ml-1 item-text">Manage Roles</span>
            </a>
          </li>

         
          <li class="nav-item">
            <a class="nav-link <?php echo e(($title ?? '') === 'History Log' ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.users.history')); ?>">
              <span class="ml-1 item-text">History Log</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li
        class="nav-item <?php echo e(in_array($title ?? '', ['Journal Data', 'Add Journal', 'Edit Journal', 'Book Data', 'Edit Book', 'Add Book']) ? 'active' : ''); ?> dropdown">
        <a href="#publish" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-file-text fe-16"></i>
          <span class="ml-3 item-text">Published</span>
        </a>

        
        <ul
          class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Journal Data', 'Add Journal', 'Edit Journal', 'Book Data', 'Edit Book', 'Add Book', 'Awarding Data', 'Add Awarding', 'Edit Awarding']) ? 'show' : ''); ?>"
          id="publish">
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Book Data', 'Add Book', 'Edit Book']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.published-books')); ?>"><span class="ml-1 item-text">Books</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Journal Data', 'Add Journal', 'Edit Journal']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.published-journals')); ?>"><span class="ml-1 item-text">Journals</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Awarding Data', 'Add Awarding', 'Edit Awarding']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.awardings.index')); ?>"><span class="ml-1 item-text">Awardings</span></a>
          </li>
          <li class="nav-item w-100">
    <a class="nav-link <?php echo e(Request::routeIs('admin.content-history') ? 'active' : ''); ?>" 
       href="<?php echo e(route('admin.content-history')); ?>">
       
        <i class="fe fe-activity fe-16"></i>
        <span class="ml-3 item-text">Riwayat Upload</span>
    </a>
</li>
        </ul>

      </li>
    </ul>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li
        class="nav-item <?php echo e(in_array($title ?? '', ['Keywords', 'Add Keywords', 'Edit Keywords', 'Categories', 'Add Category', 'Edit Category', 'Writers', 'Add Writer', 'Edit Writer']) ? 'active' : ''); ?> dropdown">
        <a href="#publishUtils" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle nav-link">
          <i class="fe fe-git-pull-request fe-16"></i>
          <span class="ml-3 item-text">Publish Utils</span>
        </a>

        <!-- properti "show" untuk open dropdown -->
        <ul
          class="collapse list-unstyled pl-4 w-100 <?php echo e(in_array($title ?? '', ['Keywords', 'Add Keywords', 'Edit Keywords', 'Categories', 'Add Category', 'Edit Category', 'Writers', 'Add Writer', 'Edit Writer']) ? 'show' : ''); ?>"
          id="publishUtils">
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Categories', 'Add Category', 'Edit Category']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.categories')); ?>"><span class="ml-1 item-text">Book Categories</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Writers', 'Add Writer', 'Edit Writer']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.writers')); ?>"><span class="ml-1 item-text">Book Writters</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo e(in_array($title ?? '', ['Keywords', 'Add Keywords', 'Edit Keywords']) ? 'active' : ''); ?> pl-3"
              href="<?php echo e(route('admin.keywords')); ?>"><span class="ml-1 item-text">Journal keywords</span></a>
          </li>
        </ul>

      </li>
    </ul>
    <p class="text-muted nav-heading mt-4 mb-1">
  <span>Comment Manager</span>
</p>
<ul class="navbar-nav flex-fill w-100 mb-2">
 <li class="nav-item <?php echo e((request()->is('admin/comments*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.comments.index')); ?>">
          <i class="fe fe-message-square fe-16"></i>
          <span class="ml-3 item-text">Komentar</span>
        </a>
      </li>
</ul>
<p class="text-muted nav-heading mt-4 mb-1">
  <span>Aktivasi User</span>
</p>
<ul class="navbar-nav flex-fill w-100 mb-2">
  
  <li class="nav-item <?php echo e((request()->is('admin/activation-requests*')) ? 'active' : ''); ?>">
    <a class="nav-link" href="<?php echo e(route('admin.activation.index')); ?>">
      <i class="fe fe-user-check fe-16"></i>
      <span class="ml-3 item-text">Request Aktivasi</span>
      
      
      
    </a>
  </li>
</ul>
    <p class="text-muted nav-heading mt-4 mb-1">
      <span>Frontend Manager</span>
    </p>

    <ul class="navbar-nav flex-fill w-100 mb-2">
      <li class="nav-item <?php echo e((request()->is('admin/page/home*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.home.index')); ?>">
          <i class="fe fe-home fe-16"></i>
          <span class="ml-3 item-text">Home</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/vision-mission*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.vision-mission.index')); ?>">
          <i class="fe fe-target fe-16"></i>
          <span class="ml-3 item-text">Visi & Misi</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/author-guideline*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.author-guideline.index')); ?>">
          <i class="fe fe-edit-3 fe-16"></i>
          <span class="ml-3 item-text">Layanan Buku</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/journal-service*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.journal-service.index')); ?>">
          <i class="fe fe-layout fe-16"></i>
          <span class="ml-3 item-text">Layanan Jurnal</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/membership*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.membership.index')); ?>">
          <i class="fe fe-user-check fe-16"></i>
          <span class="ml-3 item-text">Membership</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/contact*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.contact.index')); ?>">
          <i class="fe fe-mail fe-16"></i>
          <span class="ml-3 item-text">Contact</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/training*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.training.index')); ?>">
          <i class="fe fe-briefcase fe-16"></i>
          <span class="ml-3 item-text">Training Center</span>
        </a>
      </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/haki*')) ? 'active' : ''); ?>">
    <a class="nav-link" href="<?php echo e(route('admin.page.haki.index')); ?>">
        <i class="fe fe-shield fe-16"></i>
        <span class="ml-3 item-text">Layanan HAKI</span>
    </a>
</li>
<li class="nav-item <?php echo e((request()->is('admin/page/team*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.team.index')); ?>">
            <i class="fe fe-users fe-16"></i>
            <span class="ml-3 item-text">Kelola Tim</span>
        </a>
    </li>
      <li class="nav-item <?php echo e((request()->is('admin/page/footer*')) ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.page.footer.index')); ?>">
          <i class="fe fe-chevrons-down fe-16"></i>
          <span class="ml-3 item-text">Footer</span>
        </a>
      </li>
    </ul>
  <p class="text-muted nav-heading mt-4 mb-1">
  <span>System Tools Maintenance</span>
</p>

<ul class="navbar-nav flex-fill w-100 mb-2">
  <li class="nav-item <?php echo e((request()->is('admin/maintenance*')) ? 'active' : ''); ?>">
    <a class="nav-link" href="<?php echo e(route('admin.maintenance.index')); ?>">
      <i class="fe fe-settings fe-16"></i>
      <span class="ml-3 item-text">Maintenance</span>
    </a>
  </li>
</ul>

    <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-100">
      <?php echo csrf_field(); ?>
      <div class="btn-box w-100 mt-4 mb-1">
        <button type="submit" class="btn mb-2 btn-primary small btn-block w-100">
          <i class="fe fe-log-out fe-12 mx-2"></i><span class="small">Log Out</span>
        </button>
      </div>
    </form>

  </nav>
</aside><?php /**PATH C:\xampp\htdocs\Ritecs\resources\views/backend/partials/sidebar.blade.php ENDPATH**/ ?>