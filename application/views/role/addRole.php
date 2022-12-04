
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Add Role</div>
            </div>
            <div class="ibox-body">
                <form class="form-horizontal" id="role_form">
                    <div class="alert_msg"></div>
                    <?php
                        $attributes = array("name"=>"role_form","id"=>"role_form","class"=>"form-horizontal form-label-left", "enctype"=>"multipart/form-data"); 
                        echo form_open("", $attributes);
                        
                    ?>
                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Add Role</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <input type="text" class="form-control" id="role" name="role" placeholder="Eg. Manager" maxlength="255" required>
                                                <p class="error role_error"></p>

                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="discription">Role Type</label><br />
                                                <div class="form-check form-check-inline mr-5 ml-5">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypesystem" value="system" checked> System / Staff
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypecompany" value="student"> Student
                                                </div>
                                                <p class="error roletype_error"></p>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="discription">Role Description</label>
                                                <textarea type="text" class="form-control" id="discription" name="discription" placeholder="Enter Role Description"></textarea>
                                                <p class="error discription_error"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Assign Roles</h3>
                                </div>

                                <p class="error checkbox_error"></p>

                                <div class="box-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Module Name</th>
                                                <th scope="col">Module</th>
                                                <th scope="col">Page</th>
                                                <th scope="col">Add</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="color:#a83131"><b>Dashboard</b></td>
                                                <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Masters</b></td>
                                                <td><input type="checkbox" id="mastermodule" name="checkbox[]" value="mastermodule"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp Course Type</td>
                                                <td><input type="checkbox" id="coursetypemodule" name="checkbox[]" value="coursetypemodule"></td>
                                                <td><input type="checkbox" id="coursetypepage" name="checkbox[]" value="coursetypepage"></td>
                                                <td><input type="checkbox" id="coursetypeadd" name="checkbox[]" value="coursetypeadd"></td>
                                                <td><input type="checkbox" id="coursetypedit" name="checkbox[]" value="coursetypedit"></td>
                                                <td><input type="checkbox" id="coursetypedelete" name="checkbox[]" value="coursetypedelete"></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Course</b></td>
                                                <td><input type="checkbox" id="coursepagemodule" name="checkbox[]" value="coursepagemodule"></td>
                                                <td><input type="checkbox" id="coursepage" name="checkbox[]" value="coursepage"></td>
                                                <td><input type="checkbox" id="courseadd" name="checkbox[]" value="courseadd"></td>
                                                <td><input type="checkbox" id="coursedit" name="checkbox[]" value="coursedit"></td>
                                                <td><input type="checkbox" id="coursedelete" name="checkbox[]" value="coursedelete"></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Enquiry / Leads</b></td>
                                                <td><input type="checkbox" id="enquirymodule" name="checkbox[]" value="enquirymodule"></td>
                                                <td><input type="checkbox" id="enquirypage" name="checkbox[]" value="enquirypage"></td>
                                                <td><input type="checkbox" id="enquiryadd" name="checkbox[]" value="enquiryadd"></td>
                                                <td><input type="checkbox" id="enquiryedit" name="checkbox[]" value="enquiryedit"></td>
                                                <td><input type="checkbox" id="enquirydelete" name="checkbox[]" value="enquirydelete"></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Admission</b></td>
                                                <td><input type="checkbox" id="admissionmodule" name="checkbox[]" value="admissionmodule"></td>
                                                <td><input type="checkbox" id="admissionpage" name="checkbox[]" value="admissionpage"></td>
                                                <td><input type="checkbox" id="admissionadd" name="checkbox[]" value="admissionadd"></td>
                                                <td><input type="checkbox" id="admissionedit" name="checkbox[]" value="admissionedit"></td>
                                                <td><input type="checkbox" id="admissiondelete" name="checkbox[]" value="admissiondelete"></td>
                                            </tr>


                                            
                                            <tr>
                                                <td style="color:#a83131"><b>Examination</b></td>
                                                <td><input type="checkbox" id="examinationmodule" name="checkbox[]" value="examinationmodule"></td>
                                                <td><input type="checkbox" id="examinationpage" name="checkbox[]" value="examinationpage"></td>
                                                <td><input type="checkbox" id="examinationadd" name="checkbox[]" value="examinationadd"></td>
                                                <td><input type="checkbox" id="examinationedit" name="checkbox[]" value="examinationedit"></td>
                                                <td><input type="checkbox" id="examinationdelete" name="checkbox[]" value="examinationdelete"></td>
                                            </tr>



                                            <tr>
                                                <td style="color:#a83131"><b>Certificate</b></td>
                                                <td><input type="checkbox" id="certificatemodule" name="checkbox[]" value="certificatemodule"></td>
                                                <td><input type="checkbox" id="certificatepage" name="checkbox[]" value="certificatepage"></td>
                                                <td><input type="checkbox" id="certificateadd" name="checkbox[]" value="certificateadd"></td>
                                                <td><input type="checkbox" id="certificateedit" name="checkbox[]" value="certificateedit"></td>
                                                <td><input type="checkbox" id="certificatedelete" name="checkbox[]" value="certificatedelete"></td>
                                            </tr>


                                            <tr>
                                                <td style="color:#a83131"><b>Tax Invoice</b></td>
                                                <td><input type="checkbox" id="taxinvoicemodule" name="checkbox[]" value="taxinvoicemodule"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Staff / Counseller</b></td>
                                                <td><input type="checkbox" id="staffcounsellermodule" name="checkbox[]" value="staffcounsellermodule"></td>
                                                <td><input type="checkbox" id="staffcounsellerpage" name="checkbox[]" value="staffcounsellerpage"></td>
                                                <td><input type="checkbox" id="staffcounselleradd" name="checkbox[]" value="staffcounselleradd"></td>
                                                <td><input type="checkbox" id="staffcounselleredit" name="checkbox[]" value="staffcounselleredit"></td>
                                                <td><input type="checkbox" id="staffcounsellerdelete" name="checkbox[]" value="staffcounsellerdelete"></td>
                                            </tr>

                                            <tr>
                                                <td style="color:#a83131"><b>Student</b></td>
                                                <td><input type="checkbox" id="studentmodule" name="checkbox[]" value="studentmodule"></td>
                                                <td><input type="checkbox" id="studentpage" name="checkbox[]" value="studentpage"></td>
                                                <td><input type="checkbox" id="studentadd" name="checkbox[]" value="studentadd"></td>
                                                <td><input type="checkbox" id="studentedit" name="checkbox[]" value="studentedit"></td>
                                                <td><input type="checkbox" id="tudentdelete" name="checkbox[]" value="tudentdelete"></td>
                                            </tr>
                                        
                                            <tr>
                                                <td style="color:#a83131"><b>Users</b></td>
                                                <td><input type="checkbox" id="usersmodule" name="checkbox[]" value="usersmodule"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp User</td>
                                                <td></td>
                                                <td><input type="checkbox" id="userpage" name="checkbox[]" value="userpage"></td>
                                                <td><input type="checkbox" id="useradd" name="checkbox[]" value="useradd"></td>
                                                <td><input type="checkbox" id="useredit" name="checkbox[]" value="useredit"></td>
                                                <td><input type="checkbox" id="userdelete" name="checkbox[]" value="userdelete"></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp Roles</td>
                                                <td></td>
                                                <td><input type="checkbox" id="rolepage" name="checkbox[]" value="rolepage"></td>
                                                <td><input type="checkbox" id="roleadd" name="checkbox[]" value="roleadd"></td>
                                                <td><input type="checkbox" id="roleedit" name="checkbox[]" value="roleedit"></td>
                                                <td><input type="checkbox" id="roledelete" name="checkbox[]" value="roledelete"></td>
                                            </tr>

                                            <!-- <tr>
                                                <td style="color:#a83131"><b>Settings</b></td>
                                                <td><input type="checkbox" id="settingsmodule" name="checkbox[]" value="settingsmodule"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp&nbsp&nbsp&nbsp EMAIL SMTP</td>
                                                <td></td>
                                                <td><input type="checkbox" id="emilsmtppage" name="checkbox[]" value="emilsmtppage"></td>
                                                <td><input type="checkbox" id="emilsmtpadd" name="checkbox[]" value="emilsmtpadd"></td>
                                                <td><input type="checkbox" id="emilsmtpedit" name="checkbox[]" value="emilsmtpedit"></td>
                                                <td><input type="checkbox" id="emilsmtpdelete" name="checkbox[]" value="emilsmtpdelete"></td>
                                            </tr> -->

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- ENTER BUTTON HERE -->
                                <input type="submit" id="save_role" class="btn btn-primary" value="SUBMIT" />
                                <!-- <input type="button" onclick="add_role()" class="btn btn-primary" value="SUBMIT" /> -->
                                <input type="button" onclick="location.href='<?php echo base_url().'roleListing'?>'"
                                    class="btn btn-default" value="CANCEL" />
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>