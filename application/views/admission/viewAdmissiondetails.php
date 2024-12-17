
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
                <?php if($role_text=="Student"){ ?>
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'studentadmissions';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
                    </button>
                <?php }else{ ?>
                    <button type="button" class="btn btn-primary">
                            <a href="<?php echo base_url().'admissionListing';?>" style="color: black !important"><i class="fa fa-arrow-left"></i> Back</a>
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


                                <!-- <table class="table table-bordered">
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
                                </table> -->

                                
<body style="color: black;">
    <p>Greetings !!!</p>
    <p style="text-align:justify;"> Welcome to Destination for Excellence from 19 years. Dr. Jhoumer Jaiitly, Founder,
        Head of Faculty & CMD is a renowned iconic personality in the Health & Wellness industry with over 24 years of
        experience. <b>The Indian Institute of Cosmetology, Trichology, and Nutrition Private Limited (IICTN)</b>, is an
        industry leader to provide course consultations and career guidance, offering a range of programs aimed at
        enhancing and upgrading skills, from empowerment to employment. The curriculum and lectures are designed to meet
        global standards and industry requirements, Featuring extensive hands-on training, supplemented by in-depth
        theoretical knowledge of Course, Business Fundamentals and Legal framework. Additionally, IICTN facilitates
        admissions for degree programs from universities and colleges for Beauty, Health, & Wellness industries.</p>
    <p style="text-align:justify;"> Applicants are advised to note that the selection of courses and packages is based
        on individual understanding, choice, and due diligence before opting for courses offered and facilitated by our
        counsellors. By doing so, they consent to having understood the current scheme, discounted offers, fee package,
        fee breakdown, fee installment policy, and related terms. Please note that course fees and packages may differ
        from other applicants.</p>
    <p>Please review the Joining Instructions, Terms and Conditions, and Company Policies. If you have any questions,
        kindly respond to this email within 24 hours. If no response is received, your consent to the terms and
        conditions will be acknowledged by default.</p>
    <h3 style="font-size:11px;"><u>INSTITUTE OFFERS TWO OPTIONS FOR LEARNING:</u></h3>
    <p><b>Option 1 - </b><u>Offline Course -:</u> Applicants will attend theory by online class of the course and can
        attend practical sessions within 6 months at IICTN Mumbai centre or designated centre in other cities from
        time to time. If the applicant does not complete the practical sessions within this period, the course will
        automatically convert to Option 2.</p>
    <p><b>Option 2 - </b><u>Offline Course -:</u> Applicants will not attend practical sessions at the institute but
        will have access to live practical demonstrations or online sessions. No pre-recorded lectures will be
        provided. If the applicant wishes to switch to an option 1 - offline course, they can do so by paying an
        additional fee of Rs. 6,000/- per course.</p>
    <p style="text-align:justify;">In the case of pregnancy or medical issues affecting the applicant or their family
        members, the applicant may request a hold or extension of the course duration by submitting relevant supporting
        documents, duly signed and stamped by the doctor and hospital (Management reserves the right to verify the
        authenticity of the documents). Please note that fee refund requests at any stage of the course will not be
        considered or accepted under any circumstances, and our refund policy will strictly apply. </p>
    <h3 style="font-size:11px;"><u>JOINING INSTRUCTIONS</u></h3>
    <p style="text-align:justify;">1. Applicants must fill out their correct details on the admission form link, along
        with uploading all mandatory required documents in color format. click on admission link:
        https://iictn.org.i/admission (ignore if already filled and submitted).</p>
    <p style="text-align:justify;">2. Applicants must Fill and submit the Admission form to enable themselves to be
        added to online / offline study groups to start the course.</a>
    <p style="text-align:justify;">3. Documentation: All required documents are mandatory and must be submitted in one
        go within 7 working days from the receipt of the fee paid to IICTN. Please note that document submission is only
        accepted via email at bills.iictn@gmail.com; any other form of submission will not be acknowledged or accepted
        under any circumstances. Failure to comply may result in delays in admission, cancellation, or penalties
        (minimum Rs. 3000/-), for which IICTN will not be held liable. If applicants require further clarification, they
        are advised to contact the Administration Team or their consultant. Applicant adherence to the processes and
        timelines detailed above is mandatory</a>
    <p style="text-align:justify;">
        MANDATORY DOCUMENTS LIST FOR ADMISSION:
    <p>1. Photo (Passport Size)</p>
    <p>2. Aadhar (both side)</p>
    <p>3. Active Mobile Number</p>
    <p>4. Valid Email ID</p>
    <p>5. 10th Marksheet </p>
    <p>6. 12th Marksheet </p>
    <p>7. Graduation Marksheet</p>
    <p>8. Students Signature</p>
    <p>9. Degree Certificate / All Semester Marksheet & Internship Certificate 10. Excel Sheet filled by the applicant
        with correct details</p>
    </p>
    <p style="text-align:justify;">The applicant hereby affirms that all details provided and documents uploaded or
        submitted through our online or digital admission form, as well as any information shared via email, are
        accurate, authentic, and in compliance with the institute's requirements. The applicant acknowledges that in the
        event any information or documents are found to be inaccurate, misleading, or fraudulent, the applicant will
        bear full responsibility. The institute and its management will not be held liable for any consequences arising
        from such discrepancies at any point in the future.
    </p>
    <p style="text-align:justify;">
        We kindly request that you refrain from ignoring calls, raising concerns, or citing medical reasons when
        management or your counsellor contacts you regarding any pending documents or outstanding fees. Please note that
        if the payment is overdue by more than 30 days, the applicant will be temporarily removed from the group and
        re-added once pending fee is paid.
    </p>
    <p style="text-align:justify;">
        4. Study material will be dispatched within 7 working days only after the full fee of the course is received for
        the particular course.
    </p>
    <p style="text-align:justify;">
        5. Applications: Applicants must download such as Telegram, Zoom, Google Meet application to start the course..
    </p>
    <p style="text-align:justify;">
        6. Once the applicant has joined the Telegram group, ensure that notifications are turned on for all
        communications. Set reminders for classes (30 minutes before each session). The monthly timetable is shared in
        the respective course group on Telegram only; kindly take a screenshot and save it in your phone gallery.
    </p>
    <p style="text-align:justify;">
        7. No information will be shared individually with any students regarding classes, exams, or practical sessions.
        Students must remain active in the course groups to stay informed and updated.
    </p>
    <p style="text-align:justify;">
        8. Study Links: The study link will be sent in the course’s group from one day to 10 minutes before the start of
        the lecture. Applicants are advised to attend classes from a location with good network coverage. Please be
        ensure that both your background audio and video are turned off during the lecture to avoid disturbance along
        with your audio on mute.
    </p>

    <p style="text-align:justify;">
        9. Queries: Any queries, besides course topics, should be discussed via WhatsApp with your counsellor instead of
        asking in the study groups. Counsellors are available between 10 am to 6 pm, Monday to Saturday. Please wait up
        to 7 working days for a response.
    </p>

    <p style="text-align:justify;">
        10. Post-Lecture Queries: After the lecture, applicants can write their topic or course related queries in the
        chat box. This allows everyone in the class to benefit from the discussion. Please refrain from personally
        messaging trainers after the class, as they are scheduled for back-to-back sessions.
    </p>

    <p style="text-align:justify;">
        11. Practical Sessions: Practical sessions will be conducted at the IICTN Mumbai head office only. Applicants
        from outside Mumbai should email their schedule to bills.iictn@gmail.com to inform the institute of their
        intended dates for attending practical classes. The institute will confirm practical session details via email,
        WhatsApp, or Telegram within 15 working days. Please note: The diet course does not have practical sessions, as
        it is only a theory course.
    </p>

    <p style="text-align:justify;">
        12. Group Conduct: Do not send forwarded messages or share social, news, emergency, festival, or promotional
        content in the groups. Personal queries should not be posted in the group; kindly contact the admin team or your
        counselor directly for such matters. Course study links will be shared exclusively in the Telegram group.
    </p>

    <p style="text-align:justify;">
        12. Group Conduct: Do not send forwarded messages or share social, news, emergency, festival, or promotional
        content in the groups. Personal queries should not be posted in the group; kindly contact the admin team or your
        counselor directly for such matters. Course study links will be shared exclusively in the Telegram group.
    </p>

    <p style="text-align:justify;">
        13. Please study and thoroughly understand the topics and subjects covered in the curriculum lectures. Kindly
        note that no videos of live lectures, Practical sessions will be shared and provided.
    </p>

    <p style="text-align:justify;">
        14. Books / Certificates can be couriered or collected personally. Within India, the applicant must bear the
        applicable courier charge of Rs. 300 per courier, and for international shipments, the applicant must bear the
        actual cost of the courier. The Institute will not be responsible for any damages or loss of any documents. In
        the event of damage, loss, or the need for an updated version of a book, per-book reissue
        charges are Rs. 1500/-.
    </p>

    <p style="text-align:justify;">
        15. We follow a modular study pattern, meaning that an applicant's class will begin with the topic being covered
        in the selected course on that day. Once the full cycle of the course module has been completed, the applicant
        should either leave the group or will be removed by the management.
    </p>
    <p style="text-align:justify;">
        16. IICTN Exam & Certification:
        <li>Upon completion of the course, applicants are required to email the administration to request their exam
            papers.</li>
        <li>IICTN exams are not conducted on a batch basis but rather upon individual request when students are
            prepared.</li>
        <li>The completed exam sheet must be submitted to the administration via the applicant's registered email
            address only.</li>
        <li>After submitting the exam sheet, applicants must initiate the certificate process by contacting the
            administration team and requesting the certificate format for submission.</li>
        <li>Certification: IICTN Certificates will be issued within 3 to 6 months after the receipt of the exam
            completion and exam sheet submission by applicant or as determined by the Management.</li>
    </p>
    <p style="text-align:justify;">
        17. (B&WSSC – NCVET) Government Exam & Certification: Please note that the dates and timelines for the receipt
        of exams and certificates issued by the B&WSSC are not under the control of IICTN.
        <li> Applicants are advised to register for the government exam only when they are fully prepared. Attendance is
            mandatory.</li>
        <li>Exams are conducted on a batch-wise basis, primarily every month, and are not administered individually.
        </li>
        <li>Offline theory exams must be completed using the designated application.</li>
        <li>A half-hour viva and practical exam will be conducted individually for each applicant.</li>
        <li>Government exams are overseen by external government examiners, and a 100% passing rate is required.</li>
        <li>Failure to pass on the first attempt will result in a certification noting the need for a second attempt.
        </li>
        <li>Failure to attend the exam for any reason, including medical emergencies, will result in a ₹5,100 penalty.
            This penalty is strictly enforced and non-negotiable.</li>
        <li>Certification: Certificates will be issued within 3 months or as determined by the respective
            Body’s Schedule.</li>
    </p>
    <p style="text-align:justify;">
        18. University Exam & Certification: Please note that the dates and timelines for the receipt of exams and
        certificates issued by the university are not under the control of IICTN.
        <li>University exams are scheduled every six months, primarily in July and December.</li>
        <li>It is iUniversity exams are conducted over a span of 10 daysmperative that applicants submit all required
            documentation within 2 to 3 days of the request to avoid delays in exam scheduling.</li>
        <li>University exams are conducted over a span of 10 days</li>
        <li>The exams include topics related to Spoken English, Computer Knowledge, Nutrition, and Safety Measures, in
            addition to the curriculum pursued.</li>
        <li>University Certification: Certificates will be issued after 9 months or as determined by the respective
            body’s schedule.</li>
    </p>
    <p style="text-align:justify;">
        19. To use the prefix "Dr." before your name on certificates or any other documents issued by IICTN, applicants
        must submit a copy of their medical registration.
    </p>
    <p style="text-align:justify;">
        20. The institute will not be responsible or liable if applicants fail to collect their certificates,
        marksheets, or any other documents within 9 months, whether they pertain to IICTN or any other collaborating
        entities, after IICTN has received the documents.
    </p>
    <p style="text-align:justify;">
        21. IICTN each course's validity and duration will last as per the syllabus, or up to six months; after six
        months, applicants will be charged extra fees of 30% including applicable taxes for each course to finish the
        pending portion only within the period of 30 days / within one month.
    </p>
    <p style="text-align:justify;">
        22. As per company policy, once granted, admission cannot be canceled. The institute strictly adheres to a
        no-refund policy, and fee refund requests will not be addressed or accepted for any reason and circumstances,
        including epidemics, pandemics, government regulations, dissatisfaction with topics, class timings and days,
        trainers and lecturers, or personal or family medical issues at the beginning of the course or at any time
        during its duration.
    </p>
    <p style="text-align:justify;">
        23. The Institute will not address or accept any requests beyond those mentioned in this document, the final
        invoice, and the admission form. We recognize only the course(s) specified on your final invoice, which has been
        sent to your email by IICTN management based on your course selection and full fee payment received. If there
        are any outstanding fees, the applicant will only be eligible for IICTN-issued courses and certifications and
        will not be eligible for those from any collaborative body, even if mentioned on the invoice.
    </p>
    <p style="text-align:justify;">
        24. If the applicant fails to submit the admission form (offline, online, or digitally) before or after the
        course starts, all terms, conditions, and policies will apply by default, and the applicant must
        comply with them.
    </p>

    <h3 style="text-align: center; text-transform: capitalize; text-decoration: underline;">
        TERMS, CONDITIONS & POLICIES
    </h3>
    <p style="text-align:justify;">
        25. Administration: If Applicant has any query regarding Courses Fee, Learning, Classes, Practicals, Exams or
        Certifications, Therefore, we advise that Applicant should send their queries via WhatsApp / Telegram on
        9820000030 or email on admin@iictn.org / bills.iictn@gmail.com Applicant queries will be attended in 10 working
        days subject to approvals from the management, Applicant cooperation will be appreciated.
    </p>
    <p style="text-align:justify;">
        26. Fees: As per policy, full course fees must be paid in advance, whether for an IICTN course or a
        collaborative body’s course, even if the course or package is opted for under a discounted scheme or separately.
        In addition, if the applicant has paid less than Rs. 5,000, it will be considered only as a registration or
        booking amount. This amount will be valid for 3 months from the date of payment and is non-refundable and
        non-transferable.
    </p>

    <p style="text-align:justify;">
        27. Fee Installments: Fees can be paid in two installments, spaced two weeks apart, with 75% paid as the first
        installment, plus an additional exam fee to begin the course. However, if paying in installments, applicants are
        permitted to attend lectures only once a week. Please note that books and study materials will be issued after
        full payment of the course fees. If the applicant is unable to pay the remaining balance within 3 months for any
        reason, they will not be entitled to a refund. However, at its sole discretion, the institute may accommodate
        applicants in the next batch or advise on converting the course into a short certificate program or other
        services.
    </p>

    <p style="text-align:justify;">
        28. Fees Breakdown: Please note that the actual cost of each course is Rs. 78,000. The original cost of each
        online and offline session (webinar or lecture) is Rs. 2,600. However, the fee charged by IICTN may vary based
        on the current discount scheme or package, which can be significantly lower. The discounted course fee includes
        taxes (GST 18%), a one-time administration fee of ₹2,600, exam fees of ₹2,600 per course, certification fees of
        ₹2,600 per course, book fees of ₹1,500 per course, plus training fees, etc. Additionally, for each sponsored
        course by IICTN, only a separate certification fee of ₹2,600 is applicable, and other fees such as
        administration, book, training, and exam fees are not charged for each sponsored course, as specified in your
        invoice copy.
    </p>

    <p style="text-align:justify;">
        The fee structures and breakdown provided above are intended for transparency to prevent any misunderstandings
        regarding fees. In the event of any discrepancies or disputes, only the specified breakdown, original course
        fee, and the cost of each online/offline lecture will be considered binding. Applicants must adhere to these
        terms.
    </p>

    <p style="text-align:justify;">
        29. Education Loan: Applicants are advised to do their own due diligence before opting for any education loan
        service from any financial institutions and platform provided by the institute or from any other financial
        institutions. The Institute will not be responsible, answerable, or accountable for any dispute that arises now
        or in the future.
    </p>

    <p style="text-align:justify;">
        30. Online / Offline Classes: Kindly cooperate with the faculty and attend course lectures as per the
        institute’s class timings, topics, trainers and lecturers, methods of teaching, online and offline platforms of
        teaching, and timetable. Topics once taught will not be repeated; if missed, they have to be studied by the
        applicant themselves from study material in any form, such as printable, digital, book, PPTs, notes, video,
        audio, online or offline, once shared and provided by the institute. Classes and lectures are weekly or
        fortnightly for 1.5 hours for each course (subject to the course opted), for which a timetable is posted or
        shared in respective Telegram groups at the start of every month. Each course duration will last as per the
        syllabus, or for 3 months, whichever is earlier, but if, due to any medical issues, marriage, etc., the course
        completion validity has expired, it can be extended to another 3 months if relevant supporting documents are
        provided by the applicant via email at admin@iictn.org or bills.iictn@gmail.com Applicants can give exams online
        if their courses have only theory and no practical.
    </p>

    <p style="text-align:justify;">
        31. Machines Use: If Applicant breaks any machine, he / she has to pay Rs. 5,000/- or 30% of the actual cost of
        the part of the machines on the very next day itself. Thus, while Practicals applicants are advised to look
        after for Equipment / Machines carefully.
    </p>

    <p style="text-align:justify;">
        32. Certificates: In order to secure the certificate, applicants should complete the theory and practical
        portions of both and clear the examination of the course(s) with a 75% passing mark. A certificate will be
        issued three months after the institute receives the applicant's course completion confirmation email by the
        applicant email id only. It is mandatory to email a copy of all bills and final Invoice copy to
        bills.iictn@gmail.com when applying for certification. Applicants are not allowed to attend theory and practical
        classes after the exams or issuance of certifications, please be ethical and start making your professional
        commitment only after you have been awarded the certificate. The institute reserves the right to change, modify,
        or update the format of the certificate at any given time, subject to the discretion of the management.
    </p>

    <p style="text-align:justify;">
        33. Workshop Certificate: A workshop certificate will be awarded on the last day of the workshop to only those
        applicants who have made their full fee 15 days in advance before the start of the workshop. If the applicant
        has only made a partial payment and attended the workshop, they must pay their outstanding fees in order to
        receive their workshop certificate. Applicants who clear their dues after the workshop are only eligible to
        receive their workshop certificate 15 working days after receiving their pending dues. Courier charges must be
        borne solely by the applicants.
    </p>
    <p style="text-align:justify;">
        34. Books / Certificate Collection: It can be couriered or collected personally. Within India, the applicant
        must bear the applicable courier charge of Rs. 300 per courier, and for international shipments, the applicant
        must bear the actual cost of the courier. The Institute will not be responsible for any damages or loss of any
        documents.
        <li>In the event of damage, loss, or the need for an updated version of a book, per-book reissue charges are Rs.
            1500/-.</li>
        <li>In the event of damage, loss, name change, etc., per certificate reissue charges are Rs. 2600/-.</li>
        <li>Fees for any reissuing of any documents should be paid in advance and must be borne by the applicant only.
        </li>
    </p>
    <p style="text-align:justify;">
        35. Attendance: The minimum attendance required is 85%, failing which the applicant will not be allowed to
        appear for the exams. For more than 3 days' absence, please email documents for leave. However, in cases of
        sudden illness where prior permission is not possible, a medical certificate from a doctor must be emailed to
        admin@iictn.org or mumbai.iictn@gmail.com.
        <li>Each course's validity and duration will last as per the syllabus, or up to six months; after six months,
            applicants will be charged 30% course fees for each course to finish the pending portion within one month.
        </li>
        <li>The institute is not responsible for covering up if the applicant misses his or her classes for whatever
            reason or if the course duration extends beyond 6 months.</li>
        <li>The institute reserves the right to change and modify the course curriculum, location of classes, class
            timings, topics, trainers and lecturers, method of teaching, online and offline platforms of teaching, and
            timetable at any given time, subject to the discretion of the management, and it shall be the applicant's
            responsibility to undergo the same.</li>
        <li>After 6 months, if applicants wish to learn the full course again, they have to pay 30% of the course fee
            again for the study of that course within 2 months. Please do not take leave during these two months.</li>
        <li>The applicant authorises and gives consent to the institute, stating that they have been clearly explained
            and informed by the trainer, staff, and management that the practical class, demonstration class, and
            procedure will be done with due care and that the possible effects and post-care precautions have to be
            taken after the procedures.</li>
        <li>Applicants are consensually and voluntarily taking part as models in practical, demonstrations, and
            procedures during the class at their own will and risk and will not hold the trainer, owner, associate
            owner, or any other staff of the institute responsible for any side effects or injuries.</li>
        <li>Applicants voluntarily participating in the video and photo shoot consent to their usage for marketing and
            promotional activities without claiming royalties or charges.</li>
    </p>
    <p style="text-align:justify;">
        36. Collaborative Course Terms: The vision and mission of IICTN are to provide opportunities for specialization
        and skill education that are demographically relevant, in demand, and in accordance with established standards.
        To achieve this mission, IICTN collaborates with universities, councils, institutions, and private organisations
        to offer relevant courses and opportunities. However, applicants are advised to conduct their due diligence
        before enrolling in a collaborative body’s courses. The applicant should not hold IICTN responsible for any
        guidance related to admission, study facilitation, or placement in India or abroad at any time in the future.
        IICTN is merely facilitating the details and processes regarding fees, admission, exams, marksheets, and the
        certification process, as clearly explained by the counsellors before opting for any collaborative courses.
        Having provided your consent and expressed satisfaction with this understanding, IICTN will not be held
        responsible for any delays in admission, exams, certifications, or course discontinuation.
    </p>

    <p style="text-align:justify;">
        Please note that the dates and time frames for the receipt of exams and certificates issued by the collaborating
        body are not under the control of IICTN. Any delays regarding exams and certificates are subject to the terms
        and conditions of the collaborating body and will be the sole responsibility of that entity. If an applicant has
        any queries regarding exams, marksheets, or certifications, IICTN advises that the applicant should send their
        inquiries directly to the related body, while keeping IICTN in the loop to maintain transparency. IICTN assures
        the best possible support for our students but will not be held liable or accountable for any delays in the
        process of admission, examination, or issuance of marksheets and certifications by the collaborating entities.
    </p>

    <p style="text-align:justify;">
        The duly completed application forms, along with the mandatory documents required by the collaborating body,
        will be submitted for acceptance and approval of admission. Once approved, the applicant may proceed to
        undertake studies and exams according to the parameters and protocols of the related body.
    </p>

    <p style="text-align:justify;">
        37. Certifications: The courses offered at IICTN come with IICTN certification, while courses from collaborating
        entities come with their respective certifications. Certificates will be issued only after the completion of the
        course and successful completion of the examinations. IICTN will not be responsible or accountable for the
        quality, design, or format of any online or offline documents from the collaborating universities, councils,
        institutions, or private organizations.
    </p>

    <p style="text-align:justify;">
        38. Job Assistance: Indian Institute of Cosmetology, Trichology and Nutrition Private Limited (IICTN) is a
        private body that offers skills-enhancing courses for the beauty, health, and wellness sectors. The said
        institute is neither a college nor a university, nor is it a deemed university. The course fees paid by
        applicants are only for the purpose of learning the course. If, IICTN Staff / Counsellor has promised anything
        apart from mentioned terms, it will not be acknowledged by the institute.
    </p>

    <p style="text-align:justify;">
        Success or failure of the individual in practice, a job, or business is attributable to the individual’s
        capabilities, and IICTN shall not be responsible for any lapses or failures. IICTN is to be indemnified for any
        claim by the applicant or client of any kind whatsoever, as IICTN is opposed to malpractice. The certificates
        are awarded for course learning and are not a licence to practise injectable procedures such as Botox, Fillers,
        and Hair Transplant etc. The procedures must be carried out in accordance with applicable government laws,
        regulations, and guidelines.
    </p>

    <p style="text-align:justify;">
        If an applicant is applying for a job and the institute needs to verify their certificate or if they need
        additional documents such as a marksheet, appraisal letter, or syllabus of the related course, they must pay an
        additional charge of Rs. 10,000/-.
    </p>

    <p style="text-align:justify;">
        39. Documents Verifications: National and international document verification and recruitment agencies have
        different systems, criteria, and parameters, and an institute may not fulfil or meet those criteria. The
        institute will verify the authenticity of the applicant's certificate only via email, and no other documents of
        the institute or company will be shared with the applicant, recruitment agency, or document verification agency
        in accordance with the company's data protection and confidentiality policy. The institute reserves the right to
        deny any request for the same.
    </p>

    <p style="text-align:justify;">
        40. Refund Policy: According to company policy, once admission is granted, it cannot be cancelled. The institute
        strictly adheres to a no-refund policy for any reason. Any study materials in any form including printable,
        digital, books, PPTs, notes, videos, audios, or online and offline lectures once shared with the applicant or
        accessed by the applicant through any method or platform, will be considered delivered. Additionally, if the
        applicant has been added to the course group and a topic or relevant class has commenced, or if the applicant
        has attended even a single offline or online theory or practical class, it will be acknowledged by the
        institute. The terms stated above under the fee section will apply in such cases.
    </p>

    <p style="text-align:justify;">
        Furthermore, fee refund requests will not be addressed or accepted under any circumstances, including epidemics,
        pandemics, civil wars, world wars, government regulations, medical issues affecting the applicant or a family
        member, or the sudden demise of the student, whether occurring at the beginning or at any time during the
        course, even if the duration extends beyond the actual course duration. This policy also applies if the
        institute is required to remain closed due to regulations from central or state governments or local
        authorities, or for any other reason. Therefore, we kindly ask that applicants refrain from creating panic or
        disturbances. If government rules and regulations change for any reason, the institute accepts no responsibility
        or liability for any refunds or compensation for the same.
    </p>

    <p style="text-align:justify;">
        41. Products & Vendors Policy: The institute follows a strict policy not to patronise any brand or supplier. The
        institute’s trainers and consultants are responsible for the courses that applicants have enrolled in. While
        teaching, trainers do use products and machines and talk about the specifications, brand, supplier, etc.
        However, this should not be interpreted as a recommendation or sales pitch by staff acting as an agent on behalf
        of suppliers. Many vendors may indulge in wrongdoing, like providing defective products or machines, or
        promising urgent delivery, a guarantee, a warranty, or an AMC, and may even use staff names to collect any
        advances, etc. Applicants must do their own due diligence and survey before purchasing any product or machine
        and be responsible for their purchase decision. We advise you to be careful and vigilant. Any deal by any
        student with any supplier or representative citing staff connection or recommendation will not be entertained by
        the institute as per the above policies. Institute will not be held accountable or responsible for the same in
        the future.
    </p>

    <p style="text-align:justify;">
        42. Referral Incentives Policy: If an applicant refers other applicants to the institute for courses, the
        institute offers an 8% incentive on actual course fees only to the referrer, or the referrer can take a workshop
        or service at the institute for a 10% incentive. To claim an incentive, the applicant must provide the joiner's
        details well in advance (before the applicant visits or joins us) by email only at info@iictn.org with the
        joiner’s name, contact details, qualifications, and course suggested to the joiner. The reference should be of
        the person who has not yet joined the institute and has come to know about us only through the referrer. Please
        do not refer a colleague or friend who has already enrolled in a course with us and whose referrer has met the
        joinee in our premises or outside, or even visited with the referrer during their own first or other previous or
        later inquiries and enrollment in the institute, as it will not be conceded under our incentive policy. The
        incentive will be given only after the full payment is made by the joiner, and the amount will be given only on
        the course fee amount, excluding 20% tax and levies, admin, and exam fees. The incentive will be given on the
        enrollment of the first fee package. If joined or paid for by the joinee only, the joining of further
        consecutive courses by the reference will not be considered. Incentives for referrals for the entire month are
        credited to the referrer's bank account between the 25th and 30th of the next month, after TDS is deducted. The
        incentive will be cancelled if there is any confusion between the institute, referrer, and reference.
    </p>
    <p style="text-align:justify;">
        43. Data Protection Policy: Applicants are strictly prohibited from using their personal electronic devices such
        as laptops, mobile phones, tablets, cameras, headphones, etc. and are also restricted from recording videos,
        short clips, clicking photographs, taking screenshots, etc. during their online or offline theory classes or
        lectures, practical sessions, or treatments, etc. They are also not allowed to share any data provided by the
        institute, trainers, or management through any online or offline sources. All documents, contact details, study
        materials, notes, PPTs, videos, audios, etc. are copyrighted and the sole property of the institute.
        <li>Applicants are strongly advised and prohibited from sharing or exchanging their personal details like mobile
            numbers, personal email ids, online and offline social media accounts with trainers or lecturers, and from
            inviting any staff of the institute for seminars, workshops, chief guests, personal and client treatment,
            consultation, training, personal and professional ceremonies, the inauguration or opening of their centre,
            or by any other means. As per policy, institute staff are strictly restricted from sharing personal details
            like mobile numbers, online and offline social media platforms, and attending any of the above-mentioned
            events and activities without prior written or email approval from the board members of the institute. If
            the institute finds you indulging in any of the above-mentioned events, activities, knowingly or
            unknowingly, from any open or confidential source, it will be considered anti-organisational activity, and
            the applicant's admission will be cancelled with immediate effect without any refund or compensation; for
            pass-out applicants, their certificate will be cancelled and nullified with immediate effect, and they are
            bound to submit their original certificate to the institute within 48 hours. The institute reserves the
            right to take any appropriate online and offline applicant awareness action as well as legal action against
            the related applicant and staff, and all the losses and legal expenses will be recovered from the applicant.
        </li>
        <li>Furthermore, as per the employee protection policy, applicants are strictly advised to maintain the most
            civilised manners and ethics throughout their entire course(s) duration and are strictly prohibited from
            having any personal relationship or affair with any permanent, contractual, or probationary employee,
            vendor, dealer, business associate, etc., of the Institute / company. If these things happen or are found
            for any reason, the company has the right to cancel your admission and terminate the employment of any
            related employees with immediate effect, without any refund, partial or full, and without any compensation.
            The company has the right to take other appropriate action against both parties.</li>
        <li>If management finds any applicant having wrong conduct, misguiding, misleading, and misbehaving with other
            applicants, trainers, lecturers, or staff as per their own conclusions and/or against the Institute policy
            in any digital, verbal, online, offline, or any other media, they will be immediately removed from the group
            without any prior notice or explanation by the management.</li>
        <li>If the misbehaviour continues, their admission will be revoked with immediate effect, with no refund or
            compensation, and they will be charged the monetary penalty. The institute reserves the right to file a
            defamation case against a related applicant for spoiling the brand name if found necessary, and all legal
            expenses will be borne by applicants.</li>
    </p>
    <p style="text-align:justify;">
        44. Indemnity: Applicants, their family, relatives, friends, or any other associates agree to release, defend,
        indemnify, and hold harmless the company and its directors, board members, staff, employees, trainers,
        lecturers, visiting faculty, vendors, dealers, business associates, and so on, whether permanent, contractual,
        or probationary, from and against any claims, liabilities, damages, losses, expenses, and compensation arising
        out of or in any way related to the use of our resources, methods, practice, services, treatment or any other
        reason whatsoever weather.
    </p>

    <p style="text-align:justify;">
    Note: This is a digital document; the applicant's signature is not required. Acceptance of the terms and conditions will be acknowledged by default when the applicant clicks on the admission form link they agree for the terms & conditions. A copy of the same will be automatically sent to their email address for reference. all terms, conditions, and policies will still apply, and they shall abide by them.
    </p>

    
    <p style="text-align:justify;">
    By-Laws: The applicant agrees to abide by the Terms and Conditions, which are non-negotiable and subject to change without prior notice; any dispute is subject to Mumbai Jurisdiction only.
    </p>
</body>

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