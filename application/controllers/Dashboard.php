<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index() {
        // Employee stats
        $total_emp = $this->db->count_all('emp_personal');

        $this->db->where('job_status', 'Permanent');
        $permanent = $this->db->count_all_results('emp_personal');

        $this->db->where('job_status', 'Contract');
        $contract = $this->db->count_all_results('emp_personal');

        // New this month
        $this->db->where('MONTH(created_at)', date('n'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $new_this_month = $this->db->count_all_results('emp_personal');

        // BPS distribution
        $bps_data = $this->db->select('current_bps, COUNT(*) as cnt')
                             ->group_by('current_bps')
                             ->order_by('current_bps', 'ASC')
                             ->get('emp_personal')->result();

        // Recent employees
        $recent = $this->db->select('emp_code, full_name, current_bps, job_status, joining_date, created_at')
                           ->order_by('id','DESC')
                           ->limit(6)
                           ->get('emp_personal')->result();

        // User count (from users table)
        $total_users = $this->db->count_all('users');

        $data['page_title']     = 'HRMIS Dashboard';
        $data['total_emp']      = $total_emp;
        $data['permanent']      = $permanent;
        $data['contract']       = $contract;
        $data['new_this_month'] = $new_this_month;
        $data['bps_data']       = $bps_data;
        $data['recent']         = $recent;
        $data['total_users']    = $total_users;

        $data['main_content'] = $this->load->view('dashboard/home', $data, TRUE);
        $this->load->view('layout/main', $data);
    }
}