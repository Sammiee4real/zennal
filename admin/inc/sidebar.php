<!--Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #022b69 !important;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index">
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
        <a class="nav-link" href="index">
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
            <!-- <h6 class="collapse-header">View</h6> -->
            <a class="collapse-item" href="view_personal_details">Users' Details</a>
             <!-- <div class="collapse-divider"></div>
            <h6 class="collapse-header">User Access</h6>
            <a class="collapse-item" href="disable_user">Disable User</a> -->
            <!-- <a class="collapse-item" href="register.html">Terminate User</a> -->
          </div>
        </div>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Audit Trail</span>
        </a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Modules
      </div>


        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#loans" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Loans</span>
        </a>
        <div id="loans" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            
            <a class="collapse-item" href="view_loan_packages">Loan Packages</a>
           
            <a class="collapse-item" href="running_loan">Running Loans</a>
            <a class="collapse-item" href="running_installment">Running Installment Loans</a>
           
            <a class="collapse-item" href="personal_loan_application_requests">Personal Loan Requests</a>
           
          </div>
      </li>


          <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#insurance" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Insurance</span>
        </a>
        <div id="insurance" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            <a class="collapse-item" href="view_insurance">Insurance Bought</a>
            
            <a class="collapse-item" href="view_insurance_plans">Insurance Plans</a>
         
            <a class="collapse-item" href="view_insurance_pricing">Insurance Pricing Plans</a>
          

          </div>
      </li>


          <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#vehicle_reg" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Vehicle Registration</span>
        </a>
        <div id="vehicle_reg" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            
          
            <a class="collapse-item" href="vehicle_reg_request">Registration Requests</a>
            <a class="collapse-item" href="manage_number_plate">Manage Number Plates</a>
            <a class="collapse-item" href="manage_coupon_code">Manage Coupon Codes</a>
            <a class="collapse-item" href="manage_vehicle_particular">Manage Vehicle Particulars</a>
            <a class="collapse-item" href="manage_services">Manage Services</a>
          </div>
      </li>


          <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#referrals" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Referrals</span>
        </a>
        <div id="referrals" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            <a class="collapse-item" href="#">All Referrals</a>
            
          </div>
      </li>


          <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#activities" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Activities</span>
        </a>
        <div id="activities" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            <a class="collapse-item" href="#">All Activities</a>
            
          </div>
      </li>


          <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#privilege" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Privileges</span>
        </a>
        <div id="privilege" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!-- <h6 class="collapse-header">View</h6> -->
           <!--  <a class="collapse-item" href="view_loan_applications">View Loan Applications</a> -->
            <!-- <a class="collapse-item" href="view_repayment">View Repayments</a> -->
            <a class="collapse-item" href="#">All Roles</a>
            <a class="collapse-item" href="#">Manage Roles</a>
      
          </div>
      </li>


      <!-- Nav Item - Pages Collapse Menu -->
     
     

      <!-- Divider -->
      <hr class="sidebar-divider">


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#documents" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Documents</span>
        </a>
        <div id="documents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="#">Upload Document</a>
            <a class="collapse-item" href="#">All Documents</a>
          </div>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#auths" aria-expanded="true" aria-controls="manage_system">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Auths</span>
        </a>
        <div id="auths" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="change_password">Change Password</a>
            <a class="collapse-item" href="logout">Logout</a>
          </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar