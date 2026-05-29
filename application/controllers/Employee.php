<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['session', 'upload', 'form_validation']); // ← add form_validation here
        // Auth guard
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    // ── Helpers ─────────────────────────────────────────────────────────────
    private function _json($success, $message = '', $data = []) {
        $this->output->set_content_type('application/json')
                     ->set_output(json_encode(compact('success','message','data')));
    }

    private function _is_admin() {
        return in_array($this->session->userdata('role'), [1, 'admin']);
    }

    // ════════════════════════════════════════════════════════════════════════
    //  EMPLOYEE LIST
    // ════════════════════════════════════════════════════════════════════════
    public function index() {
        $search = $this->input->get('search');
        $data['employees']   = $this->Employee_model->get_all_employees($search);
        $data['search']      = $search;
        $data['page_title']  = 'Employee Records';
        $data['main_content'] = $this->load->view('employee/list', $data, TRUE);
        $this->load->view('layout/main', $data);
    }

    // ════════════════════════════════════════════════════════════════════════
    //  ADD EMPLOYEE (Step 1: Personal)
    // ════════════════════════════════════════════════════════════════════════
    public function add() {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('full_name',  'Full Name',   'required|min_length[3]');
            $this->form_validation->set_rules('cnic',       'CNIC',        'required|exact_length[15]');
            $this->form_validation->set_rules('dob',        'Date of Birth','required');
            $this->form_validation->set_rules('contact_no', 'Contact No',  'required|exact_length[11]');
            $this->form_validation->set_rules('employee_no','Employee No', 'required');
            $this->form_validation->set_rules('joining_date','Joining Date','required');

            if ($this->form_validation->run()) {
                $fields = [
                    'emp_code','gender','full_name','father_name','cnic','dob','marital_status',
                    'district_domicile','postal_address','residential_address','residential_city',
                    'permanent_address','permanent_city','contact_no','email','nationality',
                    'passport_no','professional_reg_no','employee_no','job_status','joining_date',
                    'actual_designation','sanctioned_designation','current_bps','mode_of_appointment',
                    'quota','cadre_value','category','seniority_list_no','ddo_number','ddo_description'
                ];
                $insert = [];
                foreach ($fields as $f) {
                    $insert[$f] = $this->input->post($f);
                }
                $insert['emp_code'] = $this->Employee_model->generate_emp_code();

                $emp_id = $this->Employee_model->save_personal($insert);
                $this->session->set_flashdata('success', 'Personal record saved. Continue filling remaining sections.');
                redirect("employee/profile/{$emp_id}");
            } else {
                $this->session->set_flashdata('error', validation_errors());
                redirect('employee/add');
            }
        }

        $data['page_title']  = 'Add New Employee';
        $data['emp_code']    = $this->Employee_model->generate_emp_code();
        $data['main_content'] = $this->load->view('employee/add', $data, TRUE);
        $this->load->view('layout/main', $data);
    }

    // ════════════════════════════════════════════════════════════════════════
    //  EMPLOYEE PROFILE (all sections)
    // ════════════════════════════════════════════════════════════════════════
    public function profile($emp_id = NULL) {
        if (!$emp_id) redirect('employee');

        $personal = $this->Employee_model->get_personal($emp_id);
        if (!$personal) show_404();

        $data['personal']    = $personal;
        $data['education']   = $this->Employee_model->get_education($emp_id);
        $data['specialities']= $this->Employee_model->get_specialities($emp_id);
        $data['trainings']   = $this->Employee_model->get_trainings($emp_id);
        $data['spouses']     = $this->Employee_model->get_spouses($emp_id);
        $data['children']    = $this->Employee_model->get_children($emp_id);
        $data['postings']    = $this->Employee_model->get_postings($emp_id);
        $data['sections']    = $this->Employee_model->get_section_status($emp_id);
        $data['emp_id']      = $emp_id;
        $data['page_title']  = 'Employee Profile — ' . $personal->full_name;
        $data['main_content'] = $this->load->view('employee/profile', $data, TRUE);
        $this->load->view('layout/main', $data);
    }

    // ════════════════════════════════════════════════════════════════════════
    //  EDIT PERSONAL
    // ════════════════════════════════════════════════════════════════════════
    public function edit_personal($emp_id) {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $fields = [
                'gender','full_name','father_name','cnic','dob','marital_status',
                'district_domicile','postal_address','residential_address','residential_city',
                'permanent_address','permanent_city','contact_no','email','nationality',
                'passport_no','professional_reg_no','employee_no','job_status','joining_date',
                'actual_designation','sanctioned_designation','current_bps','mode_of_appointment',
                'quota','cadre_value','category','seniority_list_no','ddo_number','ddo_description'
            ];
            $update = [];
            foreach ($fields as $f) $update[$f] = $this->input->post($f);
            $this->Employee_model->update_personal($emp_id, $update);
            $this->session->set_flashdata('success', 'Personal information updated successfully.');
            redirect("employee/profile/{$emp_id}");
        }

        $data['emp']         = $this->Employee_model->get_personal($emp_id);
        $data['page_title']  = 'Edit Personal Record';
        $data['main_content'] = $this->load->view('employee/edit_personal', $data, TRUE);
        $this->load->view('layout/main', $data);
    }

    // ════════════════════════════════════════════════════════════════════════
    //  DELETE EMPLOYEE
    // ════════════════════════════════════════════════════════════════════════
    public function delete($emp_id) {
        if (!$this->_is_admin()) {
            $this->session->set_flashdata('error', 'Access denied.');
            redirect('employee');
        }
        $this->Employee_model->delete_personal($emp_id);
        $this->session->set_flashdata('success', 'Employee record deleted.');
        redirect('employee');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — ADD EDUCATION ROW
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_education() {
        $emp_id = $this->input->post('emp_id');
        $data = [
            'level'           => $this->input->post('level'),
            'board_university'=> $this->input->post('board_university'),
            'ending_month'    => $this->input->post('ending_month'),
            'ending_year'     => $this->input->post('ending_year'),
            'total_gpa'       => $this->input->post('total_gpa') ?: NULL,
            'obtained_gpa'    => $this->input->post('obtained_gpa') ?: NULL,
            'total_marks'     => $this->input->post('total_marks') ?: NULL,
            'obtained_marks'  => $this->input->post('obtained_marks') ?: NULL,
            'percentage'      => $this->input->post('percentage') ?: NULL,
            'is_draft'        => 1,
        ];
        $id = $this->Employee_model->add_education($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Education record added.', $data);
    }

    public function ajax_delete_education() {
        $id = $this->input->post('id');
        $this->Employee_model->delete_education($id);
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — SPECIALITY
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_speciality() {
        $emp_id = $this->input->post('emp_id');
        $data = ['speciality' => $this->input->post('speciality'), 'is_draft' => 1];
        $id = $this->Employee_model->add_speciality($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Added.', $data);
    }

    public function ajax_delete_speciality() {
        $this->Employee_model->delete_speciality($this->input->post('id'));
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — TRAINING
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_training() {
        $emp_id = $this->input->post('emp_id');
        $data = [
            'training_name' => $this->input->post('training_name'),
            'institute'     => $this->input->post('institute'),
            'start_month'   => $this->input->post('start_month'),
            'start_year'    => $this->input->post('start_year'),
            'end_month'     => $this->input->post('end_month'),
            'end_year'      => $this->input->post('end_year'),
            'duration_days' => $this->input->post('duration_days') ?: NULL,
            'is_draft'      => 1,
        ];
        $id = $this->Employee_model->add_training($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Training added.', $data);
    }

    public function ajax_delete_training() {
        $this->Employee_model->delete_training($this->input->post('id'));
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — SPOUSE
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_spouse() {
        $emp_id = $this->input->post('emp_id');
        $data = [
            'spouse_name'      => $this->input->post('spouse_name'),
            'is_govt_employee' => $this->input->post('is_govt_employee') ? 1 : 0,
            'govt_emp_cnic'    => $this->input->post('govt_emp_cnic'),
            'is_draft'         => 1,
        ];
        $id = $this->Employee_model->add_spouse($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Added.', $data);
    }

    public function ajax_delete_spouse() {
        $this->Employee_model->delete_spouse($this->input->post('id'));
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — CHILDREN
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_child() {
        $emp_id = $this->input->post('emp_id');
        $data = [
            'name'        => $this->input->post('name'),
            'dob'         => $this->input->post('dob') ?: NULL,
            'gender'      => $this->input->post('gender'),
            'school_name' => $this->input->post('school_name'),
            'is_draft'    => 1,
        ];
        $id = $this->Employee_model->add_child($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Added.', $data);
    }

    public function ajax_delete_child() {
        $this->Employee_model->delete_child($this->input->post('id'));
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — POSTING
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_add_posting() {
        $emp_id = $this->input->post('emp_id');

        // Handle file upload
        $letter_path = '';
        if (!empty($_FILES['appointment_letter']['name'])) {
            $config = [
                'upload_path'   => './uploads/appointment_letters/',
                'allowed_types' => 'pdf|jpg|jpeg|png',
                'max_size'      => 2048,
                'encrypt_name'  => TRUE,
            ];
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('appointment_letter')) {
                $letter_path = $this->upload->data('file_name');
            }
        }

        $data = [
            'post_name'               => $this->input->post('post_name'),
            'pay_scale'               => $this->input->post('pay_scale'),
            'sanctioned_name'         => $this->input->post('sanctioned_name'),
            'posting_place'           => $this->input->post('posting_place'),
            'appointment_start_date'  => $this->input->post('appointment_start_date') ?: NULL,
            'appointment_letter'      => $letter_path,
            'additional_charge'       => $this->input->post('additional_charge'),
            'transfer_status'         => $this->input->post('transfer_status'),
            'currently_on_post'       => $this->input->post('currently_on_post') ? 1 : 0,
            'remove_district_limit'   => $this->input->post('remove_district_limit') ? 1 : 0,
            'is_draft'                => 1,
        ];
        $id = $this->Employee_model->add_posting($emp_id, $data);
        $data['id'] = $id;
        $this->_json(true, 'Posting added.', $data);
    }

    public function ajax_delete_posting() {
        $this->Employee_model->delete_posting($this->input->post('id'));
        $this->_json(true, 'Deleted.');
    }

    // ════════════════════════════════════════════════════════════════════════
    //  AJAX — MARK SECTION COMPLETE
    // ════════════════════════════════════════════════════════════════════════
    public function ajax_complete_section() {
        $emp_id  = $this->input->post('emp_id');
        $section = $this->input->post('section'); // e.g. 'education_done'
        $this->Employee_model->mark_section_done($emp_id, $section);
        $this->_json(true, 'Section marked complete.');
    }
}