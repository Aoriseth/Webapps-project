<?php

/**
 * Default route / landing page: always redirects to login page or appropriate
 * home page.
 */
class Main extends CI_Controller {

    public function index()
    {
        if ( $this->session->is_logged_in == false ) {
            redirect( base_url() . 'index.php/login' );
        } else {
            redirect( base_url() . 'index.php/' . $this->session->type );
        }
    }

}
