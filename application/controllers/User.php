<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<p class="invalid-feedback">', '</p>');
    }

    /**
     * User Registration
     */
    public function registration()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]', [
            'is_unique' => 'The %s already exists. Please use a different username',
        ]); // Unique Field
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        /*$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email|is_unique[users.email]', [
            'is_unique' => 'The %s already exists. Please use a different email',
        ]);*/ // // Unique Field

        $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|min_length[10]|max_length[10]|numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');
        /*$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');*/

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "User Registration";
            $this->load->view('_Layout/home/header.php', $data); // Header File
            $this->load->view("user/registration");
            $this->load->view('_Layout/home/footer.php'); // Footer File
        }
        else
        {   
            $insert_data = array(
                'username' => $this->input->post('username', TRUE),
                'fullname' => $this->input->post('full_name', TRUE),
                /*'email' => $this->input->post('email', TRUE),*/
                'mobile' => $this->input->post('mobile', TRUE),
                'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
                /*'is_active' => 1,
                'created_at' => time(),
                'update_at' => time(),*/
            );

            /**
             * Load User Model
             */
            $this->load->model('User_model', 'UserModel');
            $result = $this->UserModel->insert_user($insert_data);

            if ($result == TRUE) {

                $this->session->set_flashdata('success_flashData', 'You have registered successfully.');
                redirect('User/registration');

            } else {

                $this->session->set_flashdata('error_flashData', 'Invalid Registration.');
                redirect('User/registration');

            }
        }
    }

    /**
     * User Login
     */
	public function login()
	{
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page_title'] = "User Login";
            $this->load->view('_Layout/home/header.php', $data); // Header File
            $this->load->view("user/login");
            $this->load->view('_Layout/home/footer.php'); // Footer File
        }
        else
        {
            $login_data = array(
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password', TRUE),
            );

            /**
             * Load User Model
             */
            $this->load->model('User_model', 'UserModel');
            $result = $this->UserModel->check_login($login_data);

            if (!empty($result['status']) && $result['status'] === TRUE) {
                /**
                 * Create Session
                 * -----------------
                 * First Load Session Library
                 */
                $session_array = array(
                    'USER_ID'  => $result['data']->user_id,
                    'USER_NAME'  => $result['data']->fullname,
                    'USERNAME'  => $result['data']->username,
                    /*'USER_EMAIL' => $result['data']->email,
                    'IS_ACTIVE'  => $result['data']->is_active,*/
                );
                
                $this->session->set_userdata($session_array);

                $this->session->set_flashdata('success_flashData', 'Login Success');
                redirect('User/Panel');

            } else {
                $this->session->set_flashdata('error_flashData', 'Invalid Username/Password.');
                redirect('User/login');
            }
        }
    }
    
    /**
     * User Logout
     */
    public function logout() {

        /**
         * Remove Session Data
         */
        $remove_sessions = array('USER_ID', 'USERNAME','USER_EMAIL','IS_ACTIVE', 'USER_NAME');
        $this->session->unset_userdata($remove_sessions);

        redirect('User/login');
    }

    /**
     * User Panel
     */
    public function panel() {

        // echo '<pre>';
        // var_dump($_SESSION);
        // die('dfd');
        if (empty($this->session->userdata('USER_ID'))) {
            redirect('user/login');
        }
        $this->load->model('User_model', 'GetUser');
        $id = $this->session->userdata('USER_ID');
        $result['students'] = $this->GetUser->show_students();
        $result['single_student'] = $this->GetUser->show_student_id($id);
        $data['page_title'] = "Welcome to User Panel";
        $this->load->view('_Layout/home/header.php', $data); // Header File
        $this->load->view("user/panel",$result);
        $this->load->view('_Layout/home/footer.php'); // Footer File
    }
    function update_student_id1() 
    {
        $id= $this->input->post('did');
        $data = array(
        'fullname' => $this->input->post('dname'),
        'mobile' => $this->input->post('dmobile'),
        );
        $this->load->model('User_model', 'UpdateUser');
        $this->UpdateUser->update_student_id1($id,$data);
        //$this->show_student_id();
        echo "Data Updated";
    }
    
}