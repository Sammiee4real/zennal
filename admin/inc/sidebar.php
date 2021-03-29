<!--Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #022b69 !important;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div> -->
        <img src="../assets/images/logozennal.png" class="img-fluid">
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Users
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_user" aria-expanded="true" aria-controls="manage_user">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Manage User</span>
        </a>
        <div id="manage_user" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View</h6>
            <a class="collapse-item" href="view_personal_details.php">View Users Details</a>
             <!-- <div class="collapse-divider"></div>
            <h6 class="collapse-header">User Access</h6>
            <a class="collapse-item" href="disable_user.php">Disable User</a> -->
            <!-- <a class="collapse-item" href="register.html">Terminate User</a> -->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Audit Trail</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        System
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_system" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Manage System</span>
        </a>
        <div id="manage_system" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View</h6>
           <!--  <a class="collapse-item" href="view_loan_applications.php">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment.php">View Repayments</a> -->
            <a class="collapse-item" href="view_insurance.php">View Insurance Bought</a>
            <a class="collapse-item" href="view_loan_packages.php">View Loan Packages</a>
            <a class="collapse-item" href="view_insurance_plans.php">View Insurance Plans</a>
            <a class="collapse-item" href="view_insurance_pricing.php">View Insurance Pricing Plans</a>
            <a class="collapse-item" href="personal_loan_application_requests.php">Personal Loan Requests</a>
            <a class="collapse-item" href="withdrawal_requests.php">Withdrawal Requests</a>
          </div>
      </li>
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#system_settings" aria-expanded="true" aria-controls="system_settings">
          <i class="fas fa-fw fa-wrench"></i>
          <span>System Setting</span>
        </a>
        <div id="system_settings" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Loan Setting</h6>
            <a class="collapse-item" href="set_loan_package.php">Add Loan Packages</a>
            <a class="collapse-item" href="add_product.php">Add Products</a>
            <a class="collapse-item" href="add_vendor.php">Add Vendors</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Insurance Setting</h6>
            <a class="collapse-item" href="add_insurer.php">Add Insurer</a>
            <a class="collapse-item" href="set_insurance_packages.php">Add Insurance Package</a>
            <a class="collapse-item" href="set_pricing_plan.php">Add Insurance Pricing Plan</a>
            <a class="collapse-item" href="add_insurance_category.php">Add Insurance Category</a>
            <a class="collapse-item" href="add_insurance_benefit.php">Add Insurance Benefit</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Document Management
      </div>
      <li class="nav-item">
        <a class="nav-link" href="upload_document.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Upload Document</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="view_documents.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>View Documents</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-table"></i>
          <span>Manage Admin Rights</span></a>
      </li>

       <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="change_password.php">
          <i class="fas fa-fw fa-table"></i>
          <span>Change Password</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar