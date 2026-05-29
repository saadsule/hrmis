<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // ── AUTO-GENERATE EMPLOYEE CODE ─────────────────────────────────────────
    public function generate_emp_code() {
        $this->db->select_max('id');
        $row = $this->db->get('emp_personal')->row();
        $next = $row ? ((int)$row->id + 1) : 1;
        return 'EMP-' . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  PERSONAL RECORD
    // ═══════════════════════════════════════════════════════════════════════
    public function save_personal($data) {
        $data['created_by'] = $this->session->userdata('user_id');
        $this->db->insert('emp_personal', $data);
        $emp_id = $this->db->insert_id();
        // Initialise section tracker
        $this->db->insert('emp_section_status', ['emp_id' => $emp_id, 'personal_done' => 1]);
        return $emp_id;
    }

    public function update_personal($emp_id, $data) {
        $this->db->where('id', $emp_id)->update('emp_personal', $data);
        return $this->db->affected_rows();
    }

    public function get_personal($emp_id) {
        return $this->db->get_where('emp_personal', ['id' => $emp_id])->row();
    }

    public function get_all_employees($search = '') {
        $this->db->select('id, emp_code, full_name, cnic, contact_no, job_status, current_bps, joining_date, created_at');
        if ($search) {
            $this->db->group_start()
                     ->like('full_name', $search)
                     ->or_like('cnic', $search)
                     ->or_like('emp_code', $search)
                     ->group_end();
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('emp_personal')->result();
    }

    public function delete_personal($emp_id) {
        $this->db->where('id', $emp_id)->delete('emp_personal');
        return $this->db->affected_rows();
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  EDUCATION
    // ═══════════════════════════════════════════════════════════════════════
    public function add_education($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        $this->db->insert('emp_education', $data);
        return $this->db->insert_id();
    }

    public function get_education($emp_id) {
        return $this->db->get_where('emp_education', ['emp_id' => $emp_id])->result();
    }

    public function update_education($id, $data) {
        $this->db->where('id', $id)->update('emp_education', $data);
    }

    public function delete_education($id) {
        $this->db->where('id', $id)->delete('emp_education');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  SPECIALITY
    // ═══════════════════════════════════════════════════════════════════════
    public function add_speciality($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        $this->db->insert('emp_speciality', $data);
        return $this->db->insert_id();
    }

    public function get_specialities($emp_id) {
        return $this->db->get_where('emp_speciality', ['emp_id' => $emp_id])->result();
    }

    public function delete_speciality($id) {
        $this->db->where('id', $id)->delete('emp_speciality');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  TRAINING
    // ═══════════════════════════════════════════════════════════════════════
    public function add_training($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        $this->db->insert('emp_training', $data);
        return $this->db->insert_id();
    }

    public function get_trainings($emp_id) {
        return $this->db->get_where('emp_training', ['emp_id' => $emp_id])->result();
    }

    public function delete_training($id) {
        $this->db->where('id', $id)->delete('emp_training');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  SPOUSE
    // ═══════════════════════════════════════════════════════════════════════
    public function add_spouse($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        $this->db->insert('emp_spouse', $data);
        return $this->db->insert_id();
    }

    public function get_spouses($emp_id) {
        return $this->db->get_where('emp_spouse', ['emp_id' => $emp_id])->result();
    }

    public function delete_spouse($id) {
        $this->db->where('id', $id)->delete('emp_spouse');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  CHILDREN
    // ═══════════════════════════════════════════════════════════════════════
    public function add_child($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        $this->db->insert('emp_children', $data);
        return $this->db->insert_id();
    }

    public function get_children($emp_id) {
        return $this->db->get_where('emp_children', ['emp_id' => $emp_id])->result();
    }

    public function delete_child($id) {
        $this->db->where('id', $id)->delete('emp_children');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  POSTING
    // ═══════════════════════════════════════════════════════════════════════
    public function add_posting($emp_id, $data) {
        $data['emp_id'] = $emp_id;
        // Only one "currently on post" at a time
        if (!empty($data['currently_on_post'])) {
            $this->db->where('emp_id', $emp_id)->update('emp_posting', ['currently_on_post' => 0]);
        }
        $this->db->insert('emp_posting', $data);
        return $this->db->insert_id();
    }

    public function get_postings($emp_id) {
        return $this->db->get_where('emp_posting', ['emp_id' => $emp_id])->result();
    }

    public function delete_posting($id) {
        $this->db->where('id', $id)->delete('emp_posting');
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  SECTION STATUS
    // ═══════════════════════════════════════════════════════════════════════
    public function get_section_status($emp_id) {
        return $this->db->get_where('emp_section_status', ['emp_id' => $emp_id])->row();
    }

    public function mark_section_done($emp_id, $section_field) {
        $allowed = ['education_done','speciality_done','training_done','spouse_done','children_done','posting_done'];
        if (!in_array($section_field, $allowed)) return false;
        $this->db->where('emp_id', $emp_id)->update('emp_section_status', [$section_field => 1]);
    }

    public function mark_draft_saved($emp_id, $section_field) {
        // same as mark_done — draft is a partial save (is_draft=1 rows exist)
        // just a UI hint; data already saved row-by-row
        return true;
    }

    // ═══════════════════════════════════════════════════════════════════════
    //  DROPDOWNS DATA
    // ═══════════════════════════════════════════════════════════════════════
    public function get_designations() {
        return $this->db->order_by('name','ASC')->get('designations')->result();
    }

    public function get_districts() {
        return $this->db->order_by('name','ASC')->get('districts')->result();
    }
}