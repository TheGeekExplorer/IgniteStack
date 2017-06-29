<?php namespace igniteStack\config\Core\Communications;

use igniteStack\Interfaces\BaseConfiguration;


class EmailConfiguration extends BaseConfiguration {
	public static $default_to       = 'root@localhost';
    public static $default_name     = 'system user';
    public static $default_from     = 'no-reply';
    public static $default_reply_to = 'no-reply';
    public static $default_subject  = 'Message from IgniteStack';
    public static $default_message  = 'This is a test email from the IgniteStack platform.<br><br>';
    public static $default_template = 'Emails/StandardResponse';

    public static $nominated_recipients = [
        'mark.greenall@booker.co.uk',
        'tom.allen@booker.co.uk',
    ];
}
