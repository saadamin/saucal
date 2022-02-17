<?php

class HighestSalaryRange
{
    const NONCE_VALUE = 'HighestSalaryRange';
    const NONCE_FIELD = 'HighestSalaryRange_field';

    protected $errors = array();
    protected $data = array();

    function __construct()
    {
        // Listen for the form submit & process before headers output
        add_action('template_redirect',  array($this, 'handleForm'));
    }



    /**
     * Is the nonce field valid?
     *
     * @return bool
     */
    function isNonceValid()
    {
        return isset($_POST[self::NONCE_FIELD]) && wp_verify_nonce($_POST[self::NONCE_FIELD], self::NONCE_VALUE);
    }
}

new HighestSalaryRange;
