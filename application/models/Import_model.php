<?php
/**
 * Description of Import Model
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Import_model extends CI_Model {

    private $_batchImport;

    public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }

    // save data
    public function importData() {
        $data = $this->_batchImport;
        $this->db->insert_batch('import', $data);
    }
    // get data
    public function get_excel() {
        $this->db->select('uploaded_file');
        $this->db->from('import')->where('uploaded_file IS NOT NULL')->group_by('uploaded_file');
        $query = $this->db->get()->result_array();
        return $query;
    }
    // get employee list
    public function employeeList() {
        $this->db->select(array('e.id', 'e.first_name', 'e.contact_no'));
        $this->db->from('import as e');
        $query = $this->db->get();
        return $query->result_array();
    }

     public function get_one_excel($file_name) {
        $this->db->select('*');
        $this->db->from('import')->where('uploaded_file',$file_name);
        $query = $this->db->get()->result_array();
        return $query;
    }

}

?>