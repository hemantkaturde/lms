<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div style="margin-left: 474px;"><div class="ibox-title">Admission form</div></div>
                <div><div class="ibox-title"><button type="button" id="print_details" onclick="printDiv()" class="btn btn-primary"><i class="fa fa-print"></i> Print Admission form</div></div>

                
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
                                            <th colspan="4">Applicant Details :</th>
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
                                                <td style="width:20%"><b>Mobile Number / Roll No</b></td>
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
                                            <th colspan="4">Contact Information :</th>
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
                                                <td><img height='250px' weight='100px' src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_1 ?>'></td>
                                                <td><img height='250px' weight='100px' src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_2 ?>'></td>
                                                <td><img height='250px' weight='100px' src='<?php echo base_url(); ?>uploads/admission/<?=$view_admission_details[0]->document_3?>'></td>
                                            </tr>
                                    </tbody>
                                </table>


                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3">INSTRUCTIONS, TERMS & CONDITIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td><b>Please note,</b> The selection of the courses and packages are based on an individual’s understanding and due diligence. Due to different schemes and policies, Course fee and package can differ from other applicants from time to time.</td>
                                            </tr>
                                            <tr>
                                                <td>1. Applicants must fill their admission form along with all mandatory documents on the online admission form link attached in this email.</td>
                                            </tr>
                                            <tr>
                                                <td>2. Applicants will not be added in online study groups and cannot start courses, unless they have filled and submitted the admission form within a period of 72hrs. The same copy of the admission form will be emailed to the related student’s email id also.</td>
                                            </tr>

                                            <tr>
                                                <td>3. We will only accept the course(s) that have been mentioned on your final invoice sent on your email id by IICTN management.</td>
                                            </tr>  
                                            <tr>
                                                <td>4. Applicant Must download Telegram, Zoom / Google Meet / WEBEX applications before starting Online class / Lecture.</td>
                                            </tr>  
                                            <tr>
                                                <td>5. Class joining link will be sent in group one day to 10min before starting lecture</td>
                                            </tr>  
                                            <tr>
                                                <td>6. Applicants must sit comfortably in a place where network coverage is good.</td>
                                            </tr>  
                                            <tr>
                                                <td>7. Audio & Video of the Applicant side should be in off mode to avoid noise disturbance from the background.</td>
                                            </tr>  
                                            <tr>
                                                <td>8. After the lecture the applicant can unmute and ask any query related to the course in the class itself so everyone else also can know all the questions and answers.</td>
                                            </tr>  
                                            <tr>
                                                <td>9. Please do not personally WhatsApp trainers after class as they are back to back Scheduled for other classes.</td>
                                            </tr>  
                                            <tr>
                                                <td>10. Study material will be dispatched 1 week or more only after the full course fee is received.</td>
                                            </tr>  
                                            <tr>
                                                <td>11. Books / Certificates have to be personally collected, If applicant needs it to be couriered, Applicable charges of Rs.200/- have to be borne by applicant within INDIA , For international courier charges actual cost of courier will be applicable and institute will not be held responsible for any damages. In case if any book is damaged, Reissue charges Rs 600/book.</td>
                                            </tr>  
                                            <tr>
                                                <td>12. We have a modular study pattern, students class will start from the topic of the selected course that will be conducted on that day and when the full cycle of the module will be covered / completed the applicant should leave the group or will be removed from the group by the management.</td>
                                            </tr>  
                                            <tr>
                                                <td>13. Students will be informed 10 days prior for exam dates via Email / WhatsApp / Telegram Applications group.</td>
                                            </tr>  
                                            <tr>
                                                <td>14. Applicants will be awarded with the certificate after the period of 3/4 months. only after the successful completion of the exam.</td>
                                            </tr>  
                                            <tr>
                                                <td>15. A Doctor Medical Registration copy is mandatory for IICTN to write the prefix ‘Dr’ on their certificates that will be issued by IICTN.</td>
                                            </tr>  
                                            <tr>
                                                <td>16. Applicants are not allowed to share any data provided by the management from any online / offline sources . All Documents / Contact Details / Study Material / Notes / PPT / Video / Audio etc. are copyrighted and property of the institute only.</td>
                                            </tr>  
                                            <tr>
                                                <td>17. Kindly Read Carefully & Understand Lectures Teaching method ( Live theory lectures are conducted & No videos of live lectures /practical will be shared)</td>
                                                </tr>  
                                            <tr>
                                                <td>18. Notes/ PPT if any will be shared within 2 days. So if the lecture was attended or missed by you , please do not disturb the group by asking about notes or PPT everyday as all topics are repeated every month for 3 months and you have the relevant book also.</td>
                                                </tr>  
                                            <tr>
                                                <td>19. Time table will be shared to you by your consultants, Kindly save a screenshot for the same in your photo gallery to check days , dates and time of classes / lectures as not all courses have lectures / classes every day, do not ask if lecture / class is conducted every day in the group.</td>
                                                </tr>  
                                            <tr>
                                                <td>20. Online / Offline Classes: Kindly cooperate with the faculty & attend courses as per Institute’s Class timings / Topics / Trainers & lecturers / Method of teaching / Online and Offline Platform of Teaching & Time table. Topics once taught will not be repeated, Topics if missed have to be studied by the applicant themselves from books / notes provided by the institute. Applicants can give exams online if their courses have only theory and no practical. Classes are daily for 1.5 hour for each courses (subjective to course opted) for which time table is posted in start of every month, Each course duration will last for 3 months but if due to any medical issues / marriage etc., course completion validity can be extended to 06 months if relevant documents are provided by the applicant via email.</td>
                                                </tr>  
                                            <tr>
                                                <td>21. Offline Practical Sessions: Once the relevant theory class is completed, students can come for offline practical sessions. Schedule can change at any time subject to government rules/norms from time to time and the institute holds no responsibility or liability for the same.</td>
                                                </tr>  
                                            <tr>
                                                <td>22. Online Practicals: Once the relevant theory class is completed, students will be removed from theory group & added in Online practical group with online / live videos that can be shared & explained once or twice a week.</td>
                                                </tr>  
                                            <tr>
                                                <td>23. Practicals will be conducted at IICTN Mumbai head office only and Applicant can email on admin@iictn.org to inform us about their schedule for attending practical classes, if applicant is from out of Mumbai then institute will inform them via email / WhatsApp / Telegram within a period of 7 days.</td>
                                                </tr>  
                                            <tr>
                                                <td>24. Diet course has no Practicals as it is a purely online course.</td>
                                                </tr>  
                                            <tr>
                                                <td>25. Please do not send any forwarded messages in groups. Also Messages of any emergency , festival or promotions should not be shared in these groups as there are already many groups and other platforms for the same . Let us keep it related to the courses only.</td>
                                                </tr>  
                                            <tr>
                                                <td>26. Applicants enrolled for any collaborated University / Council / Government courses through IICTN, Applicant is advised to coordinate directly to related bodies for their queries, IICTN will not be held responsible for the same. Applicants will receive a separate instruction copy with their Terms & Conditions for the same by email.</td>
                                                </tr>  
                                            <tr>
                                                <td>27. University / Council / Government courses certification will be issued after a year or more subject to their parameters.</td>
                                                </tr>  
                                            <tr>
                                                <td>28. The institute reserves the rights to Change, Modify and update the Course Curriculum / location of classes / Class timings / Topics / Trainers & lecturers / Method of teaching / Online and Offline Platform of Teaching / Time table at any given time subject to the discretion of the management and It shall be abiding on the Applicant to undergo for the same.</td>
                                                </tr>  
                                            <tr>
                                                <td>29. Any query besides the topics of course can be discussed by sending WhatsApp to your relevant counsellor rather than asking in the group between 10-6pm Monday to Saturday.</td>
                                                </tr>  
                                            <tr>
                                                </tr>  
                                            <tr>
                                                <td>30. Please wait 72 hours for a reply by WhatsApp or someone will call you.</td>
                                                </tr>  
                                            <tr>
                                                <td><b>Note:</b> This is a computer generated copy, applicant signature is not required. Acceptance of the terms and conditions will be acknowledged by default and applicants shall abide by the same.</td>
                                                </tr>  
                                            <tr>
                                                <td><b>By-Laws:</b> Rules, Terms and Conditions are non-negotiable and subject to change without prior notice and will be abided by the applicant, Dispute if any, is subject to Mumbai Jurisdiction only.</td>
                                                </tr>  
                                            <tr>
                                                <td><b>Please read T&C carefully</b>, Institute will not entertain and accept any requests apart from mentioned Terms & Conditions on this copy, final Invoice copy and Admission form.</td>
                                            </tr>  
 
                                             </td>
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