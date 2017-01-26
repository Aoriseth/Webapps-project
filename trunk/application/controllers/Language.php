<?php

/**
 * Changes the language stored in session data, returns to previous page when
 * done.
 */
class Language extends CI_Controller {

    public function en()
    {
        $this->session->language = 'english';

        // redirect to previous page
        redirect( $this->agent->referrer() );
    }

    public function fr()
    {
        $this->session->language = 'francais';

        // redirect to previous page
        redirect( $this->agent->referrer() );
    }

    public function nl()
    {
        $this->session->language = 'nederlands';

        // redirect to previous page
        redirect( $this->agent->referrer() );
    }

}
