<?php namespace igniteStack\System\Communications;

use igniteStack\config\Core\Communications\EmailConfiguration;
use igniteStack\System\ErrorHandling\Exception;


class Email
{
    /**
     * Send Email to Recipient and CCs if defined
     * @param $to
     * @param $subject
     * @param $message
     * @param $headers
     * @return bool
     */
    final public static function send ($to, $subject, $message, $headers) {
        # Send email
        if (!mail($to, $subject, $message, $headers))
            return false;
        return true;
    }


    /**
     * Inserts the content into the HTML template
     * @param $EMAIL
     * @return mixed
     */
    final public static function insert_content ($EMAIL) {
        $EMAIL['html'] = str_replace('{{{NAME}}}',    $EMAIL['name'],    $EMAIL['html']);    # Name
        $EMAIL['html'] = str_replace('{{{MESSAGE}}}', $EMAIL['message'], $EMAIL['html']);    # Message
        return $EMAIL;
    }


    /**
     * If some fields do not have content specified then it will load the default values
     * from the configuration in /config/Core/Communications/
     * @param bool $to
     * @param bool $name
     * @param bool $from
     * @param bool $reply_to
     * @param bool $subject
     * @param bool $message
     * @param bool $template
     * @return mixed
     */
    final public static function determine_content ($to=false, $name=false, $from=false, $reply_to=false, $subject=false, $message=false, $template=false) {
        $email['to']        = ( !$to       ? EmailConfiguration::get('default_to')       : $to       );
        $email['name']      = ( !$name     ? EmailConfiguration::get('default_name')     : $name     );
        $email['from']      = ( !$from     ? EmailConfiguration::get('default_from')     : $from     );
        $email['reply_to']  = ( !$reply_to ? EmailConfiguration::get('default_reply_to') : $reply_to );
        $email['subject']   = ( !$subject  ? EmailConfiguration::get('default_subject')  : $subject  );
        $email['message']   = ( !$message  ? EmailConfiguration::get('default_message')  : $message  );
        $email['template']  = ( !$template ? EmailConfiguration::get('default_template') : $template );
        return $email;
    }


    /**
     * Build the CC list from a given array [tuple]
     * @param $recipients
     * @return string
     */
    final public static function build_cc_list ($recipients) {
        $cc='';
        if (!empty($recipients)) {
            foreach ($recipients as $person) {
                $cc .= "$person, ";
            }
            $cc = rtrim($cc, ', ');
        }
        return $cc;
    }


    /**
     * Builds the email headers
     * @param $from
     * @param $reply_to
     * @param $cc
     * @return string
     */
    final public static function build_email_headers ($from, $reply_to, $cc='') {
        # Set sender information
        $headers  = "From: $from\r\n";
        $headers .= "Reply-To: $reply_to\r\n";

        # Insert CC list if set
        if (!empty($cc))
            $headers .= "Cc: $cc\r\n";

        # Mime and Content Type
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";

        # Return to the requesting "send" function
        return $headers;
    }


    /**
     * Loads the specified template
     * @param $template
     * @return string
     */
    final public static function load_template ($template) {
        $HTML  = file_get_contents("../app/Views/$template.html");
        if (empty($HTML))
            Exception::cast("Could not load the email template '$template'.", 500);
        return $HTML;
    }


    /**
     * Escapes all HTML from given Variable
     * @param string $v
     * @return string
     */
    final public static function sanitise_html_from_variable ($v) {
    	$sanitised = filter_var ( $v, FILTER_SANITIZE_SPECIAL_CHARS);
        return $sanitised;
    }
}
