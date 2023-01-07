<?php

$roleId = '';
$role = '';
$discription = '';
$access='';

if(!empty($roleInfo))
{
    foreach ($roleInfo as $rf)
    {
        $roleId = $rf->roleId;
        $role = $rf->role;
        $role_type = $rf->role_type;
        $discription = $rf->discription;
        $access = $rf->access; 
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Changes/Modify Access</div>
            </div>
            <div class="ibox-body">
                   <?php
                        $attributes = array("name"=>"role_form","id"=>"role_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                        
                    ?>
                <form role="form" id="role_form">
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                            <div class="col-md-4">
                                <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Changes/Modify Access</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Page Access</label>
                                        <input type="text" class="form-control" id="role" name="role" value="<?php echo $role; ?>"
                                            maxlength="255">
                                        <input type="hidden" name="roleId" id="roleId" value="<?php echo $roleId ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Page Access Type</label><br/>
                                                <div class="form-check form-check-inline mr-5 ml-5">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypesystem" value="system" <?php if($role_type=='system'){ echo 'checked';}?>>
                                                    System
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypecompany" value="student" <?php if($role_type=='student'){ echo 'checked';}?>>
                                                    Student
                                                </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Page Access Description</label>
                                        <textarea type="text" class="form-control" id="discription" value="<?php echo $discription; ?>" name="discription"><?php echo $discription; ?></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                            </div>  
                            <div class="col-md-8">
                                 <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Assign Page Access</h3>
                        </div>
                        <div class="box-body">
                             <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                                <th scope="col">Module Name</th>
                                                <th scope="col">Module</th>
                                                <th scope="col">Page Access</th>
                                                <th scope="col">Add Access</th>
                                                <th scope="col">Changes/Modify Access</th>
                                                <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                    
                                            <td style="color:#a83131"><b>Home Page</b></td>
                                            <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule" <?php if(in_array("homepagemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    </tr> -->
                               
                                    <tbody>
                                            <tr>
                                                <td style="color:#a83131"><b>Dashboard</b></td>
                                                <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule" <?php if(in_array("homepagemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Masters</b></td>
                                                <td><input type="checkbox" id="mastermodule" name="checkbox[]" value="mastermodule" <?php if(in_array("mastermodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp Certificate Type</td>
                                                <td><input type="checkbox" id="coursetypemodule" name="checkbox[]" value="coursetypemodule" <?php if(in_array("coursetypemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursetypepage" name="checkbox[]" value="coursetypepage" <?php if(in_array("coursetypepage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursetypeadd" name="checkbox[]" value="coursetypeadd" <?php if(in_array("coursetypeadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursetypedit" name="checkbox[]" value="coursetypedit" <?php if(in_array("coursetypedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursetypedelete" name="checkbox[]" value="coursetypedelete" <?php if(in_array("coursetypedelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Course</b></td>
                                                <td><input type="checkbox" id="coursepagemodule" name="checkbox[]" value="coursepagemodule" <?php if(in_array("coursepagemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursepage" name="checkbox[]" value="coursepage" <?php if(in_array("coursepage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="courseadd" name="checkbox[]" value="courseadd" <?php if(in_array("courseadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="coursedit" name="checkbox[]" value="coursedit" <?php if(in_array("coursedit", json_decode($access))){ echo 'checked'; } ?> ></td>
                                                <td><input type="checkbox" id="coursedelete" name="checkbox[]" value="coursedelete" <?php if(in_array("coursedelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Enquiry / Leads</b></td>
                                                <td><input type="checkbox" id="enquirymodule" name="checkbox[]" value="enquirymodule" <?php if(in_array("enquirymodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="enquirypage" name="checkbox[]" value="enquirypage" <?php if(in_array("enquirypage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="enquiryadd" name="checkbox[]" value="enquiryadd" <?php if(in_array("enquiryadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="enquiryedit" name="checkbox[]" value="enquiryedit" <?php if(in_array("enquiryedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="enquirydelete" name="checkbox[]" value="enquirydelete" <?php if(in_array("enquirydelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Admission</b></td>
                                                <td><input type="checkbox" id="admissionmodule" name="checkbox[]" value="admissionmodule" <?php if(in_array("admissionmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="admissionpage" name="checkbox[]" value="admissionpage" <?php if(in_array("admissionpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="admissionadd" name="checkbox[]" value="admissionadd" <?php if(in_array("admissionadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="admissionedit" name="checkbox[]" value="admissionedit" <?php if(in_array("admissionedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="admissiondelete" name="checkbox[]" value="admissiondelete" <?php if(in_array("admissiondelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>


                                            <tr>
                                                <td style="color:#a83131"><b>Examination</b></td>
                                                <td><input type="checkbox" id="examinationmodule" name="checkbox[]" value="examinationmodule" <?php if(in_array("examinationmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="examinationpage" name="checkbox[]" value="examinationpage" <?php if(in_array("examinationpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="examinationadd" name="checkbox[]" value="examinationadd" <?php if(in_array("examinationadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="examinationedit" name="checkbox[]" value="examinationedit" <?php if(in_array("examinationedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="examinationdelete" name="checkbox[]" value="examinationdelete" <?php if(in_array("examinationdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>



                                            <tr>
                                                <td style="color:#a83131"><b>Certificate</b></td>
                                                <td><input type="checkbox" id="certificatemodule" name="checkbox[]" value="certificatemodule" <?php if(in_array("certificatemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="certificatepage" name="checkbox[]" value="certificatepage" <?php if(in_array("certificatepage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="certificateadd" name="checkbox[]" value="certificateadd" <?php if(in_array("certificateadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="certificateedit" name="checkbox[]" value="certificateedit" <?php if(in_array("certificateedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="certificatedelete" name="checkbox[]" value="certificatedelete" <?php if(in_array("certificatedelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>


                                            <tr>
                                                <td style="color:#a83131"><b>Tax Invoice</b></td>
                                                <td><input type="checkbox" id="taxinvoicemodule" name="checkbox[]" value="taxinvoicemodule" <?php if(in_array("taxinvoicemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>


                                            <tr>
                                                <td style="color:#a83131"><b>Staff / Counseller</b></td>
                                                <td><input type="checkbox" id="staffcounsellermodule" name="checkbox[]" value="staffcounsellermodule" <?php if(in_array("staffcounsellermodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="staffcounsellerpage" name="checkbox[]" value="staffcounsellerpage" <?php if(in_array("staffcounsellerpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="staffcounselleradd" name="checkbox[]" value="staffcounselleradd" <?php if(in_array("staffcounselleradd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="staffcounselleredit" name="checkbox[]" value="staffcounselleredit" <?php if(in_array("staffcounselleredit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="staffcounsellerdelete" name="checkbox[]" value="staffcounsellerdelete" <?php if(in_array("staffcounsellerdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Students</b></td>
                                                <td><input type="checkbox" id="studentmodule" name="checkbox[]" value="studentmodule" <?php if(in_array("studentmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="studentpage" name="checkbox[]" value="studentpage" <?php if(in_array("studentpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="studentadd" name="checkbox[]" value="studentadd" <?php if(in_array("studentadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="studentedit" name="checkbox[]" value="studentedit" <?php if(in_array("studentedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="tudentdelete" name="checkbox[]" value="tudentdelete" <?php if(in_array("tudentdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>
                                        
                                            <tr>
                                                <td style="color:#a83131"><b>Users</b></td>
                                                <td><input type="checkbox" id="usersmodule" name="checkbox[]" value="usersmodule" <?php if(in_array("usersmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp User</td>
                                                <td></td>
                                                <td><input type="checkbox" id="userpage" name="checkbox[]" value="userpage" <?php if(in_array("userpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="useradd" name="checkbox[]" value="useradd" <?php if(in_array("useradd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="useredit" name="checkbox[]" value="useredit" <?php if(in_array("useredit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="userdelete" name="checkbox[]" value="userdelete" <?php if(in_array("userdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp Roles</td>
                                                <td></td>
                                                <td><input type="checkbox" id="rolepage" name="checkbox[]" value="rolepage" <?php if(in_array("rolepage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="roleadd" name="checkbox[]" value="roleadd" <?php if(in_array("roleadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="roleedit" name="checkbox[]" value="roleedit" <?php if(in_array("roleedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="roledelete" name="checkbox[]" value="roledelete" <?php if(in_array("roledelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr>

                                            <!-- <tr>
                                                <td style="color:#a83131"><b>Settings</b></td>
                                                <td><input type="checkbox" id="settingsmodule" name="checkbox[]" value="settingsmodule" <?php if(in_array("settingsmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp EMAIL SMTP</td>
                                                <td></td>
                                                <td><input type="checkbox" id="emilsmtppage" name="checkbox[]" value="emilsmtppage" <?php if(in_array("emilsmtppage", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="emilsmtpadd" name="checkbox[]" value="emilsmtpadd" <?php if(in_array("emilsmtpadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="emilsmtpedit" name="checkbox[]" value="emilsmtpedit" <?php if(in_array("emilsmtpedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                                <td><input type="checkbox" id="emilsmtpdelete" name="checkbox[]" value="emilsmtpdelete" <?php if(in_array("emilsmtpdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                            </tr> -->

                                        </tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!-- ENTER BUTTON HERE -->
                                    <input type="button" id="editRole" class="btn btn-primary" value="UPDATE" />
                                    <!-- <input type="button" onclick="location.href='<?php echo base_url().'roleListing'?>'" class="btn btn-default" value="BACK" /> -->
                                    <input type="button" onclick="location.href='<?php echo base_url().'roleListing'?>'" class="btn btn-default" value="CANCEL" />
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
