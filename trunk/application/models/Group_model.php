<?php

class Group_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function addGroup($filter, $caregiverID, $residentIDs) {
        /*$query = $this->db->query(
                    "INSERT INTO `a16_webapps_3`.`groups` (`group_explanation`, `created_by`) "
                    . "VALUES ('$filter', '$caregiverID');");*/
                    /*. "SELECT '$filter', '$caregiverID' "
                    . "FROM `a16_webapps_3`.`groups` "
                    . "WHERE NOT EXISTS ( "
                    . "SELECT * FROM `a16_webapps_3`.`groups` WHERE `group_explanation` = '$filter'"
                    );*/
                
        $array = array(
            'group_explanation' => $filter,
            'created_by' => $caregiverID,
            'created_on' => date('Y-m-d H:i:s')
        );
        $this->db->insert('a16_webapps_3.groups', $array);
         

        foreach ($residentIDs as $residentID) {
            $this->db->query("INSERT INTO `a16_webapps_3`.`residents_groups` ( `group_id`, `resident_id`) "
                . "VALUES ((select `id` from `a16_webapps_3`.`groups` "
                . "WHERE `created_by` = '$caregiverID' AND `group_explanation` = '$filter'), '$residentID') ;"
                );
        };
    }

    function getGroups(){
        $query = $this->db->query(
                "SELECT `group_id`, `resident_id` "
                . "FROM `a16_webapps_3`.`residents_groups`"
        );
        return $query->result();
    }
    
}


/*

INSERT INTO `a16_webapps_3`.`groups` (`id`, `group_explanation`, `created_by`) VALUES ('', 'filter1', 'c987');

INSERT INTO `a16_webapps_3`.`residents_groups` ( `group_id`, `resident_id`) VALUES
((select `id` from `a16_webapps_3`.`groups` where `created_by` = 'c987' 
AND `group_explanation` = 'filter1'), 'r125') ;

*/