<?php 

class User_model extends CI_Model {

    protected $User_table_name = "users";

    /**
     * Insert User Data in Database
     * @param: {array} userData
     */
    public function insert_user($userData) {
        return $this->db->insert($this->User_table_name, $userData);
    }

    /**
     * Check User Login in Database
     * @param: {array} userData
     */
    public function check_login($userData) {

        /**
         * First Check Email is Exists in Database
         */
        $query = $this->db->get_where($this->User_table_name, array('username' => $userData['username']));
        if ($this->db->affected_rows() > 0) {

            $password = $query->row('password');

            /**
             * Check Password Hash 
             */
            if (password_verify($userData['password'], $password) === TRUE) {

                /**
                 * Password and Email Address Valid
                 */
                return [
                    'status' => TRUE,
                    'data' => $query->row(),
                ];

            } else {
                return ['status' => FALSE,'data' => FALSE];
            }

        } else {
            return ['status' => FALSE,'data' => FALSE];
        }
    }
    public function show_students(){
        $query = $this->db->get('users');
        $query_result = $query->result();
        return $query_result;
    }
    public function show_student_id($data){
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_id', $data);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    // Update Query For Selected Student
    public function update_student_id1($id,$data){
        $this->db->where('user_id', $id);
        $this->db->update('users', $data);
    }
}
