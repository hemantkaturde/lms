
<?php 
$pageUrl =$this->uri->segment(1);
$access = $this->session->userdata('access');
$roleText = $this->session->userdata('roleText');
?>


<div class="content-wrapper">
    <div class="page-content fade-in-up col-md-12">
        <div class="ibox">
            <div class="ibox-head">
                <div style="margin-left: 474px;"><div class="ibox-title">APPLICANT DETAILS</div></div>
               
                <div>
                    
                <div class="ibox-title">
                 <?php if($role_text!="Student"){ ?>
                    <button type="button" id="print_details" onclick="printDiv()" class="btn btn-primary"><i class="fa fa-print"></i> Print Admission form   </button>
                <?php } ?>
                <?php if($role_text!="Student"){ ?>
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'/studentadmissions';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'/admissionListing';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                <?php } ?>
            </div></div>

                
            </div>
            <div class="ibox-body">
                <div class="row">
                   <div class="col-md-12">
                       <div class="box-body" id="box-body">
                          <img src="https://iictn.org/wp-content/uploads/2022/12/45-1-r.jpg" style="margin-left:100px" alt="iictn logo" width="70%;" class="center">
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

                                            <tr>
                                                <td style="width:20%"><b>Aadhaar Number</b></td>
                                                <td><?=$view_admission_details[0]->aadhaarnumber;?></td>
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
                                            <th colspan="3">ADMISSION TERMS, CONDITIONS & POLICIES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td>Applicants are advised to note that the selection of the courses and packages are based on an individual’s understanding, choice, and due diligence. The course fee and package can differ from other applicants.</td>
                                            </tr>
                                            <tr>
                                                <td><b>Mandatory details and documents required to be filled out and uploaded on our online / digital admission form before starting the course:</b></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>a.	Passport size colour photograph</p>
                                                    <p>b.	For Doctors - Medical Registration / For Non-Doctor - Highest Education Certificate</p> 
                                                    <p>c.	Aadhar Card / Passport / Driving License</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Applicant promises and agrees that all details filled in and documents uploaded and submitted on our online or digital admission form are true, authentic, and genuine in accordance with institute requirements, and that if any details or documents uploaded are found to be non-authentic, genuine, or fake, it is the applicant's sole responsibility, and management and the institute will not be held responsible for the same at any time in the future.</td>
                                            </tr>  
                                            <tr>
                                                <td><b>1.	Administration:</b> If Applicant has any query regarding Courses Fee, Learning, Classes, Practicals, Exams or Certifications, Therefore, we advise that Applicant should send their queries via WhatsApp / Telegram on 9820000030 or email admin@iictn.org or mumbai.iictn@gmail.com Applicant queries will be attended in 10 working days subject to approvals from the management, Applicant cooperation will be appreciated.</td>
                                            </tr>  
                                            <tr>
                                                <td><b>2.	Fees: </b>If the applicant has paid a registration fee of Rs. 5,000, registration will be valid for 3 months from the date of payment, Kindly note that along with each enrolled course fee, the applicant also paid the applicable and mandatory exam fee of each course of Rs. 2,600 plus a one-time admin fee of Rs. 2,600, which is included in the course fee, and that each online and offline topic session (webinar, lecture) original cost is Rs. 5100/-. The apron fee of Rs. 300 is separate from the course fees. It is optional to purchase from the institute or buy it yourself, but it is mandatory to wear the apron during offline classes and Practicals. </td>
                                            </tr>  
                                            <tr>
                                                <td><b>3.	Fee Instalments:</b>Fees can be paid in two instalments over two-weeks apart only, with 75% as the first instalment and an exam fee extra to begin the course; however, if paying in installments, applicants are only permitted to attend lectures once a week. Kindly note that the book and study materials will be issued after full payment of the course fees. If the applicant is unable to pay the balance fee amount within two months due to whatever reason, he or she will not be entitled to any refund. However, at its sole discretion, the institute may accommodate applicants with the next batch schedule and can advise on converting the course into a short certificate course or other services.</td>
                                            </tr>  
                                            <tr>
                                                <td><b>4.	Education Loan: </b>Applicants are advised to do their own due diligence before opting for any education loan service from the any financial institutions and platform provided by the institute or from any other financial institutions. The Institute will not be responsible, answerable, or accountable for any dispute that arises now or in the future.</td>
                                            </tr>  
                                            <tr>
                                                <td>
                                                   <p><b>5.	Online / Offline Classes: </b>Kindly cooperate with the faculty and attend course lectures as per the institute’s class timings, topics, trainers and lecturers, methods of teaching, online and offline platforms of teaching, and timetable. Topics once taught will not be repeated; if missed, they have to be studied by the applicant themselves from study material in any form, such as printable, digital, book, PPTs, notes, video, audio, online or offline, once shared and provided by the institute. Classes and lectures are weekly or fortnightly for 1.5 hours for each course (subjective to the course opted), for which a timetable is posted or shared in respective Telegram groups at the start of every month. Each course duration will last as per the syllabus, or for 3 months, whichever is earlier, but if, due to any medical issues, marriage, etc., the course completion validity has expired, it can be extended to another 3 months if relevant supporting documents are provided by the applicant via email at admin@iictn.org or mumbai.iictn@gmail.com Applicants can give exams online if their courses have only theory and no practical.</p>

                                                   <p><b>Offline Practical Sessions:</b> Once the relevant theory class is completed, Applicants can appear for offline practical class. The schedule can change at any time subject to the discretion of the management. If government rules and norms changed due to any reason whatsoever, the institute holds no responsibility or liability for the same.</p>

                                                   <p><b> Online Practicals: </b>Once the relevant theory class is completed, Applicants will be removed from the theory group and added to the online practical class group with online or live videos that can be shared and explained once or twice a week only.</p>
                                                </td>
                                            </tr>  
                                            <tr>
                                                <td><b>6.	Machines Use: </b>If Applicant breaks any machine, he / she has to pay Rs. 5,000/- or 30% of the actual cost of the part of the machines on very next day itself. Thus, while Practicals applicants are advised to look after for Equipment / Machines carefully.</td>
                                            </tr>  
                                            <tr>
                                                <td>
                                                    <p><b>7.	Course Certificates: </b>In order to secure the certificate, applicants should complete the theory and practical portions of both and clear the examination of the course (s) with a 75% passing mark. A certificate will be issued three months after the institute receives the applicant's course completion confirmation email by the applicant email id only. It is mandatory to email a copy of all bills to bills.iictn@gmail.com when applying for certification. Applicants are not allowed to attend theory and practical classes after the exams or issuance of certifications, please be ethical and start making your professional commitment only after you have been awarded the certificate. The institute reserves the right to change, modify, or update the format of the certificate at any given time, subject to the discretion of the management.</p>

                                                    <p><b>Workshop Certificate: </b>A workshop certificate will be awarded on the last day of the workshop to only those applicants who have made their full fee 15 days in advance before the start of the workshop. If the applicant has only made a partial payment and attended the workshop, they must pay their outstanding fees in order to receive their workshop certificate. Applicants who clear their dues after the workshop are only eligible to receive their workshop certificate 15 working days after receiving their pending dues. and courier charges must be borne solely by the applicants.</p>
                                                </td>
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