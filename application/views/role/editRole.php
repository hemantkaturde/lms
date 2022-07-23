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
                <div class="ibox-title">Add Role</div>
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
                            <h3 class="box-title">Edit Role</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" class="form-control" id="role" name="role" value="<?php echo $role; ?>"
                                            maxlength="255">
                                        <input type="hidden" name="roleId" id="roleId" value="<?php echo $roleId ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Role Type</label><br/>
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
                                        <label for="discription">Role Description</label>
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
                            <h3 class="box-title">Assign Roles</h3>
                        </div>
                        <div class="box-body">
                             <table class="table table-bordered" >
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
                                    
                                            <td style="color:#a83131"><b>Home Page</b></td>
                                            <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule" <?php if(in_array("homepagemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!-- ENTER BUTTON HERE -->
                                    <input type="button" id="editRole" class="btn btn-primary" value="UPDATE" />
                                    <input type="button" onclick="location.href='<?php echo base_url().'roleListing'?>'" class="btn btn-default" value="CANCEL" />
                                </div>
                            </div>
                    </div>
                </form>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
