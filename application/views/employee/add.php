<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-container">
    <div class="main-content">

        <div class="page-header">
            <h4 class="page-title">Add New Employee</h4>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a href="<?= base_url('employee') ?>" class="breadcrumb-item">Employees</a>
                    <span class="breadcrumb-item active">Add New</span>
                </nav>
            </div>
        </div>

        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="anticon anticon-close-circle m-r-5"></i>
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('employee/add') ?>">

            <!-- ── Personal Info ─────────────────────────────── -->
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title m-b-0">
                        <i class="anticon anticon-user m-r-8 text-primary"></i>
                        Personal Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Auto Code -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Employee Code</label>
                            <input type="text" class="form-control" value="<?= $emp_code ?>" readonly>
                            <input type="hidden" name="emp_code" value="<?= $emp_code ?>">
                            <small class="text-muted">Auto-generated</small>
                        </div>
                        <!-- Employee No -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Employee No <span class="text-danger">*</span></label>
                            <input type="text" name="employee_no" class="form-control"
                                   value="<?= set_value('employee_no') ?>" required placeholder="e.g. HR-001">
                        </div>
                        <!-- Gender -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="form-control" required>
                                <option value="">— Select —</option>
                                <option value="Male"   <?= set_select('gender','Male') ?>>Male</option>
                                <option value="Female" <?= set_select('gender','Female') ?>>Female</option>
                                <option value="Other"  <?= set_select('gender','Other') ?>>Other</option>
                            </select>
                        </div>
                        <!-- Marital Status -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Marital Status</label>
                            <select name="marital_status" class="form-control">
                                <option value="">— Select —</option>
                                <option value="Single"   <?= set_select('marital_status','Single') ?>>Single</option>
                                <option value="Married"  <?= set_select('marital_status','Married') ?>>Married</option>
                                <option value="Divorced" <?= set_select('marital_status','Divorced') ?>>Divorced</option>
                                <option value="Widowed"  <?= set_select('marital_status','Widowed') ?>>Widowed</option>
                            </select>
                        </div>

                        <!-- Full Name -->
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control"
                                   value="<?= set_value('full_name') ?>" required placeholder="Full name as per CNIC">
                        </div>
                        <!-- Father Name -->
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Father's Name</label>
                            <input type="text" name="father_name" class="form-control"
                                   value="<?= set_value('father_name') ?>" placeholder="Father's full name">
                        </div>

                        <!-- CNIC -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">CNIC <span class="text-danger">*</span></label>
                            <input type="text" name="cnic" class="form-control"
                                   value="<?= set_value('cnic') ?>" required
                                   placeholder="00000-0000000-0" maxlength="15">
                            <small class="text-muted">Format: 00000-0000000-0</small>
                        </div>
                        <!-- DOB -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="dob" class="form-control"
                                   value="<?= set_value('dob') ?>" required>
                        </div>
                        <!-- Contact -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Contact No <span class="text-danger">*</span></label>
                            <input type="text" name="contact_no" class="form-control"
                                   value="<?= set_value('contact_no') ?>" required
                                   placeholder="03001234567" maxlength="11">
                        </div>

                        <!-- Email -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= set_value('email') ?>" placeholder="email@example.com">
                        </div>
                        <!-- Nationality -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Nationality</label>
                            <input type="text" name="nationality" class="form-control"
                                   value="<?= set_value('nationality','Pakistani') ?>">
                        </div>
                        <!-- Passport -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Passport No</label>
                            <input type="text" name="passport_no" class="form-control"
                                   value="<?= set_value('passport_no') ?>">
                        </div>

                        <!-- District Domicile -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">District of Domicile</label>
                            <input type="text" name="district_domicile" class="form-control"
                                   value="<?= set_value('district_domicile') ?>" placeholder="District name">
                        </div>
                        <!-- Professional Reg No -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Professional Reg No</label>
                            <input type="text" name="professional_reg_no" class="form-control"
                                   value="<?= set_value('professional_reg_no') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Address ──────────────────────────────────── -->
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title m-b-0">
                        <i class="anticon anticon-home m-r-8 text-warning"></i>
                        Address Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Postal Address</label>
                            <textarea name="postal_address" class="form-control" rows="2"><?= set_value('postal_address') ?></textarea>
                        </div>
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Residential Address</label>
                            <textarea name="residential_address" class="form-control" rows="2"><?= set_value('residential_address') ?></textarea>
                        </div>
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Residential City</label>
                            <input type="text" name="residential_city" class="form-control"
                                   value="<?= set_value('residential_city') ?>">
                        </div>
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Permanent Address</label>
                            <textarea name="permanent_address" class="form-control" rows="2"><?= set_value('permanent_address') ?></textarea>
                        </div>
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Permanent City</label>
                            <input type="text" name="permanent_city" class="form-control"
                                   value="<?= set_value('permanent_city') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Employment ───────────────────────────────── -->
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title m-b-0">
                        <i class="anticon anticon-idcard m-r-8 text-success"></i>
                        Employment Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Job Status -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Job Status <span class="text-danger">*</span></label>
                            <select name="job_status" class="form-control" required>
                                <option value="">— Select —</option>
                                <option value="Permanent"   <?= set_select('job_status','Permanent') ?>>Permanent</option>
                                <option value="Contract"    <?= set_select('job_status','Contract') ?>>Contract</option>
                                <option value="Daily Wages" <?= set_select('job_status','Daily Wages') ?>>Daily Wages</option>
                                <option value="Deputation"  <?= set_select('job_status','Deputation') ?>>Deputation</option>
                            </select>
                        </div>
                        <!-- Joining Date -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Joining Date <span class="text-danger">*</span></label>
                            <input type="date" name="joining_date" class="form-control"
                                   value="<?= set_value('joining_date') ?>" required>
                        </div>
                        <!-- Current BPS -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Current BPS</label>
                            <select name="current_bps" class="form-control">
                                <option value="">— Select —</option>
                                <?php for ($b = 1; $b <= 22; $b++): ?>
                                <option value="<?= $b ?>" <?= set_select('current_bps',$b) ?>>BPS-<?= $b ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <!-- Mode of Appointment -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Mode of Appointment</label>
                            <input type="text" name="mode_of_appointment" class="form-control"
                                   value="<?= set_value('mode_of_appointment') ?>" placeholder="Direct / Promotion…">
                        </div>

                        <!-- Actual Designation -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Actual Designation</label>
                            <input type="text" name="actual_designation" class="form-control"
                                   value="<?= set_value('actual_designation') ?>">
                        </div>
                        <!-- Sanctioned Designation -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Sanctioned Designation</label>
                            <input type="text" name="sanctioned_designation" class="form-control"
                                   value="<?= set_value('sanctioned_designation') ?>">
                        </div>
                        <!-- Quota -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Quota</label>
                            <input type="text" name="quota" class="form-control"
                                   value="<?= set_value('quota') ?>" placeholder="e.g. Merit / District">
                        </div>

                        <!-- Cadre -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Cadre</label>
                            <input type="text" name="cadre_value" class="form-control"
                                   value="<?= set_value('cadre_value') ?>">
                        </div>
                        <!-- Category -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Category</label>
                            <input type="text" name="category" class="form-control"
                                   value="<?= set_value('category') ?>">
                        </div>
                        <!-- Seniority List No -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Seniority List No</label>
                            <input type="text" name="seniority_list_no" class="form-control"
                                   value="<?= set_value('seniority_list_no') ?>">
                        </div>
                        <!-- DDO Number -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">DDO Number</label>
                            <input type="text" name="ddo_number" class="form-control"
                                   value="<?= set_value('ddo_number') ?>">
                        </div>

                        <!-- DDO Description -->
                        <div class="col-md-12 m-b-15">
                            <label class="font-weight-semibold font-size-13">DDO Description</label>
                            <textarea name="ddo_description" class="form-control" rows="2"><?= set_value('ddo_description') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-end" style="gap:8px">
                <a href="<?= base_url('employee') ?>" class="btn btn-default">
                    <i class="anticon anticon-close m-r-5"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="anticon anticon-save m-r-5"></i> Save & Continue
                </button>
            </div>

        </form>
    </div>