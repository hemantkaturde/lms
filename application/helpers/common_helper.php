<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';

/**
 * This function is used to print the content of any data
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * This function used to get the CI instance
 */
if(!function_exists('get_instance'))
{
    function get_instance()
    {
        $CI = &get_instance();
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}

/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}

/**
 * This method used to get current browser agent
 */
if(!function_exists('getBrowserAgent'))
{
    function getBrowserAgent()
    {
        $CI = get_instance();
        $CI->load->library('user_agent');

        $agent = '';

        if ($CI->agent->is_browser())
        {
            $agent = $CI->agent->browser().' '.$CI->agent->version();
        }
        else if ($CI->agent->is_robot())
        {
            $agent = $CI->agent->robot();
        }
        else if ($CI->agent->is_mobile())
        {
            $agent = $CI->agent->mobile();
        }
        else
        {
            $agent = 'Tanımlanamadı';
        }

        return $agent;
    }
}

if(!function_exists('setProtocol'))
{
    function setProtocol()
    {
        $CI = &get_instance();
                    
        $CI->load->library('email');
        
        $config['protocol'] = PROTOCOL;
        $config['mailpath'] = MAIL_PATH;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['smtp_user'] = SMTP_USER;
        $config['smtp_pass'] = SMTP_PASS;
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        
        $CI->email->initialize($config);
        
        return $CI;
    }
}

if(!function_exists('emailConfig'))
{
    function emailConfig()
    {
        $CI->load->library('email');
        $config['protocol'] = PROTOCOL;
        $config['smtp_host'] = SMTP_HOST;
        $config['smtp_port'] = SMTP_PORT;
        $config['mailpath'] = MAIL_PATH;
        $config['charset'] = 'UTF-8';
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $config['wordwrap'] = TRUE;
    }
}

if(!function_exists('resetPasswordEmail'))
{
    function resetPasswordEmail($detail)
    {
        $data["data"] = $detail;
        // pre($detail);
        // die;
        
        $CI = setProtocol();        
        
        $CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->subject("Reset Password");
        $CI->email->message($CI->load->view('email/resetPassword', $data, TRUE));
        $CI->email->to($detail["email"]);
        $status = $CI->email->send();
        
        return $status;
    }
}

if(!function_exists('setFlashData'))
{
    function setFlashData($status, $flashMsg)
    {
        $CI = get_instance();
        $CI->session->set_flashdata($status, $flashMsg);
    }
}

/**
 * This method used to convert headlines to seo friendly links
 */
if(!function_exists('sef'))
{
    function sef($str, $options = array())
    {
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => true
    );
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
    $str = trim($str, $options['delimiter']);
    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }   
}

if(!function_exists(('isFieldEmpty')))
{
    function isFieldEmpty($arr,$columnsArr,$mandateFields = array())
    {
        $emptyFields = "";
        foreach ($arr as $key => $value) 
        {
            $value = trim($value);
            if(!empty($mandateFields)){
                if(in_array($key, $mandateFields)){
                    if (empty($value))
                    {
                        $emptyFields.= $columnsArr[$key].",";
                    }    
                }
            }else{
                if (empty($value))
                {
                    $emptyFields.= $columnsArr[$key].",";
                }
            }
        }
        $emptyFields = rtrim($emptyFields,",");
        return $emptyFields;
    }
}


if(!function_exists(('sendmail')))
{
    function sendmail($to,$subject,$body,$email_name,$attachmentList)
    {

           $mail = new PHPMailer(true);
            try {
                // $mail->SMTPDebug = 2;                                      
                // $mail->isSMTP();        
                // //$mail->SMTPKeepAlive = true;
                                   
                // $mail->Host       = EMAIL_SMTP_HOST;                   
                // $mail->SMTPAuth   = EMAIL_SMTP_AUTH;                            
                // $mail->Username   = EMAIL_USERNAME;                
                // $mail->Password   = EMAIL_PASSWORD;                       
                // $mail->SMTPSecure = EMAIL_SECURE;                             
                // $mail->Port       = EMAIL_SMTP_PORT; 
            
                // $mail->setFrom(EMAIL_USERNAME, $email_name);          
                // $mail->addAddress($to);
                // //$mail->addAddress('receiver2@gfg.com', 'Name');
            
                // $mail->isHTML(true);                                 
                // $mail->Subject = $subject;
                // $mail->Body    = $body;
                // //$mail->AltBody = 'Body in plain text for non-HTML mail clients';
                // $mail->send();

                // if($mail->send()){
                //     return true;
                // }else{
                //     return false;
                // }
                //return true;
                //echo "Mail has been sent successfully!";


                // $mail = new PHPMailer();
                // //Tell PHPMailer to use SMTP
                // $mail->isSMTP();
                // //Enable SMTP debugging
                // // 0 = off (for production use)
                // // 1 = client messages
                // // 2 = client and server messages
                // $mail->SMTPDebug = 2;
                // $mail->DKIM_domain = "127.0.0.1";
                // //Ask for HTML-friendly debug output
                // // $mail->Debugoutput = "html";
                // //Set the hostname of the mail server
                // $mail->Host = "smtp.gmail.com"; 
                // // Set the SMTP port number - likely to be 25, 465 or 587
                // $mail->Port = 587; 
                // // Whether to use SMTP authentication
                // $mail->SMTPAuth = true; 
                // // Username to use for SMTP authentication
                // $mail->Username = "hemantk@aeondigital.in"; 
                // // Password to use for SMTP authentication 
                // $mail->Password = "hemant@001";
                // $mail->SMTPSecure = "ssl"; //Set who the message is to be sent from 
                // $mail->setFrom('hemantk@aeondigital.in', 'IICTN'); //Set an alternative reply-to address
                // // $mail->addReplyTo('replyto@example.com', 'First Last');
                // // Set who the message is to be sent to
                // $mail->addAddress($to, "HEMR");
                // // Set the subject line
                // $mail->isHTML(true);              
                // $mail->Subject = $subject; 
                // // Read an HTML message body from an external file, convert referenced images to embedded, 
                // // convert HTML into a basic plain-text alternative body 
                // // $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
                // $mail->Body =$body;
                // // Replace the plain text body with one created manually 
                // // $mail->AltBody = 'This is a plain-text message body'; 
                // // Attach an image file 
                // // $mail->addAttachment('images/phpmailer_mini.png'); 
                // // send the message, check for errors
                // // if (!$mail->send()) {
                // //     echo "Mailer Error: " . $mail->ErrorInfo;
                // // } else {
                // //     echo "Message sent!";
                // // } 

                //  if($mail->send()){
                //      return true;
                //  }else{
                //      return false;
                //  }


                // if (!$mail->send()) {
                //     echo "Mailer Error: " . $mail->ErrorInfo;
                // } else {
                //     echo "Message sent!";
                // } 


                // $mail->SMTPDebug = 0;                      // Enable verbose debug output
                // $mail->isSMTP();                           // Set mailer to use SMTP
                // $mail->Host       = 'smtp.gmail.com';      // Specify main and backup SMTP servers
                // $mail->SMTPAuth   = true;                  // Enable SMTP authentication
                // $mail->Username   = 'hemantk@aeondigital.in'; // Your Google Workspace email address
                // $mail->Password   = 'hemant@001';       // Your Google Workspace email password
                // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` for SSL
                // $mail->Port       = 587;                   // TCP port to connect to
            
                // //Recipients
                // $mail->setFrom('hemantk@aeondigital.in', 'Your Name');
                // $mail->addAddress('hemantkaturde123@gmail.com', 'Recipient Name');  // Add a recipient
            
                // // Content
                // $mail->isHTML(true);                        // Set email format to HTML
                // $mail->Subject = 'Here is the subject';
                // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                // $mail->send();

                return true;

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
   } 
}



if(!function_exists(('multi_attach_mail')))
{
    function multi_attach_mail($to, $subject, $message, $senderEmail, $senderName, $files = array())
    {
    // Sender info  
    $from = $senderName." <".$senderEmail.">";  
    $headers = "From: $from"; 
 
    // Boundary  
    $semi_rand = md5(time());  
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
    // Headers for attachment  
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";  
 
    // Multipart boundary  
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
    "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";  
 
    // Preparing attachment 
    if(!empty($files)){ 
        for($i=0;$i<count($files);$i++){ 
            if(is_file($files[$i])){ 
                $file_name = basename($files[$i]); 
                $file_size = filesize($files[$i]); 
                 
                $message .= "--{$mime_boundary}\n"; 
                $fp =    @fopen($files[$i], "rb"); 
                $data =  @fread($fp, $file_size); 
                @fclose($fp); 
                $data = chunk_split(base64_encode($data)); 
                $message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .  
                "Content-Description: ".$file_name."\n" . 
                "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .  
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
            } 
        } 
    } 
     
    $message .= "--{$mime_boundary}--"; 
    $returnpath = "-f" . $senderEmail; 
     
    // Send email 
    $mail = mail($to, $subject, $message, $headers, $returnpath);  
     
    // Return true if email sent, otherwise return false 
    if($mail){ 
        return true; 
    }else{ 
        return false; 
    } 
  }
}


if(!function_exists(('sendwhatsapp')))
{
    function sendwhatsapp($all_course_name,$Brochure_link,$Syllabus,$url,$mobile,$whatsaptype)
    {
            try {
                 if($whatsaptype=='markating_material'){ 

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.wanotifier.com/api/v1/notifications/hWsHNm4UAH?key=rvs0h0gPYwSr9m8jbmAzdvGT9UDz8J',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "data": {
                            "body_variables": [
                                "'.$all_course_name.'",
                                "'.$Brochure_link.'",
                                "'.$Syllabus.'"
                            ]
                        },
                        "recipients": [
                            {
                                "whatsapp_number": "'.$mobile.'",
                                "first_name": "John",
                                "last_name": "Doe",
                                "attributes": {
                                    "custom_attribute_1": "Value 1",
                                    "custom_attribute_2": "Value 2",
                                    "custom_attribute_3": "Value 3"
                                },
                                "lists": [
                                    "Default"
                                ],
                                "tags": [
                                    "new lead",
                                    "notification sent"
                                ],
                                "replace": false
                            }
                        ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Cookie: PHPSESSID=cdnviv7ne4n05g6d740t02aqhq'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    //echo $response;  
                 }

                 if($whatsaptype=='payment_link'){ 
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.wanotifier.com/api/v1/notifications/nX1kZg3h3H?key=rvs0h0gPYwSr9m8jbmAzdvGT9UDz8J',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "data": {
                            "body_variables": [
                                "'.$all_course_name.'",
                                "'.$url.'"
                            ]
                        },
                        "recipients": [
                            {
                                "whatsapp_number": "'.$mobile.'",
                                "first_name": "John",
                                "last_name": "Doe",
                                "attributes": {
                                    "custom_attribute_1": "Value 1",
                                    "custom_attribute_2": "Value 2",
                                    "custom_attribute_3": "Value 3"
                                },
                                "lists": [
                                    "Default"
                                ],
                                "tags": [
                                    "new lead",
                                    "notification sent"
                                ],
                                "replace": false
                            }
                        ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Cookie: PHPSESSID=tdsrj23llm8jvqlsc81bocgvoh'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    //echo $response;
                 }

                 if($whatsaptype=='admission_link'){ 
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://app.wanotifier.com/api/v1/notifications/vl6vvKLdGE?key=rvs0h0gPYwSr9m8jbmAzdvGT9UDz8J',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "data": {
                            "body_variables": [
                                "'.$url.'"
                            ]
                        },
                        "recipients": [
                            {
                                "whatsapp_number": "'.$mobile.'",
                                "first_name": "John",
                                "last_name": "Doe",
                                "attributes": {
                                    "custom_attribute_1": "Value 1",
                                    "custom_attribute_2": "Value 2",
                                    "custom_attribute_3": "Value 3"
                                },
                                "lists": [
                                    "Default"
                                ],
                                "tags": [
                                    "new lead",
                                    "notification sent"
                                ],
                                "replace": false
                            }
                        ]
                    }',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Cookie: PHPSESSID=tdsrj23llm8jvqlsc81bocgvoh'
                    ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    //echo $response;
                 }

            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$e}";
            }
   } 
}


if (!function_exists('setContentLength'))
{
    //Add content length header to response and echo it
	function setContentLength($data) 
	{
		$returnData = json_encode($data);
		header('Content-Length: '.strlen($returnData)); 
		echo $returnData;
		exit;	
	}	
}


if (!function_exists(('uniqueAlphaNumericString')))
{
	/*
	Function to generate unique alphanumeric string, also can be used for OTP generation
	*/
	function uniqueAlphaNumericString($l = 4) 
	{
		return substr(md5(uniqid(rand(1,6))), 0, $l);
	}
}

if (!function_exists(('logInformationcollection')))
{
	/* 
	Function to save journey logs
	*/
	function logInformationcollection($userid = '', $username = '', $mobile_number = '', $action_type = '', $usertype = '', $information = '', $data = '')
	{
		$ci = &get_instance();
		$datatoadd = array('userid'=>$userid, 'username' => $username, 'mobile_number' => $mobile_number, 'action_type' => $action_type, 'usertype' => $usertype, 'information' => $information, 'data'=>json_encode($data), 'added_date' => DATEANDTIME);
		savelogInformation($datatoadd);
		return true;
	}
}

if (!function_exists(('savelogInformation')))
{
	/* 
	Function to save journey logs
	*/
	function savelogInformation($datatoadd = array())
	{
		$ci = &get_instance();
        $ci->db->insert(TBL_ACTIVITY_APP_LOG, $datatoadd);

	}
}


if (!function_exists('validateServiceRequest'))
{

	function validateServiceRequest() //Authenticate user
	{
        print_r($_SERVER['REQUEST_METHOD']);
        exit;
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {


					//echo '<pre>';print_r($_SERVER);echo '</pre>'; exit;
					if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
						exit;
					} elseif (isset($_SERVER['HTTP_AUTHTOKEN']) && trim($_SERVER['HTTP_AUTHTOKEN']) != '') {

                        print_r($_SERVER['HTTP_AUTHTOKEN']);
                        exit;
						//$keys = authtokenDecrypt($_SERVER['HTTP_AUTHTOKEN']);
						$keys = explode(':',$_SERVER['HTTP_AUTHTOKEN']);
						if(isset($keys[0],$keys[1])) {
							$ci = &get_instance();
							/************USER*************/
							$ci->db->select('BaseTbl.userId,BaseTbl.user_flag,BaseTbl.email, BaseTbl.password, BaseTbl.name,BaseTbl.status,BaseTbl.roleId, Roles.role,Roles.access,BaseTbl.profile_pic,BaseTbl.username,BaseTbl.mobile');
                            $ci->db->from('tbl_users as BaseTbl');
                            $ci->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
							$ci->db->where('BaseTbl.authtoken', trim($keys[0]));
							$ci->db->where('BaseTbl.userId', trim($keys[1]));
							//$ci->db->where(TBL_USER.'.status', 1);
							$query = $ci->db->get(TBL_USER);
							$getUsers = $query->result_array();
							
							if ($query->num_rows() > 0) {
								return $getUsers[0];
							}  else {
								accessUnAuthorized();
							}
						} else {
							accessUnAuthorized();
						}
					} else {
						accessUnAuthorized();
					}
		}else{

			validateMethod();
		}			
	}	
}


if (!function_exists('accessUnAuthorized'))
{
	function accessUnAuthorized() //Response for unauthorized access
	{
		header('HTTP/1.0 401 Unauthorized');
		$returnData = json_encode(array('status'=> 'Failure','message'=>'Authorization failed'));
		//header('Content-Length: '.strlen($returnData)); 
		//echo $returnData;
		setContentLength(array('status'=> 'Failure','message'=>'Authorization failed'));
		exit; 	
		//setContentLength(array('status'=> 'Failure','message'=>'Authorization failed'));
	}	
}


if (!function_exists('validateMethod'))
{
	function validateMethod() //Response for unauthorized access
	{
		header("HTTP/1.1 500 Internal Server Error");
		//header('HTTP/1.0 401 Unauthorized');
		$returnData = json_encode(array('status'=> 'Failure','message'=>'Check Request-response Method'));
		//header('Content-Length: '.strlen($returnData)); 
		//echo $returnData;
		setContentLength(array('status'=> 'Failure','message'=>'Check Request-response Method'));
		exit; 	
		//setContentLength(array('status'=> 'Failure','message'=>'Authorization failed'));
	}	
}


?>