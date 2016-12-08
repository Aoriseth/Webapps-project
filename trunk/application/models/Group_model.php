<?php

class Group_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function addGroup($filter, $caregiverID, $residentIDs) {
        $query = $this->db->query(
			"INSERT INTO `a16_webapps_3`.`groups` (`group_explanation`, `created_by`) "
                . "VALUES ('$filter', '$caregiverID'); ");
                        

        foreach ($residentIDs as $residentID) {
            $this->db->query("INSERT INTO `a16_webapps_3`.`residents_groups` ( `group_id`, `resident_id`) "
                            . "VALUES ((select `id` from `a16_webapps_3`.`groups` "
                            . "WHERE `created_by` = '$caregiverID' AND `group_explanation` = '$filter'), '$residentID') ;"
                            );
        };
    }

    
}


/*

INSERT INTO `a16_webapps_3`.`groups` (`id`, `group_explanation`, `created_by`) VALUES ('', 'filter1', 'c987');

INSERT INTO `a16_webapps_3`.`residents_groups` ( `group_id`, `resident_id`) VALUES
((select `id` from `a16_webapps_3`.`groups` where `created_by` = 'c987' 
AND `group_explanation` = 'filter1'), 'r125') ;

*/