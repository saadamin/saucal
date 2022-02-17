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
     * Process the form and redirect if sucessful.
     */
    function handleForm()
    {
        if (!$this->isFormSubmitted())
            return false;

        // http://php.net/manual/en/function.filter-input-array.php
        $data = filter_input_array(INPUT_POST, array(
            'HighestSalaryRange'   => FILTER_DEFAULT
        ));

        $data = wp_unslash($data);
        $data = array_map('trim', $data);

        // You might also want to more aggressively sanitize these fields
        // By default WordPress will handle it pretty well, based on the current user's "unfiltered_html" capability

        $data['HighestSalaryRange']   = sanitize_text_field($data['HighestSalaryRange']);

        $this->data = $data;

        if (!$this->isNonceValid())
            $this->errors[] = 'Security check failed, please try again.';

        if (intval($data['HighestSalaryRange']) === 0)
            $this->errors[] = 'Please enter a valid number';

        if (!$this->errors) {

            if (update_user_meta(get_current_user_id(), 'HighestSalaryRange', intval($data['HighestSalaryRange']))) {
                // Redirect to avoid duplicate form submissions
                wp_redirect(add_query_arg('success', 'true'));
                exit;
            } else {
                $this->errors[] = 'Whoops, please try again.';
            }
        }
    }

    /**
     * Use output buffering to *return* the form HTML, not echo it.
     *
     * @return string
     */
    function getForm()
    {
    }

    /**
     * Has the form been submitted?
     *
     * @return bool
     */
    function isFormSubmitted()
    {
        return isset($_POST['submitForm']);
    }

    /**
     * Has the form been successfully processed?
     *
     * @return bool
     */
    function isFormSuccess()
    {
        return filter_input(INPUT_GET, 'success') === 'true';
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
