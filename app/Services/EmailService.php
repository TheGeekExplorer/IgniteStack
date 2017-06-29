<?php namespace igniteStack\app\Services;

use igniteStack\config\Core\Communications\EmailConfiguration;
use igniteStack\System\Communications\Email;
use igniteStack\app\Models\adverts;
use igniteStack\app\Models\pages;


class EmailService
{


    /**
     * Send to Recipient and Nominated Recipients in Config
     * @param bool $to
     * @param bool $name
     * @param bool $from
     * @param bool $reply_to
     * @param bool $subject
     * @param bool $message
     * @param bool $template
     * @return bool
     */
    final public static function send_include_nominated ($to=false, $name=false, $from=false, $reply_to=false, $subject=false, $message=false, $template=false)
    {
        # If some fields are empty then load default values from config
        $EMAIL = Email::determine_content ($to, $name, $from, $reply_to, $subject, $message, $template);

        # Set headers
        $EMAIL['headers'] = Email::build_email_headers (
            $EMAIL['from'], $EMAIL['reply_to'],                    # Sender information
            Email::build_cc_list (                                 # Nominated senders list (people who should be copied in)
                EmailConfiguration::get('nominated_recipients')    # Get the list of nominated recipients
            )
        );

        # Read in Template
        $EMAIL['html']  = Email::load_template($EMAIL['template']);

        # Insert content into template
        $EMAIL = Email::insert_content ($EMAIL);

        # Send Email
        if (!Email::send($EMAIL['to'], $EMAIL['subject'], $EMAIL['html'], $EMAIL['headers']))
            return false;
        return true;
    }


    /**
     * Send an HTML Email to recipient only (doesn't send to nominated recipients in config)
     * @param bool $to
     * @param bool $name
     * @param bool $from
     * @param bool $reply_to
     * @param bool $subject
     * @param bool $message
     * @param bool $template
     * @return bool
     */
    final public static function send_exclude_nominated ($to=false, $name=false, $from=false, $reply_to=false, $subject=false, $message=false, $template=false)
    {
        # If some fields are empty then load default values from config
        $EMAIL = Email::determine_content ($to, $name, $from, $reply_to, $subject, $message, $template);

        # Set headers
        $EMAIL['headers'] = Email::build_email_headers (
            $EMAIL['from'], $EMAIL['reply_to']                     # Sender information
        );

        # Read in Template
        $EMAIL['html']  = Email::load_template($EMAIL['template']);

        # Insert content into template
        $EMAIL = Email::insert_content ($EMAIL);

        # Send email
        if (!mail($EMAIL['to'], $EMAIL['subject'], $EMAIL['html'], $EMAIL['headers']))
            return false;
        return true;
    }

}

/**
 * NOTES / COMMENTS
 *
 * 1.1    PDO outputs fields as double:  name field, and then a number copy - so "userid" column would exist twice in the output, as "userid" and then as "0"
 *
 */