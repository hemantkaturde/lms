<!DOCTYPE html>
<html lang="en">
<?php $pageUrl =$this->uri->segment(1);?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="<?php echo base_url(); ?>assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="<?php echo base_url(); ?>assets/css/main.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/DataTables/datatables.min.css" rel="stylesheet" />

    <link href="<?php echo base_url(); ?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
    <!-- PAGE LEVEL STYLES-->
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    <style>
        .modal-header
        {
            padding: 10px 36px;
            color:#fff;
        }
        /* thead
        {
            background:#374f65;color:#fff;
        } */
        .table td{
            padding: 0.3rem 0.75rem;
        }
    </style>
</head>

<body class="fixed-navbar">

    <!-- ========================================================= -->
<!-- Modal Large -->
    <div class="modal fade" id="popup_modal_lg" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title modal-title-lg" id="myLargeModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modal-body-lg"></div>
        </div>
      </div>
    </div>
   
    <!-- modal small -->
    <div class="modal fade" id="popup_modal_sm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="smexampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h5 class="modal-title modal-title-sm" id="smexampleModalLabel" style="font-weight: 600"></h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body modal-body-sm"></div>
          <!-- <div class="modal-footer modal-footer-sm"></div> -->
        </div>
      </div>
    </div>
    <!-- /Modal End -->
<!-- ========================================================= -->

    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand" style="place-content:center;">
                <a class="link" href="#">
                    <!-- <span class="brand">Admin
                        <span class="brand-tip">CAST</span>
                    </span>
                    <span class="brand-mini">AC</span> -->
                    <span class="brand">
                        <span class="brand-tip">LMS</span>
                    </span>
                    <span class="brand-mini">LMS</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>
                        <form class="navbar-search" action="javascript:;">
                            <div class="rel">
                                <span class="search-icon"><i class="ti-search"></i></span>
                                <input class="form-control" placeholder="Search here...">
                            </div>
                        </form>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                   <!--  <li class="dropdown dropdown-inbox">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i>
                            <span class="badge badge-primary envelope-badge">9</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong>9 New</strong> Messages</span>
                                    <a class="pull-right" href="mailbox.html">view all</a>
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <img src="<?php echo base_url(); ?>assets/img/users/u1.jpg" />
                                            </div>
                                            <div class="media-body">
                                                <div class="font-strong"> </div>Jeanne Gonzalez<small class="text-muted float-right">Just now</small>
                                                <div class="font-13">Your proposal interested me.</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <img src="<?php echo base_url(); ?>assets/img/users/u2.jpg" />
                                            </div>
                                            <div class="media-body">
                                                <div class="font-strong"></div>Becky Brooks<small class="text-muted float-right">18 mins</small>
                                                <div class="font-13">Lorem Ipsum is simply.</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <img src="<?php echo base_url(); ?>assets/img/users/u3.jpg" />
                                            </div>
                                            <div class="media-body">
                                                <div class="font-strong"></div>Frank Cruz<small class="text-muted float-right">18 mins</small>
                                                <div class="font-13">Lorem Ipsum is simply.</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <img src="<?php echo base_url(); ?>assets/img/users/u4.jpg" />
                                            </div>
                                            <div class="media-body">
                                                <div class="font-strong"></div>Rose Pearson<small class="text-muted float-right">3 hrs</small>
                                                <div class="font-13">Lorem Ipsum is simply.</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o rel"><span class="notify-signal"></span></i></a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong>5 New</strong> Notifications</span>
                                    <a class="pull-right" href="javascript:;">view all</a>
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-13">4 task compiled</div><small class="text-muted">22 mins</small></div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <span class="badge badge-default badge-big"><i class="fa fa-shopping-basket"></i></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-13">You have 12 new orders</div><small class="text-muted">40 mins</small></div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <span class="badge badge-danger badge-big"><i class="fa fa-bolt"></i></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-13">Server #7 rebooted</div><small class="text-muted">2 hrs</small></div>
                                        </div>
                                    </a>
                                    <a class="list-group-item">
                                        <div class="media">
                                            <div class="media-img">
                                                <span class="badge badge-success badge-big"><i class="fa fa-user"></i></span>
                                            </div>
                                            <div class="media-body">
                                                <div class="font-13">New user registered</div><small class="text-muted">2 hrs</small></div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li> -->
                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" />
                            <span></span><?php echo $role_text; ?><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:;"><i class="fa fa-user"></i>Profile</a>
                            <a class="dropdown-item" href="javascript:;"><i class="fa fa-cog"></i>Settings</a>
                            <a class="dropdown-item" href="javascript:;"><i class="fa fa-support"></i>Support</a>
                            <li class="dropdown-divider"></li>
                            <a class="dropdown-item" href="<?php echo base_url(); ?>logout"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
        <nav class="page-sidebar" id="sidebar">
            <div id="sidebar-collapse">
                <div class="admin-block d-flex">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" width="45px" />
                    </div>
                    <div class="admin-info">
                        <div class="font-strong"> <?php echo $name; ?></div><small><?php echo $role_text; ?></small></div>
                </div>
                <ul class="side-menu metismenu">
                    <li class="heading">DASHBOARD</li>
                    <li>
                        <a class="active" href="<?php echo base_url()."dashboard"; ?>"><i class="sidebar-item-icon fa fa-th-large"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <!--  -->
                    <!-- <li class="heading">COURSE</li> -->
                    <li>
                        <a href="<?php echo base_url()."courseListing"; ?>"><i class="sidebar-item-icon fa fa-book"></i>
                            <span class="nav-label">Courses</span>
                        </a>
                    </li>
                    <!--  -->
                    <!-- <li class="heading">STUDENTS</li> -->
                    <li>
                        <a href="<?php echo base_url()."studentListing"; ?>"><i class="sidebar-item-icon fa fa-users"></i>
                            <span class="nav-label">Student</span>
                        </a>
                    </li>
                     <!--  -->
                     <li class="treeview" style="height: auto;">
                        <a href="#">
                            <i class="sidebar-item-icon fa fa-cog"></i> <span>Settings</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu" >
                          <li><a href="#"><i class="sidebar-item-icon fa fa-envelope-open"></i> Email SMTP</a></li>
                          <li><a href="#"><i class="sidebar-item-icon fa fa-check-square-o"></i> Email Template</a></li>
                        </ul>
                    </li>
                    <!--  -->
                    <li class="treeview" style="height: auto;">
                        <a href="#">
                            <i class="sidebar-item-icon fa fa-user"></i> <span>User</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu" >
                          <li><a href="<?php echo base_url(); ?>userListing"  ><i class="sidebar-item-icon fa fa-user"></i> Users</a></li>
                          <li><a href="<?php echo base_url(); ?>roleListing" ><i class="sidebar-item-icon fa fa-check-square-o"></i> Role</a></li>
                        </ul>
                    </li>
                    <!--  -->
                
                </ul>
            </div>
        </nav>
        <!-- END SIDEBAR-->