<?php defined('BASEPATH') OR exit('No direct script access allowed');
$e = $emp; // shorthand
?>

<div class="page-container">
    <div class="main-content">

        <div class="page-header">
            <h4 class="page-title">Edit Personal Information</h4>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a href="<?= base_url('employee') ?>" class="breadcrumb-item">Employees</a>
                    <a href="<?= base_url('employee/profile/'.$e->id) ?>" class="breadcrumb-item"><?= htmlspecialchars($e->full_name) ?></a>
                    <span class="breadcrumb-item active">Edit</span>
                </nav>
            </div>
        </div>

        <form method="POST" action="<?= base_url('employee/edit_personal/'.$e->id) ?>">

            <!-- ── Personal Info ─────────────────────────────── -->
            <div class="card m-b-20">
                <div class="card-header">
                    <h5 class="card-title m-b-0">
                        <i class="anticon anticon-user m-r-8 text-primary"></i>
                        Personal Information
                        <span class="badge badge-cyan badge-pill m-l-10"><?= $e->emp_code ?></span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Employee Code (readonly) -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Employee Code</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($e->emp_code) ?>" readonly>
                        </div>
                        <!-- Employee No -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Employee No</label>
                            <input type="text" name="employee_no" class="form-control"
                                   value="<?= htmlspecialchars($e->employee_no) ?>">
                        </div>
                        <!-- Gender -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">— Select —</option>
                                <?php foreach (['Male','Female','Other'] as $g): ?>
                                <option value="<?= $g ?>" <?= $e->gender == $g ? 'selected' : '' ?>><?= $g ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Marital Status -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Marital Status</label>
                            <select name="marital_status" class="form-control">
                                <option value="">— Select —</option>
                                <?php foreach (['Single','Married','Divorced','Widowed'] as $ms): ?>
                                <option value="<?= $ms ?>" <?= $e->marital_status == $ms ? 'selected' : '' ?>><?= $ms ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Full Name -->
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" required
                                   value="<?= htmlspecialchars($e->full_name) ?>">
                        </div>
                        <!-- Father Name -->
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Father's Name</label>
                            <input type="text" name="father_name" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->father_name) ? $e->father_name : '') ?>">
                        </div>

                        <!-- CNIC -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">CNIC</label>
                            <input type="text" name="cnic" class="form-control"
                                   value="<?= htmlspecialchars($e->cnic) ?>" maxlength="15">
                        </div>
                        <!-- DOB -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Date of Birth</label>
                            <input type="date" name="dob" class="form-control"
                                   value="<?= $e->dob ?>">
                        </div>
                        <!-- Contact -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Contact No</label>
                            <input type="text" name="contact_no" class="form-control"
                                   value="<?= htmlspecialchars($e->contact_no) ?>" maxlength="11">
                        </div>

                        <!-- Email -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->email) ? $e->email : '') ?>">
                        </div>

                        <!-- Nationality -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Nationality</label>
                            <input type="text" name="nationality" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->nationality) ? $e->nationality : 'Pakistani') ?>">
                        </div>

                        <!-- Passport -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Passport No</label>
                            <input type="text" name="passport_no" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->passport_no) ? $e->passport_no : '') ?>">
                        </div>

                        <!-- District Domicile -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">District of Domicile</label>
                            <input type="text" name="district_domicile" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->district_domicile) ? $e->district_domicile : '') ?>">
                        </div>

                        <!-- Professional Reg No -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Professional Reg No</label>
                            <input type="text" name="professional_reg_no" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->professional_reg_no) ? $e->professional_reg_no : '') ?>">
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
                            <textarea name="postal_address" class="form-control" rows="2"><?= htmlspecialchars(isset($e->postal_address) ? $e->postal_address : '') ?></textarea>
                        </div>
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Residential Address</label>
                            <textarea name="residential_address" class="form-control" rows="2"><?= htmlspecialchars(isset($e->residential_address) ? $e->residential_address : '') ?></textarea>
                        </div>
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Residential City</label>
                            <input type="text" name="residential_city" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->residential_city) ? $e->residential_city : '') ?>">
                        </div>
                        <div class="col-md-6 m-b-15">
                            <label class="font-weight-semibold font-size-13">Permanent Address</label>
                            <textarea name="permanent_address" class="form-control" rows="2"><?= htmlspecialchars(isset($e->permanent_address) ? $e->permanent_address : '') ?></textarea>
                        </div>
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Permanent City</label>
                            <input type="text" name="permanent_city" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->permanent_city) ? $e->permanent_city : '') ?>">
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
                            <label class="font-weight-semibold font-size-13">Job Status</label>
                            <select name="job_status" class="form-control">
                                <?php foreach (['Permanent','Contract','Daily Wages','Deputation'] as $js): ?>
                                <option value="<?= $js ?>" <?= $e->job_status == $js ? 'selected' : '' ?>><?= $js ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Joining Date -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Joining Date</label>
                            <input type="date" name="joining_date" class="form-control"
                                   value="<?= $e->joining_date ?>">
                        </div>
                        <!-- Current BPS -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Current BPS</label>
                            <select name="current_bps" class="form-control">
                                <option value="">— Select —</option>
                                <?php for ($b = 1; $b <= 22; $b++): ?>
                                <option value="<?= $b ?>" <?= $e->current_bps == $b ? 'selected' : '' ?>>BPS-<?= $b ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <!-- Mode of Appointment -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Mode of Appointment</label>
                            <input type="text" name="mode_of_appointment" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->mode_of_appointment) ? $e->mode_of_appointment : '') ?>">
                        </div>

                        <!-- Actual Designation -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Actual Designation</label>
                            <input type="text" name="actual_designation" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->actual_designation) ? $e->actual_designation : '') ?>">
                        </div>

                        <!-- Sanctioned Designation -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Sanctioned Designation</label>
                            <input type="text" name="sanctioned_designation" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->sanctioned_designation) ? $e->sanctioned_designation : '') ?>">
                        </div>

                        <!-- Quota -->
                        <div class="col-md-4 m-b-15">
                            <label class="font-weight-semibold font-size-13">Quota</label>
                            <input type="text" name="quota" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->quota) ? $e->quota : '') ?>">
                        </div>

                        <!-- Cadre -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Cadre</label>
                            <input type="text" name="cadre_value" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->cadre_value) ? $e->cadre_value : '') ?>">
                        </div>

                        <!-- Category -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Category</label>
                            <input type="text" name="category" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->category) ? $e->category : '') ?>">
                        </div>

                        <!-- Seniority List No -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">Seniority List No</label>
                            <input type="text" name="seniority_list_no" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->seniority_list_no) ? $e->seniority_list_no : '') ?>">
                        </div>

                        <!-- DDO Number -->
                        <div class="col-md-3 m-b-15">
                            <label class="font-weight-semibold font-size-13">DDO Number</label>
                            <input type="text" name="ddo_number" class="form-control"
                                   value="<?= htmlspecialchars(isset($e->ddo_number) ? $e->ddo_number : '') ?>">
                        </div>

                        <!-- DDO Description -->
                        <div class="col-md-12 m-b-15">
                            <label class="font-weight-semibold font-size-13">DDO Description</label>
                            <textarea name="ddo_description" class="form-control" rows="2"><?= htmlspecialchars(isset($e->ddo_description) ? $e->ddo_description : '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="d-flex justify-content-end" style="gap:8px">
                <a href="<?= base_url('employee/profile/'.$e->id) ?>" class="btn btn-default">
                    <i class="anticon anticon-close m-r-5"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="anticon anticon-save m-r-5"></i> Save Changes
                </button>
            </div>

        </form>
    </div>