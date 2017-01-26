<?php

/**
 * Logs out on visit and redirects to the login page.
 */
class Logout extends CI_Controller {

    function index()
    {
        $this->session->sess_destroy();

        redirect( base_url() );
    }

}
