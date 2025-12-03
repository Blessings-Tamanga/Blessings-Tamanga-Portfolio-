<?php
class EmailService {
    private $from_email;
    private $from_name;

    public function __construct($config = []) {
        $this->from_email = $config['from_email'] ?? 'blessings.tamanga@example.com';
        $this->from_name = $config['from_name'] ?? 'Blessings E. Tamanga';
    }

    public function sendCustomReply($to_email, $to_name, $subject, $message_content) {
        // HTML email template
        $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { 
                    font-family: 'Arial', sans-serif; 
                    line-height: 1.6; 
                    color: #333; 
                    margin: 0; 
                    padding: 0; 
                }
                .container { 
                    max-width: 600px; 
                    margin: 0 auto; 
                    padding: 20px; 
                    background: #ffffff;
                }
                .header { 
                    background: linear-gradient(135deg, #4a6fa5, #166088); 
                    color: white; 
                    padding: 30px 20px; 
                    text-align: center; 
                    border-radius: 10px 10px 0 0;
                }
                .content { 
                    padding: 30px; 
                    background: #f9f9f9; 
                    border-radius: 0 0 10px 10px;
                }
                .footer { 
                    padding: 20px; 
                    text-align: center; 
                    color: #666; 
                    font-size: 12px;
                    border-top: 1px solid #eee;
                    margin-top: 20px;
                }
                .signature {
                    margin-top: 20px;
                    padding-top: 20px;
                    border-top: 1px solid #eee;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Reply to Your Message</h1>
                    <p>From Blessings E. Tamanga - Portfolio</p>
                </div>
                <div class='content'>
                    <p>Dear <strong>{$to_name}</strong>,</p>
                    
                    <div style='background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #4a6fa5; margin: 20px 0;'>
                        " . nl2br(htmlspecialchars($message_content)) . "
                    </div>
                    
                    <div class='signature'>
                        <p><strong>Best regards,</strong><br>
                        Blessings E. Tamanga<br>
                        Software Engineer & Web Developer<br>
                        Email: blessings.tamanga@example.com<br>
                        Portfolio: your-portfolio-url.com</p>
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent in response to your inquiry through my portfolio website.</p>
                    <p>Please do not reply to this automated message.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        // Headers for HTML email
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=utf-8',
            'From: ' . $this->from_name . ' <' . $this->from_email . '>',
            'Reply-To: ' . $this->from_email,
            'X-Mailer: PHP/' . phpversion(),
            'X-Priority: 1',
            'Importance: High'
        ];

        // Send the email
        $subject = "Re: " . $subject;
        $success = mail($to_email, $subject, $message, implode("\r\n", $headers));
        
        return $success;
    }

    public function sendAutoReply($to_email, $to_name) {
        $subject = "Thank You for Your Message";
        $message_content = "
        Thank you for reaching out through my portfolio website! I have received your message and will review it shortly.
        
        I typically respond to all inquiries within 24-48 hours. If your matter is urgent, please feel free to connect with me on LinkedIn.
        
        Looking forward to speaking with you!
        ";

        return $this->sendCustomReply($to_email, $to_name, $subject, $message_content);
    }
}
?>