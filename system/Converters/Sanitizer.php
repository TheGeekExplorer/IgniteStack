<?php namespace igniteStack\System\Converters;


class Sanitizer {

    /**
     * Sanitizes urls into non malicious path
     * @param $u
     * @return mixed|string
     */
    final public static function sanitizeURL ($u)
    {
        // Decode URL
        $u = (string) urldecode($u);

        // Replace malicious chars
        $u = str_replace('../', '', $u);
        $u = str_replace('./', '', $u);

        return $u;
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
