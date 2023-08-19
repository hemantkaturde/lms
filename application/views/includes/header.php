<!DOCTYPE html>
<html lang="en">
<?php 
$pageUrl =$this->uri->segment(1);
$access = $this->session->userdata('access');
$roleText = $this->session->userdata('roleText');

$jsonstringtoArray = json_decode($access, true);
?>
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
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css"rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    <script type="text/javascript">
    var baseURL = "<?php echo base_url(); ?>";
    </script>
    <style>
    .modal-header {
        padding: 10px 36px;
        color: #fff;
    }
    .table td {
        padding: 0.3rem 0.75rem;
    }
    </style>
</head>

<body class="fixed-navbar">

    <!-- ========================================================= -->
    <!-- Modal Large -->
    <div class="modal fade" id="popup_modal_lg" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
    <div class="modal fade" id="popup_modal_sm" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
        aria-labelledby="smexampleModalLabel" aria-hidden="true">
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
            <div class="page-brand" style="place-content:center;background-color: #ca9331;">
                <a class="link" href="#">
                    
                    
                    <span class="brand">
                        <span class="brand-tip">
                            <img src="<?php echo base_url('assets/img/logos/iictn_lms.png'); ?>" alt="" height="50">
                        </span>
                    </span>

                    <span class="brand">IICTN
                        <!-- <span class="brand-tip">CAST</span> -->
                    </span>
                    <span class="brand-mini">IICTN</span>
                    <!-- <span class="brand-mini">LMS</span> -->
                </a>
            </div>
            <div class="flexbox flex-1" style="background: #d2ae6d;">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li>
                        <!-- <form class="navbar-search" action="javascript:;">
                            <div class="rel">
                                <span class="search-icon"><i class="ti-search"></i></span>
                                <input class="form-control" placeholder="Search here...">
                            </div>
                        </form> -->
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
                    </li>-->


                    <?php if($roleText=='Student'){ 
                        
                        $CI =& get_instance();
                        $CI->load->model('student_model');
                        $userId = $this->session->userdata('userId');
                        $result = $CI->student_model->getstudentexaminListationdata($userId);   
                     ?>

                    <li class="dropdown dropdown-notification">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell rel" style="font-size: x-large;"><span class="notify-signal" style="height: 21px !important;width: 20px !important;top: -12px !important;right: -10px !important;"> <p style='font-size: small;margin-left: 7px;color: #fff;margin-top: 3px'><?=count($result); ?></p></span></i></a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong>  New Examination Notification </strong></span>
                                    <a class="pull-right"  href="<?php echo base_url();?>studentexaminationlist">view all</a>
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>
                                    <?php  foreach ($result as $key => $value) { ?>
                                        <a class="list-group-item"  href="<?php echo base_url().'studentexamination/'.$value['courseId'];?>">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13"><?= $value['course_name']?> </div><small class="text-muted"><?= $value['exam_title']?></small></div>
                                                </div>
                                        </a>
                                     <?php }  ?>
                                </div>
                            </li>
                        </ul>
                    </li> 
                    <?php } ?>




                    <?php if($roleText=='Trainer'){ 
                        
                        $CI =& get_instance();
                        $CI->load->model('student_model');
                        $userId = $this->session->userdata('userId');
                        $result_trainer = $CI->student_model->getallstudentquerydatfornotification($userId,$roleText);

                      
                     ?>

                    <li class="dropdown dropdown-notification">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell rel" style="font-size: x-large;"><span class="notify-signal" style="height: 21px !important;width: 20px !important;top: -12px !important;right: -10px !important;"> <p style='font-size: small;margin-left: 7px;color: #fff;margin-top: 3px'><?=count($result_trainer); ?></p></span></i></a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-media">
                            <li class="dropdown-menu-header">
                                <div>
                                    <span><strong> Ask A Query  </strong></span>
                                    <a class="pull-right"  href="<?php echo base_url();?>askqquery">view all</a>
                                </div>
                            </li>
                            <li class="list-group list-group-divider scroller" data-height="240px" data-color="#71808f">
                                <div>
                                    <?php  foreach ($result_trainer as $key => $value) { ?>
                                        <a class="list-group-item"  href="<?php echo base_url().'askqquery';?>">
                                            <div class="media">
                                                <div class="media-img">
                                                    <span class="badge badge-success badge-big"><i class="fa fa-check"></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <div class="font-13"><?= $value['name']?> </div><small class="text-muted"><?= $value['query']?></small></div>
                                                </div>
                                        </a>
                                     <?php }  ?>
                                </div>
                            </li>
                        </ul>
                    </li> 
                    <?php } ?>

                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <?php
                            
                            if($role_text!="Student"){ 
                                if(!empty($this->session->userdata('profile_pic'))){ ?>
                                     <img  src="<?php echo IMGPATH.'/'.$this->session->userdata('profile_pic');?>" />
                               <?php  }else{ ?>
                                    <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" />
                              <?php }

                            }else{
                                if(!empty($this->session->userdata('profile_pic'))){ ?>
                                    <img  src="<?php echo IMGPATH_ADMISSION.'/'.$this->session->userdata('profile_pic');?>" />
                              <?php  }else{ ?>
                                <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" />
                           <?php  } }?>
                            
                            <span></span><?php echo $role_text; ?><i class="fa fa-angle-down m-l-5"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="<?php echo base_url()."profilesetting"; ?>"><i class="fa fa-user"></i>Profile Setting</a>
                            <!-- <a class="dropdown-item" href=""><i class="fa fa-cog"></i>Settings</a>
                            <a class="dropdown-item" href="javascript:;"><i class="fa fa-support"></i>Support</a> -->
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
        <nav class="page-sidebar" id="sidebar" style="background-color: #d2ae6d; position: fixed;">
            <div id="sidebar-collapse" >
                <div class="admin-block d-flex">
                    <div>
                       <?php
                       
                       if($role_text!="Student"){  
                            if(!empty($this->session->userdata('profile_pic'))){ ?>
                                    <img  src="<?php echo IMGPATH.'/'.$this->session->userdata('profile_pic');?>" width="50px"  height="50px"/>
                          <?php  } else{ ?>
                                     <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" />
                          <?php } }else{ 
                            if(!empty($this->session->userdata('profile_pic'))){ ?>
                          <img  src="<?php echo IMGPATH_ADMISSION.'/'.$this->session->userdata('profile_pic');?>" width="50px"  height="50px"/>
                          <?php  }else{ ?>
                            <img src="<?php echo base_url(); ?>assets/img/admin-avatar.png" width="50px" height="50px" />
                        <?php }} ?>
                    
                    </div>
                    <div class="admin-info" >
                        <div class="font-strong"> <?php echo $name; ?></div><small ><?php echo $role_text; ?></small>
                    </div>
                </div>

                <?php if($role_text!="Student"){ ?>
                    <ul class="side-menu metismenu" >
                        <!-- <li class="heading" >DASHBOARD</li> -->

                        <?php if (in_array("homepagemodule", $jsonstringtoArray)){?>
                        <li  class="<?php if($pageUrl =='dashboard'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."dashboard"; ?>"><i
                                    class="sidebar-item-icon fa fa-th-large"></i>
                                <span class="nav-label" >Dashboard</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (in_array("enquirymodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='enquirylisting' || $pageUrl =='editenquiry' || $pageUrl =='followup' || $pageUrl=='payment_details'){ echo 'active';} ?>">
                            <a href="<?php echo base_url()."enquirylisting"; ?>"><i class="sidebar-item-icon fa fa-address-book" ></i>
                                <span class="nav-label">Inquiry / Leads</span>
                            </a>
                        </li>
                        <?php } ?>

                        <?php if (in_array("taxinvoicemodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='taxinvoices'){ echo 'active';} ?>">
                            <a href="<?php echo base_url().'taxinvoices'; ?>"><i class="sidebar-item-icon fa fa-inr" ></i>
                                <span class="nav-label">Tax Invoices</span>
                            </a>
                        </li>
                        <?php } ?>

                        
                        <?php if (in_array("admissionmodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='admissionListing' || $pageUrl =='viewadmissiondetails' || $pageUrl=="editadmission"){ echo 'active';} ?>">
                            <a href="<?php echo base_url().'admissionListing'; ?>"><i class="sidebar-item-icon fa fa-graduation-cap" ></i>
                                <span class="nav-label">Admission</span>
                            </a>
                        </li>
                        <?php } ?>


                        <?php if (in_array("attendancemodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='attendance'){ echo 'active';} ?>">
                            <a href="<?php echo base_url().'attendance'; ?>"><i class="sidebar-item-icon fa fa-calendar-check-o" ></i>
                                <span class="nav-label">Attendance</span>
                            </a>
                        </li>
                        <?php } ?>

                        
                        <?php if (in_array("examinationmodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='examinationlisting' || $pageUrl =='viewquestionpaper'){ echo 'active';} ?>">
                            <a href="<?php echo base_url().'examinationlisting'; ?>"><i class="sidebar-item-icon fa fa fa-pencil" ></i>
                                <span class="nav-label">Examination</span>
                            </a>
                        </li>
                        <?php } ?>

                        
                        <?php if (in_array("checkexamresultmodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='examcheckingList' || $pageUrl=='checkanswersheet' || $pageUrl=='addmarkstoexam'){ echo 'active';} ?>">
                            <a href="<?php echo base_url().'examcheckingList'; ?>"><i class="sidebar-item-icon fa fa-check-square-o" ></i>
                                <span class="nav-label">Check Exam / Results</span>
                            </a>
                        </li>
                        <?php } ?>


                        <?php if (in_array("certificatemodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='crtificateListing'){ echo 'active';} ?>">
                            <a href="<?php echo base_url()."crtificateListing"; ?>"><i class="sidebar-item-icon fa fa-file-text" ></i>
                                <span class="nav-label">Certificates</span>
                            </a>
                        </li>
                        <?php } ?>
                        
                        
                        <?php if (in_array("studentmodule", $jsonstringtoArray)){?>
                        <li>
                            <li class="<?php if($pageUrl =='studentListing' || $pageUrl =='editstudent' || $pageUrl =='studentbookissued'){ echo 'active';} ?>">
                                <a href="<?php echo base_url()."studentListing"; ?>" ><i class="sidebar-item-icon fa fa-users"></i>
                                    <span class="nav-label">Student Portal</span>
                                </a>
                            </li>
                        </li>
                        <?php } ?>

                        <?php if (in_array("usersmodule", $jsonstringtoArray)){?>
                        <li class="treeview <?php if($pageUrl =='userListing' || $pageUrl =='roleListing' || $pageUrl =='addRole' || $pageUrl =='editRole'){ echo 'active';} ?>"  style="height: auto; " >
                            <a href="#">
                                <i class="sidebar-item-icon fa fa-user" ></i> <span class="group-master" >Staff User</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                            <?php if (in_array("userpage", $jsonstringtoArray)){?>
                                <li class="<?php if($pageUrl =='userListing'){ echo 'active';} ?>"><a href="<?php echo base_url(); ?>userListing"><i class="sidebar-item-icon fa fa-user"></i><span class="nav-label"> Users </span></a></li>
                            <?php } ?>
                            <?php if (in_array("rolepage", $jsonstringtoArray)){?>
                                <li class="<?php if($pageUrl =='roleListing' || $pageUrl =='addRole' || $pageUrl =='editRole'){ echo 'active';} ?>"><a href="<?php echo base_url(); ?>roleListing"><i class="sidebar-item-icon fa fa-check-square-o"></i><span class="nav-label"> Page Access </span></a></li>
                            <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        
                       
                        <?php if (in_array("coursepagemodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='courselisting' || $pageUrl =='addchapters' || $pageUrl =='addcourseListing' ||  $pageUrl =='topicattachmentListing' || $pageUrl=="viewalltopicdocuments" || $pageUrl=="timetableListing" || $pageUrl=="viewtimetablelisting" || $pageUrl=="addtopiclinksforonlineattendant"){ echo 'active';} ?>">
                            <a href="<?php echo base_url()."courselisting"; ?>"><i class="sidebar-item-icon fa fa-book" ></i>
                                <span class="nav-label">Courses</span>
                            </a>
                        </li>
                        <?php } ?>






                        <!-- <?php if (in_array("mastermodule", $jsonstringtoArray)){?>
                        <li class="treeview <?php if($pageUrl =='coursetypelisting'){ echo 'active';} ?>" style="height: auto; " >
                            <a href="#">
                                <i class="sidebar-item-icon fa fa-th-list" ></i> <span class="group-master">Masters</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <?php if (in_array("coursetypemodule", $jsonstringtoArray)){?>
                            <ul class="treeview-menu">
                                <li class="<?php if($pageUrl =='coursetypelisting'){ echo 'active';} ?>">
                                    <a href="<?php echo base_url()."coursetypelisting"; ?>"><i class="sidebar-item-icon fa fa-file" ></i>
                                        <span class="nav-label" >Certificate Type</span>
                                    </a>
                                </li>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?> -->


                        <?php if (in_array("mastermodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='coursetypelisting'){ echo 'active';} ?>">
                            <a href="<?php echo base_url()."coursetypelisting"; ?>"><i class="sidebar-item-icon fa fa-book" ></i>
                                <span class="nav-label">Certification Type</span>
                            </a>
                        </li>
                        <?php } ?>



                        <?php if (in_array("studentreportmodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='studentreport'){ echo 'active';} ?>">
                            <a href="<?php echo base_url()."studentreport"; ?>"><i class="sidebar-item-icon fa fa-file-excel-o" ></i>
                                <span class="nav-label">Student Report</span>
                            </a>
                        </li>
                        <?php } ?>

              
                        <!-- <?php if (in_array("staffcounsellermodule", $jsonstringtoArray)){?>
                        <li class="<?php if($pageUrl =='staffListing'){ echo 'active';} ?>">
                            <a href="<?php echo base_url(); ?>staffListing"><i class="sidebar-item-icon fa fa-user" ></i>
                                <span class="nav-label">Staff / counsellor</span>
                            </a>
                        </li>
                        
                        <?php } ?> -->
                        <!-- <li>
                            <a href="#"><i class="sidebar-item-icon fa fa-phone-square" ></i>
                                <span class="nav-label">Follow up</span>
                            </a>
                        </li> -->

                        <!-- <?php if (in_array("settingsmodule", $jsonstringtoArray)){?>
                        <li class="treeview <?php if($pageUrl =='emailsmtpListing'){ echo 'active';} ?>" style="height: auto;">
                            <a href="#">
                                <i class="sidebar-item-icon fa fa-cog" ></i> <span class="group-master">Settings</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right" ></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (in_array("emilsmtppage", $jsonstringtoArray)){?>
                                <li class="<?php if($pageUrl =='emailsmtpListing'){ echo 'active';} ?>"><a href="<?php echo base_url()."emailsmtpListing"; ?>"><i class="sidebar-item-icon fa fa-envelope-open"></i><span class="nav-label"> Email SMTP </span></a></li>
                                <?php } ?>
                                <li><a href="<?php echo base_url()."emailtemplateListing"; ?>"><i  class="sidebar-item-icon fa fa-check-square-o"></i> Email Template</a></li>
                            </ul>
                        </li>
                        <?php } ?> -->


                        <?php if($role_text=="Trainer"){ ?>
                        <li  class="<?php if($pageUrl =='askqquery' || $pageUrl=="viewqueryanswer" ){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."askqquery"; ?>"><i
                                    class="sidebar-item-icon fa fa-question-circle"></i>
                                <span class="nav-label">Ask A Query</span>
                            </a>
                        </li>
                        <?php } ?>

                    </ul>
                <?php }else{ ?>
                    <ul class="side-menu metismenu" >

                        <li  class="<?php if($pageUrl =='dashboard'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."dashboard"; ?>"><i
                                    class="sidebar-item-icon fa fa-th-large"></i>
                                <span class="nav-label" >Dashboard</span>
                            </a>
                        </li>

                        <li  class="<?php if($pageUrl =='studentadmissions' || $pageUrl =='studentpaymentdetails'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."studentadmissions"; ?>"><i
                                    class="sidebar-item-icon fa fa-address-book"></i>
                                <span class="nav-label" >Admission / Inquiry</span>
                            </a>
                        </li>

                        <li  class="<?php if($pageUrl =='studentcourses' ||  $pageUrl =='viewstudentscoursetopis' || $pageUrl =='studenttopicdocumentslisting' || $pageUrl =='studentviewalltopicdocuments' || $pageUrl =='studenttimetableListing' || $pageUrl =='studentviewtimetablelisting' || $pageUrl =='addstudenttopiclinksforonlineattendant'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."studentcourses"; ?>"><i
                                    class="sidebar-item-icon fa fa-file"></i>
                                <span class="nav-label" >My Courses</span>
                            </a>
                        </li>

                        <li  class="<?php if($pageUrl =='studentattendance'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."studentattendance"; ?>"><i
                                    class="sidebar-item-icon fa fa-calendar-check-o"></i>
                                <span class="nav-label" >Attendance</span>
                            </a>
                        </li>

                        <li  class="<?php if($pageUrl =='studentexamination' || $pageUrl =='attendexamination' || $pageUrl =='start_exam' || $pageUrl =='showexamstatus' || $pageUrl =='studentexaminationlist'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."studentexaminationlist"; ?>"><i
                                    class="sidebar-item-icon fa fa-graduation-cap"></i>
                                <span class="nav-label" >Examination</span>
                            </a>
                        </li>


                        <li  class="<?php if($pageUrl =='studentcrtificateListing'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."studentcrtificateListing"; ?>"><i
                                    class="sidebar-item-icon fa fa-file-text"></i>
                                <span class="nav-label" >Certifications</span>
                            </a>
                        </li>

                        <li  class="<?php if($pageUrl =='billinginfo'){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."billinginfo"; ?>"><i
                                    class="sidebar-item-icon fa fa-inr"></i>
                                <span class="nav-label">Tax Invoices</span>
                            </a>
                        </li>  
                        
                     
                        <li  class="<?php if($pageUrl =='askqquery' || $pageUrl=="viewqueryanswer"){ echo 'active';} ?>">
                            <a  href="<?php echo base_url()."askqquery"; ?>"><i
                                    class="sidebar-item-icon fa fa-question-circle"></i>
                                <span class="nav-label">Ask A Query</span>
                            </a>
                        </li>
                    </ul>
               <?php } ?>
            </div>
        </nav>
        <!-- END SIDEBAR-->

    <div class="loader_ajax" style="display:none;">
	    <div class="loader_ajax_inner"><img src="<?php echo ICONPATH;?>/preloader_ajax.gif"></div>
	</div>

    <style>
        .loader_ajax {background-color: #242424;bottom: 0;height: 100%;left: 0;opacity: 0.9;position: fixed;top: 0;width: 100%;z-index: 999;}
        .loader_ajax_inner {background: transparent url("<?php echo ICONPATH;?>/bg.png") no-repeat scroll center center;height: 44px;left: 50%;margin: -22px 0 0 -22px;position: absolute;top: 50%;width: 44px;}
        .loader_ajax img {margin: 9px 0 0 8px;width: 28px;}
    </style>

<!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
$(function() {
    $(this).bind("contextmenu", function(e) {
        e.preventDefault();
    });
}); 
</script>
<script type="text/JavaScript"> 
    function killCopy(e){ return false } 
    function reEnable(){ return true } 
    document.onselectstart=new Function ("return false"); 
    if (window.sidebar)
    { 
        document.onmousedown=killCopy; 
        document.onclick=reEnable; 
    } 
</script> -->