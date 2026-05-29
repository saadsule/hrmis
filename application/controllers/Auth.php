<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('session');
    }

    public function index() {
        // Already logged in → go to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            redirect('auth');
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->where('username', $username)
                 ->get('users')
                 ->row();

        if ($user && md5($password) == $user->password) {

            // Insert access log
            $this->db->insert('user_access_log', [
                'user_id' => $user->user_id,
                'login_time' => date('Y-m-d H:i:s'),
                'ip_address' => $this->input->ip_address(),
            ]);

            $access_log_id = $this->db->insert_id();

            // Set session
            $this->session->set_userdata([
                'logged_in'     => TRUE,
                'user_id'       => $user->id,
                'username'      => $user->username,
                'full_name'     => $user->full_name,
                'role'          => $user->role,
                'access_log_id' => $access_log_id,
            ]);

            redirect('dashboard');

        } else {
            $this->session->set_flashdata('error', 'Invalid username or password.');
            redirect('auth');
        }
    }

    public function logout() {
        $access_log_id = $this->session->userdata('access_log_id');
        if ($access_log_id) {
            $this->db->where('id', $access_log_id)
                     ->update('user_access_log', ['logout_time' => date('Y-m-d H:i:s')]);
        }
        $this->session->sess_destroy();
        redirect('auth');
    }
}