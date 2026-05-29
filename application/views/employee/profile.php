<?php defined('BASEPATH') OR exit('No direct script access allowed');
$p = $personal; // shorthand
?>

<div class="page-container">
    <div class="main-content">

        <div class="page-header">
            <h4 class="page-title">
                Employee Profile
                <small class="text-muted font-size-14 m-l-10"><?= htmlspecialchars($p->full_name) ?></small>
            </h4>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <a href="<?= base_url('employee') ?>" class="breadcrumb-item">Employees</a>
                    <span class="breadcrumb-item active">Profile</span>
                </nav>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="anticon anticon-check-circle m-r-5"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        <?php endif; ?>

        <!-- ── Profile Header Card ───────────────────────────── -->
        <div class="card m-b-20">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px">
                    <div class="d-flex align-items-center" style="gap:16px">
                        <div class="avatar avatar-icon avatar-xl avatar-blue" style="font-size:28px;font-weight:800;width:64px;height:64px">
                            <?= strtoupper(substr($p->full_name,0,1)) ?>
                        </div>
                        <div>
                            <h4 class="m-b-2 font-weight-bold"><?= htmlspecialchars($p->full_name) ?></h4>
                            <p class="m-b-3 text-muted">
                                <?= isset($p->actual_designation) ? $p->actual_designation : 'No designation' ?>
                                <?php if ($p->current_bps): ?> &mdash; <span class="badge badge-default">BPS-<?= $p->current_bps ?></span><?php endif; ?>
                            </p>
                            <div class="d-flex align-items-center" style="gap:8px;flex-wrap:wrap">
                                <span class="badge badge-cyan badge-pill font-size-12"><?= $p->emp_code ?></span>
                                <?php
                                $st = ['Permanent'=>'badge-success','Contract'=>'badge-warning','Daily Wages'=>'badge-orange','Deputation'=>'badge-blue'];
                                echo '<span class="badge '.(isset($st[$p->job_status]) ? $st[$p->job_status] : 'badge-default').' badge-pill">'.$p->job_status.'</span>';
                                ?>
                                <?php if ($p->cnic): ?><span class="text-muted font-size-12"><i class="anticon anticon-idcard m-r-3"></i><?= $p->cnic ?></span><?php endif; ?>
                                <?php if ($p->contact_no): ?><span class="text-muted font-size-12"><i class="anticon anticon-phone m-r-3"></i><?= $p->contact_no ?></span><?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" style="gap:8px">
                        <a href="<?= base_url('employee/edit_personal/'.$emp_id) ?>" class="btn btn-default btn-sm">
                            <i class="anticon anticon-edit m-r-5"></i> Edit Personal
                        </a>
                        <?php if (in_array($this->session->userdata('role'),[1,'admin'])): ?>
                        <a href="<?= base_url('employee/delete/'.$emp_id) ?>"
                           class="btn btn-danger btn-sm btn-confirm-delete"
                           data-name="<?= htmlspecialchars($p->full_name) ?>">
                            <i class="anticon anticon-delete m-r-5"></i> Delete
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── Section Progress ─────────────────────────────── -->
        <?php
        $sec_map = [
            'personal_done'   => 'Personal',
            'education_done'  => 'Education',
            'speciality_done' => 'Speciality',
            'training_done'   => 'Training',
            'spouse_done'     => 'Spouse',
            'children_done'   => 'Children',
            'posting_done'    => 'Posting',
        ];
        $done_count = 0;
        foreach ($sec_map as $field => $label) { if (!empty($sections->$field)) $done_count++; }
        $pct = round(($done_count / count($sec_map)) * 100);
        ?>
        <div class="card m-b-20">
            <div class="card-body p-v-10">
                <div class="d-flex align-items-center justify-content-between m-b-5">
                    <span class="font-weight-semibold font-size-13">Profile Completion</span>
                    <span class="text-muted font-size-13"><?= $done_count ?>/<?= count($sec_map) ?> sections complete (<?= $pct ?>%)</span>
                </div>
                <div class="progress" style="height:8px">
                    <div class="progress-bar bg-success" style="width:<?= $pct ?>%"></div>
                </div>
                <div class="d-flex flex-wrap m-t-8" style="gap:6px">
                    <?php foreach ($sec_map as $field => $label): ?>
                    <span class="badge badge-pill <?= !empty($sections->$field) ? 'badge-success' : 'badge-default' ?> font-size-11">
                        <?= !empty($sections->$field) ? '✓' : '○' ?> <?= $label ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 1 — PERSONAL INFO (read-only display)
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="personal-body">
                <i class="anticon anticon-user m-r-10 text-primary"></i>
                <span class="font-weight-semibold">Personal Information</span>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="personal-body">
                <div class="row">
                    <?php
                    $fields = [
                        'Gender'              => $p->gender,
                        'Father\'s Name'      => $p->father_name,
                        'CNIC'                => $p->cnic,
                        'Date of Birth'       => $p->dob ? date('d M Y', strtotime($p->dob)) : '—',
                        'Marital Status'      => $p->marital_status,
                        'Nationality'         => $p->nationality,
                        'Contact No'          => $p->contact_no,
                        'Email'               => $p->email,
                        'Passport No'         => $p->passport_no,
                        'District Domicile'   => $p->district_domicile,
                        'Employee No'         => $p->employee_no,
                        'Joining Date'        => $p->joining_date ? date('d M Y', strtotime($p->joining_date)) : '—',
                        'Job Status'          => $p->job_status,
                        'Current BPS'         => $p->current_bps ? 'BPS-'.$p->current_bps : '—',
                        'Actual Designation'  => $p->actual_designation,
                        'Sanctioned Designation' => $p->sanctioned_designation,
                        'Mode of Appointment' => $p->mode_of_appointment,
                        'Quota'               => $p->quota,
                        'Cadre'               => $p->cadre_value,
                        'Category'            => $p->category,
                        'Seniority List No'   => $p->seniority_list_no,
                        'DDO Number'          => $p->ddo_number,
                        'Professional Reg No' => $p->professional_reg_no,
                    ];
                    foreach ($fields as $label => $val):
                    ?>
                    <div class="col-md-4 col-sm-6 m-b-12">
                        <p class="m-b-0 text-muted font-size-12 font-weight-semibold text-uppercase" style="letter-spacing:.04em"><?= $label ?></p>
                        <p class="m-b-0 font-size-13 font-weight-semibold"><?= htmlspecialchars($val ?: '—') ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($p->postal_address || $p->residential_address || $p->permanent_address): ?>
                <hr>
                <div class="row">
                    <?php if ($p->postal_address): ?>
                    <div class="col-md-4 m-b-10">
                        <p class="m-b-0 text-muted font-size-12 font-weight-semibold text-uppercase">Postal Address</p>
                        <p class="m-b-0 font-size-13"><?= nl2br(htmlspecialchars($p->postal_address)) ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if ($p->residential_address): ?>
                    <div class="col-md-4 m-b-10">
                        <p class="m-b-0 text-muted font-size-12 font-weight-semibold text-uppercase">Residential Address</p>
                        <p class="m-b-0 font-size-13"><?= nl2br(htmlspecialchars($p->residential_address)) ?></p>
                        <?php if ($p->residential_city): ?><small class="text-muted"><?= $p->residential_city ?></small><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($p->permanent_address): ?>
                    <div class="col-md-4 m-b-10">
                        <p class="m-b-0 text-muted font-size-12 font-weight-semibold text-uppercase">Permanent Address</p>
                        <p class="m-b-0 font-size-13"><?= nl2br(htmlspecialchars($p->permanent_address)) ?></p>
                        <?php if ($p->permanent_city): ?><small class="text-muted"><?= $p->permanent_city ?></small><?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if ($p->ddo_description): ?>
                <hr>
                <p class="m-b-0 text-muted font-size-12 font-weight-semibold text-uppercase">DDO Description</p>
                <p class="font-size-13"><?= htmlspecialchars($p->ddo_description) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 2 — EDUCATION
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15" id="edu-card">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="edu-body">
                <i class="anticon anticon-read m-r-10 text-success"></i>
                <span class="font-weight-semibold">Education</span>
                <?php if (!empty($sections->education_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="edu-body" style="display:none">

                <!-- Add Education Form -->
                <div class="border rounded p-15 m-b-15 bg-light">
                    <h6 class="m-b-10 font-weight-semibold">Add Education Record</h6>
                    <div class="row" id="edu-form">
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Level <span class="text-danger">*</span></label>
                            <input type="text" id="edu_level" class="form-control form-control-sm" placeholder="Matric / BA / MA…">
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Board / University</label>
                            <input type="text" id="edu_board" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Passing Month</label>
                            <select id="edu_month" class="form-control form-control-sm">
                                <option value="">Month</option>
                                <?php foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $m): ?>
                                <option><?= $m ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-1 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Year</label>
                            <input type="number" id="edu_year" class="form-control form-control-sm" placeholder="2020" min="1970" max="<?= date('Y') ?>">
                        </div>
                        <div class="col-md-1 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Total Marks</label>
                            <input type="number" id="edu_total" class="form-control form-control-sm" placeholder="1100">
                        </div>
                        <div class="col-md-1 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Obtained</label>
                            <input type="number" id="edu_obtained" class="form-control form-control-sm" placeholder="950">
                        </div>
                        <div class="col-md-1 m-b-10">
                            <label class="font-size-12 font-weight-semibold">%</label>
                            <input type="number" id="edu_pct" class="form-control form-control-sm" placeholder="86" step="0.01">
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button class="btn btn-sm btn-primary" id="btn-add-edu">
                                <i class="anticon anticon-plus m-r-5"></i> Add Row
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Education Table -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover m-b-10" id="edu-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Level</th><th>Board/University</th><th>Month/Year</th>
                                <th>Total Marks</th><th>Obtained</th><th>%</th><th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($education as $e): ?>
                            <tr id="edu-row-<?= $e->id ?>">
                                <td><?= htmlspecialchars($e->level) ?></td>
                                <td><?= htmlspecialchars(isset($e->board_university) ? $e->board_university : '—') ?></td>
                                <td>
                                    <?= trim(
                                        (isset($e->ending_month) ? $e->ending_month : '') . ' ' .
                                        (isset($e->ending_year) ? $e->ending_year : '')
                                    ) ?: '—' ?>
                                </td>
                                <td><?= isset($e->total_marks) ? $e->total_marks : '—' ?></td>
                                <td><?= isset($e->obtained_marks) ? $e->obtained_marks : '—' ?></td>
                                <td><?= $e->percentage ? $e->percentage.'%' : '—' ?></td>
                                <td>
                                    <button class="btn btn-icon btn-sm btn-danger btn-del-edu"
                                            data-id="<?= $e->id ?>">
                                        <i class="anticon anticon-delete"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($education)): ?>
                <div class="empty-msg text-muted text-center p-v-15 font-size-13" id="edu-empty">No education records yet.</div>
                <?php endif; ?>

                <div class="text-right m-t-10">
                    <button class="btn btn-sm btn-success btn-mark-done"
                            data-section="education_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 3 — SPECIALITY
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="spec-body">
                <i class="anticon anticon-star m-r-10 text-gold"></i>
                <span class="font-weight-semibold">Specialities</span>
                <?php if (!empty($sections->speciality_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="spec-body" style="display:none">
                <div class="d-flex m-b-15" style="gap:8px">
                    <input type="text" id="spec-input" class="form-control form-control-sm" style="max-width:300px"
                           placeholder="e.g. Pediatrics, Surgery…">
                    <button class="btn btn-sm btn-primary" id="btn-add-spec">
                        <i class="anticon anticon-plus m-r-5"></i> Add
                    </button>
                </div>
                <div id="spec-list" class="d-flex flex-wrap" style="gap:8px">
                    <?php foreach ($specialities as $s): ?>
                    <span class="badge badge-cyan badge-pill font-size-13 p-h-12 p-v-5" id="spec-item-<?= $s->id ?>">
                        <?= htmlspecialchars($s->speciality) ?>
                        <a href="#" class="m-l-5 text-white del-spec" data-id="<?= $s->id ?>">&times;</a>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php if (empty($specialities)): ?>
                <p class="text-muted font-size-13 m-t-5" id="spec-empty">No specialities added yet.</p>
                <?php endif; ?>
                <div class="text-right m-t-15">
                    <button class="btn btn-sm btn-success btn-mark-done"
                            data-section="speciality_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 4 — TRAINING
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="train-body">
                <i class="anticon anticon-book m-r-10 text-purple"></i>
                <span class="font-weight-semibold">Training &amp; Certifications</span>
                <?php if (!empty($sections->training_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="train-body" style="display:none">
                <div class="border rounded p-15 m-b-15 bg-light">
                    <div class="row">
                        <div class="col-md-4 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Training Name <span class="text-danger">*</span></label>
                            <input type="text" id="tr_name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Institute</label>
                            <input type="text" id="tr_inst" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Start (Month/Year)</label>
                            <div class="d-flex" style="gap:4px">
                                <select id="tr_sm" class="form-control form-control-sm">
                                    <option value="">Mo</option>
                                    <?php foreach (['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m): ?>
                                    <option><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" id="tr_sy" class="form-control form-control-sm" placeholder="YYYY" min="1970" max="<?= date('Y') ?>">
                            </div>
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">End (Month/Year)</label>
                            <div class="d-flex" style="gap:4px">
                                <select id="tr_em" class="form-control form-control-sm">
                                    <option value="">Mo</option>
                                    <?php foreach (['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] as $m): ?>
                                    <option><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" id="tr_ey" class="form-control form-control-sm" placeholder="YYYY" min="1970" max="<?= date('Y') ?>">
                            </div>
                        </div>
                        <div class="col-md-1 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Days</label>
                            <input type="number" id="tr_days" class="form-control form-control-sm" placeholder="30">
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button class="btn btn-sm btn-primary" id="btn-add-train">
                                <i class="anticon anticon-plus m-r-5"></i> Add Training
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover m-b-10" id="train-table">
                        <thead class="thead-light">
                            <tr><th>Training</th><th>Institute</th><th>From</th><th>To</th><th>Days</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trainings as $t): ?>
                            <tr id="tr-row-<?= $t->id ?>">
                                <td><?= htmlspecialchars($t->training_name) ?></td>
                                <td><?= htmlspecialchars(isset($t->institute) ? $t->institute : '—') ?></td>
                                <td>
                                    <?= trim(
                                        (isset($t->start_month) ? $t->start_month : '') . ' ' .
                                        (isset($t->start_year) ? $t->start_year : '')
                                    ) ?: '—' ?>
                                </td>
                                <td>
                                    <?= trim(
                                        (isset($t->end_month) ? $t->end_month : '') . ' ' .
                                        (isset($t->end_year) ? $t->end_year : '')
                                    ) ?: '—' ?>
                                </td>
                                <td><?= isset($t->duration_days) ? $t->duration_days : '—' ?></td>
                                <td><button class="btn btn-icon btn-sm btn-danger btn-del-train" data-id="<?= $t->id ?>"><i class="anticon anticon-delete"></i></button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($trainings)): ?><p class="text-muted font-size-13" id="train-empty">No training records yet.</p><?php endif; ?>
                <div class="text-right m-t-10">
                    <button class="btn btn-sm btn-success btn-mark-done" data-section="training_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 5 — SPOUSE
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="spouse-body">
                <i class="anticon anticon-heart m-r-10 text-danger"></i>
                <span class="font-weight-semibold">Spouse Information</span>
                <?php if (!empty($sections->spouse_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="spouse-body" style="display:none">
                <div class="border rounded p-15 m-b-15 bg-light">
                    <div class="row">
                        <div class="col-md-4 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Spouse Name <span class="text-danger">*</span></label>
                            <input type="text" id="sp_name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Govt Employee?</label>
                            <select id="sp_govt" class="form-control form-control-sm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Govt Emp CNIC</label>
                            <input type="text" id="sp_cnic" class="form-control form-control-sm" placeholder="00000-0000000-0">
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button class="btn btn-sm btn-primary" id="btn-add-spouse">
                                <i class="anticon anticon-plus m-r-5"></i> Add Spouse
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="spouse-table">
                        <thead class="thead-light">
                            <tr><th>Name</th><th>Govt Employee</th><th>CNIC</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($spouses as $s): ?>
                            <tr id="sp-row-<?= $s->id ?>">
                                <td><?= htmlspecialchars($s->spouse_name) ?></td>
                                <td><?= $s->is_govt_employee ? 'Yes' : 'No' ?></td>
                                <td><?= isset($s->govt_emp_cnic) ? $s->govt_emp_cnic : '—' ?></td>
                                <td><button class="btn btn-icon btn-sm btn-danger btn-del-spouse" data-id="<?= $s->id ?>"><i class="anticon anticon-delete"></i></button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($spouses)): ?><p class="text-muted font-size-13" id="spouse-empty">No spouse records.</p><?php endif; ?>
                <div class="text-right m-t-10">
                    <button class="btn btn-sm btn-success btn-mark-done" data-section="spouse_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 6 — CHILDREN
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="child-body">
                <i class="anticon anticon-smile m-r-10 text-orange"></i>
                <span class="font-weight-semibold">Children</span>
                <?php if (!empty($sections->children_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="child-body" style="display:none">
                <div class="border rounded p-15 m-b-15 bg-light">
                    <div class="row">
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" id="ch_name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Gender</label>
                            <select id="ch_gender" class="form-control form-control-sm">
                                <option value="">—</option>
                                <option>Male</option><option>Female</option>
                            </select>
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Date of Birth</label>
                            <input type="date" id="ch_dob" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">School / College</label>
                            <input type="text" id="ch_school" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button class="btn btn-sm btn-primary" id="btn-add-child">
                                <i class="anticon anticon-plus m-r-5"></i> Add Child
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="child-table">
                        <thead class="thead-light">
                            <tr><th>Name</th><th>Gender</th><th>DOB</th><th>School</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $c): ?>
                            <tr id="ch-row-<?= $c->id ?>">
                                <td><?= htmlspecialchars($c->name) ?></td>
                                <td><?= isset($c->gender) ? $c->gender : '—' ?></td>
                                <td>
                                    <?= !empty($c->dob) ? date('d M Y', strtotime($c->dob)) : '—' ?>
                                </td>
                                <td><?= htmlspecialchars(isset($c->school_name) ? $c->school_name : '—') ?></td>
                                <td><button class="btn btn-icon btn-sm btn-danger btn-del-child" data-id="<?= $c->id ?>"><i class="anticon anticon-delete"></i></button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($children)): ?><p class="text-muted font-size-13" id="child-empty">No children records.</p><?php endif; ?>
                <div class="text-right m-t-10">
                    <button class="btn btn-sm btn-success btn-mark-done" data-section="children_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>

        <!-- ════════════════════════════════════════════════════
             SECTION 7 — POSTING
        ═════════════════════════════════════════════════════ -->
        <div class="card m-b-15">
            <div class="card-header d-flex align-items-center" style="cursor:pointer" data-toggle-section="post-body">
                <i class="anticon anticon-environment m-r-10 text-cyan"></i>
                <span class="font-weight-semibold">Posting History</span>
                <?php if (!empty($sections->posting_done)): ?>
                <span class="badge badge-success badge-pill m-l-10">Complete</span>
                <?php endif; ?>
                <i class="anticon anticon-down m-l-auto section-arrow"></i>
            </div>
            <div class="card-body" id="post-body" style="display:none">
                <div class="border rounded p-15 m-b-15 bg-light">
                    <div class="row">
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Post Name</label>
                            <input type="text" id="po_name" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Pay Scale</label>
                            <select id="po_bps" class="form-control form-control-sm">
                                <option value="">—</option>
                                <?php for ($b=1;$b<=22;$b++): ?><option><?= $b ?></option><?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Posting Place</label>
                            <input type="text" id="po_place" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Start Date</label>
                            <input type="date" id="po_date" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Transfer Status</label>
                            <select id="po_status" class="form-control form-control-sm">
                                <option>On Post</option>
                                <option>Transferred</option>
                                <option>On Leave</option>
                                <option>Deputation</option>
                            </select>
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Sanctioned Name</label>
                            <input type="text" id="po_sanctioned" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 m-b-10">
                            <label class="font-size-12 font-weight-semibold">Additional Charge</label>
                            <input type="text" id="po_additional" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3 m-b-10 d-flex align-items-end">
                            <label class="m-b-0">
                                <input type="checkbox" id="po_current"> Currently on Post
                            </label>
                        </div>
                        <div class="col-md-12 m-t-5">
                            <button class="btn btn-sm btn-primary" id="btn-add-posting">
                                <i class="anticon anticon-plus m-r-5"></i> Add Posting
                            </button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="post-table">
                        <thead class="thead-light">
                            <tr><th>Post</th><th>BPS</th><th>Place</th><th>Start Date</th><th>Status</th><th>Current</th><th></th></tr>
                        </thead>
                        <tbody>
                            <?php foreach ($postings as $po): ?>
                            <tr id="po-row-<?= $po->id ?>">
                                <td><?= htmlspecialchars(isset($po->post_name) ? $po->post_name : '—') ?></td>
                                <td><?= !empty($po->pay_scale) ? 'BPS-'.$po->pay_scale : '—' ?></td>
                                <td><?= htmlspecialchars(isset($po->posting_place) ? $po->posting_place : '—') ?></td>
                                <td><?= $po->appointment_start_date ? date('d M Y',strtotime($po->appointment_start_date)) : '—' ?></td>
                                <td><?= $po->transfer_status ?></td>
                                <td><?= $po->currently_on_post ? '<span class="badge badge-success">Yes</span>' : 'No' ?></td>
                                <td><button class="btn btn-icon btn-sm btn-danger btn-del-posting" data-id="<?= $po->id ?>"><i class="anticon anticon-delete"></i></button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (empty($postings)): ?><p class="text-muted font-size-13" id="post-empty">No posting records.</p><?php endif; ?>
                <div class="text-right m-t-10">
                    <button class="btn btn-sm btn-success btn-mark-done" data-section="posting_done" data-emp="<?= $emp_id ?>">
                        <i class="anticon anticon-check m-r-5"></i> Mark Complete
                    </button>
                </div>
            </div>
        </div>
        <!-- end cards -->

    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- ── JavaScript ───────────────────────────────────────── -->
<script>
var EMP_ID = <?= $emp_id ?>;
var BASE   = '<?= base_url() ?>';

// ── Section accordion
document.querySelectorAll('[data-toggle-section]').forEach(function(hdr) {
    hdr.addEventListener('click', function() {
        var target = document.getElementById(this.getAttribute('data-toggle-section'));
        var arrow  = this.querySelector('.section-arrow');
        if (target.style.display === 'none' || !target.style.display) {
            target.style.display = 'block';
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            target.style.display = 'none';
            if (arrow) arrow.style.transform = '';
        }
    });
});

// ── Delete confirmation
document.querySelector('.btn-confirm-delete') && document.querySelector('.btn-confirm-delete').addEventListener('click', function(e) {
    if (!confirm('Delete employee "' + this.dataset.name + '"? This cannot be undone.')) e.preventDefault();
});

// ── AJAX helper
function ajaxPost(url, formData, cb) {
    $.ajax({ url: BASE + url, method: 'POST', data: formData, dataType: 'json',
             success: function(r) { cb(r); },
             error: function() { alert('Request failed. Please try again.'); } });
}

// ── Mark section complete
$(document).on('click', '.btn-mark-done', function() {
    var btn = $(this);
    var section = btn.data('section');
    var emp     = btn.data('emp');
    $.post(BASE + 'employee/ajax_complete_section', { emp_id: emp, section: section }, function(r) {
        if (r.success) {
            btn.replaceWith('<span class="badge badge-success font-size-12 p-h-12 p-v-5"><i class="anticon anticon-check m-r-4"></i>Complete</span>');
        }
    }, 'json');
});

// ════ EDUCATION ═══════════════════════════════════════════
$('#btn-add-edu').on('click', function() {
    var level = $('#edu_level').val().trim();
    if (!level) { alert('Education level is required.'); return; }
    var fd = {
        emp_id: EMP_ID, level: level,
        board_university: $('#edu_board').val(),
        ending_month: $('#edu_month').val(),
        ending_year: $('#edu_year').val(),
        total_marks: $('#edu_total').val(),
        obtained_marks: $('#edu_obtained').val(),
        percentage: $('#edu_pct').val()
    };
    ajaxPost('employee/ajax_add_education', fd, function(r) {
        if (!r.success) { alert(r.message); return; }
        $('#edu-empty').hide();
        var row = '<tr id="edu-row-'+r.data.id+'">'
            + '<td>'+htmlEsc(r.data.level)+'</td>'
            + '<td>'+htmlEsc(r.data.board_university||'—')+'</td>'
            + '<td>'+(r.data.ending_month||'')+' '+(r.data.ending_year||'')+'</td>'
            + '<td>'+(r.data.total_marks||'—')+'</td>'
            + '<td>'+(r.data.obtained_marks||'—')+'</td>'
            + '<td>'+(r.data.percentage ? r.data.percentage+'%' : '—')+'</td>'
            + '<td><button class="btn btn-icon btn-sm btn-danger btn-del-edu" data-id="'+r.data.id+'"><i class="anticon anticon-delete"></i></button></td>'
            + '</tr>';
        $('#edu-table tbody').append(row);
        $('#edu_level,#edu_board,#edu_year,#edu_total,#edu_obtained,#edu_pct').val('');
        $('#edu_month').val('');
    });
});
$(document).on('click', '.btn-del-edu', function() {
    if (!confirm('Remove this education record?')) return;
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_education', { id: id }, function(r) {
        if (r.success) $('#edu-row-'+id).remove();
    });
});

// ════ SPECIALITY ══════════════════════════════════════════
$('#btn-add-spec').on('click', function() {
    var spec = $('#spec-input').val().trim();
    if (!spec) return;
    ajaxPost('employee/ajax_add_speciality', { emp_id: EMP_ID, speciality: spec }, function(r) {
        if (!r.success) return;
        $('#spec-empty').hide();
        var tag = '<span class="badge badge-cyan badge-pill font-size-13 p-h-12 p-v-5" id="spec-item-'+r.data.id+'">'
            + htmlEsc(r.data.speciality)
            + ' <a href="#" class="m-l-5 text-white del-spec" data-id="'+r.data.id+'">&times;</a></span>';
        $('#spec-list').append(tag);
        $('#spec-input').val('');
    });
});
$(document).on('click', '.del-spec', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_speciality', { id: id }, function(r) {
        if (r.success) $('#spec-item-'+id).remove();
    });
});

// ════ TRAINING ════════════════════════════════════════════
$('#btn-add-train').on('click', function() {
    var name = $('#tr_name').val().trim();
    if (!name) { alert('Training name required.'); return; }
    var fd = {
        emp_id: EMP_ID, training_name: name, institute: $('#tr_inst').val(),
        start_month: $('#tr_sm').val(), start_year: $('#tr_sy').val(),
        end_month: $('#tr_em').val(), end_year: $('#tr_ey').val(),
        duration_days: $('#tr_days').val()
    };
    ajaxPost('employee/ajax_add_training', fd, function(r) {
        if (!r.success) { alert(r.message); return; }
        $('#train-empty').hide();
        var row = '<tr id="tr-row-'+r.data.id+'">'
            + '<td>'+htmlEsc(r.data.training_name)+'</td>'
            + '<td>'+htmlEsc(r.data.institute||'—')+'</td>'
            + '<td>'+(r.data.start_month||'')+' '+(r.data.start_year||'')+'</td>'
            + '<td>'+(r.data.end_month||'')+' '+(r.data.end_year||'')+'</td>'
            + '<td>'+(r.data.duration_days||'—')+'</td>'
            + '<td><button class="btn btn-icon btn-sm btn-danger btn-del-train" data-id="'+r.data.id+'"><i class="anticon anticon-delete"></i></button></td>'
            + '</tr>';
        $('#train-table tbody').append(row);
        $('#tr_name,#tr_inst,#tr_sy,#tr_ey,#tr_days').val('');
        $('#tr_sm,#tr_em').val('');
    });
});
$(document).on('click', '.btn-del-train', function() {
    if (!confirm('Remove training record?')) return;
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_training', { id: id }, function(r) {
        if (r.success) $('#tr-row-'+id).remove();
    });
});

// ════ SPOUSE ══════════════════════════════════════════════
$('#btn-add-spouse').on('click', function() {
    var name = $('#sp_name').val().trim();
    if (!name) { alert('Spouse name required.'); return; }
    var fd = {
        emp_id: EMP_ID, spouse_name: name,
        is_govt_employee: $('#sp_govt').val(),
        govt_emp_cnic: $('#sp_cnic').val()
    };
    ajaxPost('employee/ajax_add_spouse', fd, function(r) {
        if (!r.success) return;
        $('#spouse-empty').hide();
        var row = '<tr id="sp-row-'+r.data.id+'">'
            + '<td>'+htmlEsc(r.data.spouse_name)+'</td>'
            + '<td>'+(r.data.is_govt_employee=='1'?'Yes':'No')+'</td>'
            + '<td>'+htmlEsc(r.data.govt_emp_cnic||'—')+'</td>'
            + '<td><button class="btn btn-icon btn-sm btn-danger btn-del-spouse" data-id="'+r.data.id+'"><i class="anticon anticon-delete"></i></button></td>'
            + '</tr>';
        $('#spouse-table tbody').append(row);
        $('#sp_name,#sp_cnic').val('');
        $('#sp_govt').val('0');
    });
});
$(document).on('click', '.btn-del-spouse', function() {
    if (!confirm('Remove spouse record?')) return;
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_spouse', { id: id }, function(r) {
        if (r.success) $('#sp-row-'+id).remove();
    });
});

// ════ CHILDREN ════════════════════════════════════════════
$('#btn-add-child').on('click', function() {
    var name = $('#ch_name').val().trim();
    if (!name) { alert('Child name required.'); return; }
    var fd = {
        emp_id: EMP_ID, name: name,
        gender: $('#ch_gender').val(),
        dob: $('#ch_dob').val(),
        school_name: $('#ch_school').val()
    };
    ajaxPost('employee/ajax_add_child', fd, function(r) {
        if (!r.success) return;
        $('#child-empty').hide();
        var row = '<tr id="ch-row-'+r.data.id+'">'
            + '<td>'+htmlEsc(r.data.name)+'</td>'
            + '<td>'+(r.data.gender||'—')+'</td>'
            + '<td>'+(r.data.dob||'—')+'</td>'
            + '<td>'+htmlEsc(r.data.school_name||'—')+'</td>'
            + '<td><button class="btn btn-icon btn-sm btn-danger btn-del-child" data-id="'+r.data.id+'"><i class="anticon anticon-delete"></i></button></td>'
            + '</tr>';
        $('#child-table tbody').append(row);
        $('#ch_name,#ch_dob,#ch_school').val('');
        $('#ch_gender').val('');
    });
});
$(document).on('click', '.btn-del-child', function() {
    if (!confirm('Remove child record?')) return;
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_child', { id: id }, function(r) {
        if (r.success) $('#ch-row-'+id).remove();
    });
});

// ════ POSTING ═════════════════════════════════════════════
$('#btn-add-posting').on('click', function() {
    var fd = {
        emp_id: EMP_ID,
        post_name: $('#po_name').val(),
        pay_scale: $('#po_bps').val(),
        posting_place: $('#po_place').val(),
        appointment_start_date: $('#po_date').val(),
        transfer_status: $('#po_status').val(),
        sanctioned_name: $('#po_sanctioned').val(),
        additional_charge: $('#po_additional').val(),
        currently_on_post: $('#po_current').is(':checked') ? 1 : 0
    };
    ajaxPost('employee/ajax_add_posting', fd, function(r) {
        if (!r.success) { alert(r.message); return; }
        $('#post-empty').hide();
        var row = '<tr id="po-row-'+r.data.id+'">'
            + '<td>'+htmlEsc(r.data.post_name||'—')+'</td>'
            + '<td>'+(r.data.pay_scale?'BPS-'+r.data.pay_scale:'—')+'</td>'
            + '<td>'+htmlEsc(r.data.posting_place||'—')+'</td>'
            + '<td>'+(r.data.appointment_start_date||'—')+'</td>'
            + '<td>'+(r.data.transfer_status||'—')+'</td>'
            + '<td>'+(r.data.currently_on_post=='1'?'<span class="badge badge-success">Yes</span>':'No')+'</td>'
            + '<td><button class="btn btn-icon btn-sm btn-danger btn-del-posting" data-id="'+r.data.id+'"><i class="anticon anticon-delete"></i></button></td>'
            + '</tr>';
        $('#post-table tbody').append(row);
        $('#po_name,#po_place,#po_date,#po_sanctioned,#po_additional').val('');
        $('#po_bps,#po_status').val($('#po_status option:first').val());
        $('#po_current').prop('checked', false);
    });
});
$(document).on('click', '.btn-del-posting', function() {
    if (!confirm('Remove posting record?')) return;
    var id = $(this).data('id');
    ajaxPost('employee/ajax_delete_posting', { id: id }, function(r) {
        if (r.success) $('#po-row-'+id).remove();
    });
});

// XSS helper
function htmlEsc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>