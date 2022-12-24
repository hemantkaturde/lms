<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Admission Details</div>
                <div class="ibox-title"><button type="button" id="print_details" onclick="printDiv()" class="btn btn-primary"><i class="fa fa-print"></i> Print Admission Details</div>

                
            </div>
            <div class="ibox-body">
                <div class="row">
                   <div class="col-md-12">
                       <div class="box-body" id="box-body">
                          <img src="https://iictn.org.in/images/iictn-logo-arrow.png" style="margin-left:100px" alt="iictn logo" width="70%;" class="center">
                            <div class="row col-md-12 col-sm-12 col-xs-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Personal Details :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width:20%"><b>Full Name</b></td>
                                                <td><?=$view_admission_details[0]->name;?>  <?=$view_admission_details[0]->lastname;?></td>
                                            </tr>

                                            <tr>
                                                <td style="width:20%"><b>Gender</b></td>
                                                <td><?=$view_admission_details[0]->gender;?></td>
                                            </tr>
                                           
                                            <tr>
                                                <td style="width:20%"><b>Date Of Birth</b></td>
                                                <td><?=$view_admission_details[0]->dateofbirth;?></td>
                                            </tr>

                                            <tr>
                                                <td style="width:20%"><b>Mobile Number</b></td>
                                                <td><?=$view_admission_details[0]->mobile;?></td>
                                            </tr>

                                            <tr>
                                                <td style="width:20%"><b>Alternate Mobile Number</b></td>
                                                <td><?=$view_admission_details[0]->alt_mobile;?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20%"><b>Email Id</b></td>
                                                <td><?=$view_admission_details[0]->email;?></td>
                                            </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Address Details :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width:20%"><b>Address</b></td>
                                                <td><?=$view_admission_details[0]->address;?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20%"><b>Country</b></td>
                                                <td><?=$view_admission_details[0]->countryname;?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20%"><b>State</b></td>
                                                <td><?=$view_admission_details[0]->statename;?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20%"><b>City</b></td>
                                                <td><?=$view_admission_details[0]->cityname;?></td>
                                            </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="4">COUNSELLOR NAME :</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width:20%"><b>Counsellor Name</b></td>
                                                <td><?=$view_admission_details[0]->counsellor;?></td>
                                            </tr>
                                            <!-- <tr>
                                                <td style="width:20%"><b>Counsellor contact Number</b></td>
                                                <td><?=$view_admission_details[0]->counsellor_mobile;?></td>
                                            </tr> -->
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="4">HOW DID KNOW ABOUT US</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td style="width:20%"><b>Source</b></td>
                                                <td><?=$view_admission_details[0]->source_about;?></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20%" ><b>Source Ans</b></td>
                                                <td><?=$view_admission_details[0]->source_ans;?></td>
                                            </tr> 
                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Uploaded Documents</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td><b>Student Photo</b></td>
                                                <td><b>Education Certificate</b></td>
                                                <td><b>Aadhar Copy</b></td>
                                            </tr>
                                            <tr>
                                                <td><img src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_1 ?>'></td>
                                                <td><img src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_2 ?>'></td>
                                                <td><img src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_3?>'></td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                       </div>
                   </div>
                </div>
            </div>    
        </div>    
    </div>
</div>

<script type="text/javascript">

function printDiv() {
     var printContents = document.getElementById('box-body').innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
        }
</script>