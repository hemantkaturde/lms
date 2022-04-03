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
                <!-- <form role="form" id="addUser" action="<?php echo base_url() ?>addNewRole" method="post" role="form"> -->
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
                                        <input type="text" class="form-control required" id="role" name="role" placeholder="Eg. Manager"
                                            maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Role Type</label><br/>
                                                <div class="form-check form-check-inline mr-5 ml-5">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypesystem" value="system" checked>
                                                    System
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypecompany" value="company">
                                                    Company
                                                </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Role Description</label>
                                        <textarea type="text" class="form-control" id="discription" name="discription" placeholder="Enter Role Description"></textarea>
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
                                            <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <!-- ENTER BUTTON HERE -->
                                    <!-- <input type="submit" class="btn btn-primary" value="SEND" /> -->
                                    <input type="button" onclick="add_role()" class="btn btn-primary" value="SEND" />
                                    <input type="reset" class="btn btn-default" value="CANCEL" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </div>

    </div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>


<script type="text/javascript">
$('#clientymodule').click(function() {
    if ($(this).is(':checked')) {
        $('#clientpage').prop('checked', true);
        $('#clientadd').prop('checked', true);
        $('#clientedit').prop('checked', true);
        $('#clientdelete').prop('checked', true);
    }else{
        $('#clientpage').prop('checked', false);
        $('#clientadd').prop('checked', false);
        $('#clientedit').prop('checked', false);
        $('#clientdelete').prop('checked', false);
}
});
$('#clientpage,#clientadd,#clientedit,#clientdelete').click(function() {
    if ($('#clientpage').is(':checked') && $('#clientadd').is(':checked') && $('#clientedit').is(':checked') && $('#clientdelete').is(':checked')) {
         $('#clientymodule').prop('checked', true);
    }
});
</script>