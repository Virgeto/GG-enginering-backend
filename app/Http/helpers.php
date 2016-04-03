<?php

if (!function_exists('getPerPage')) {

    /**
     * Get pagination per_page default value.
     *
     * @return integer
     */
    function getPerPage()
    {
        return app()['config']->get('pagination.per_page');
    }
}

if (!function_exists('slug')) {

    /**
     * Create slug from string.
     *
     * @param $string
     * @param string $separator
     * @return string
     */
    function slug($string, $separator = '-')
    {
        $string = mb_strtolower($string, 'UTF-8');

        // Remove all special characters that should not be in the url.
        $string = preg_replace('/[\;\:\'\"\`\~\!\@\#\$\%\^\&\*\(\)\_\=\+\,\.\/\<\>\?\\\]/', '', $string);

        // Replace all spaces with the separator
        $string = preg_replace('/[\s]/', $separator, $string);

        return trim($string, '-');
    }
}