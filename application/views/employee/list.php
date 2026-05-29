<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-container">
    <div class="main-content">

        <div class="page-header">
            <h4 class="page-title">Employee Records</h4>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Employees</span>
                </nav>
            </div>
        </div>

        <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="anticon anticon-check-circle m-r-5"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="anticon anticon-close-circle m-r-5"></i>
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:10px">
                <h5 class="card-title m-b-0">
                    All Employees
                    <span class="badge badge-cyan badge-pill m-l-10"><?= count($employees) ?></span>
                </h5>
                <div class="d-flex align-items-center" style="gap:8px;flex-wrap:wrap">
                    <!-- Search -->
                    <form method="GET" action="<?= base_url('employee') ?>" class="d-flex" style="gap:6px">
                        <div class="input-group" style="width:260px">
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="Search name, CNIC, code…"
                                   value="<?= htmlspecialchars(isset($search) ? $search : '') ?>">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-default" type="submit">
                                    <i class="anticon anticon-search"></i>
                                </button>
                            </div>
                        </div>
                        <?php if (!empty($search)): ?>
                        <a href="<?= base_url('employee') ?>" class="btn btn-sm btn-default">
                            <i class="anticon anticon-close"></i> Clear
                        </a>
                        <?php endif; ?>
                    </form>
                    <a href="<?= base_url('employee/add') ?>" class="btn btn-sm btn-primary">
                        <i class="anticon anticon-user-add m-r-5"></i> Add Employee
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <?php if (!empty($employees)): ?>
                <div class="table-responsive">
                    <table class="table table-hover m-b-0" id="emp-table">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>CNIC</th>
                                <th>Contact</th>
                                <th>BPS</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $i => $emp): ?>
                            <tr>
                                <td class="text-muted font-size-13"><?= $i + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-icon avatar-sm avatar-blue m-r-10" style="font-size:14px;font-weight:700">
                                            <?= strtoupper(substr($emp->full_name, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="m-b-0 font-weight-semibold"><?= htmlspecialchars($emp->full_name) ?></p>
                                            <small class="text-muted"><?= $emp->emp_code ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="font-size-13">
                                    <?= isset($emp->cnic) ? $emp->cnic : '—' ?>
                                </td>

                                <td class="font-size-13">
                                    <?= isset($emp->contact_no) ? $emp->contact_no : '—' ?>
                                </td>

                                <td>
                                    <?php if (!empty($emp->current_bps)): ?>
                                        <span class="badge badge-default badge-pill">
                                            BPS-<?= $emp->current_bps ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                    $status_class = array(
                                        'Permanent'   => 'badge-success',
                                        'Contract'    => 'badge-warning',
                                        'Daily Wages' => 'badge-orange',
                                        'Deputation'  => 'badge-blue',
                                    );

                                    $cls = isset($status_class[$emp->job_status])
                                        ? $status_class[$emp->job_status]
                                        : 'badge-default';
                                    ?>

                                    <span class="badge <?= $cls ?> badge-pill">
                                        <?= isset($emp->job_status) ? $emp->job_status : '—' ?>
                                    </span>
                                </td>
                                <td class="text-muted font-size-13">
                                    <?= $emp->joining_date ? date('d M Y', strtotime($emp->joining_date)) : '—' ?>
                                </td>
                                <td>
                                    <div class="d-flex" style="gap:4px">
                                        <a href="<?= base_url('employee/profile/'.$emp->id) ?>"
                                           class="btn btn-icon btn-sm btn-default" title="View Profile">
                                            <i class="anticon anticon-eye"></i>
                                        </a>
                                        <a href="<?= base_url('employee/edit_personal/'.$emp->id) ?>"
                                           class="btn btn-icon btn-sm btn-default" title="Edit">
                                            <i class="anticon anticon-edit"></i>
                                        </a>
                                        <?php if (in_array($this->session->userdata('role'), [1, 'admin'])): ?>
                                        <a href="<?= base_url('employee/delete/'.$emp->id) ?>"
                                           class="btn btn-icon btn-sm btn-danger btn-delete" title="Delete"
                                           data-name="<?= htmlspecialchars($emp->full_name) ?>">
                                            <i class="anticon anticon-delete"></i>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center p-v-50 text-muted">
                    <i class="anticon anticon-team font-size-50 d-block m-b-15 opacity-04"></i>
                    <p class="font-size-16">
                        <?= !empty($search) ? 'No employees match your search.' : 'No employee records yet.' ?>
                    </p>
                    <?php if (!empty($search)): ?>
                    <a href="<?= base_url('employee') ?>" class="btn btn-default m-r-5">Clear Search</a>
                    <?php endif; ?>
                    <a href="<?= base_url('employee/add') ?>" class="btn btn-primary">
                        <i class="anticon anticon-user-add m-r-5"></i> Add First Employee
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Delete confirmation
document.querySelectorAll('.btn-delete').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        var name = this.getAttribute('data-name');
        if (confirm('Delete employee "' + name + '"?\n\nThis cannot be undone.')) {
            window.location.href = this.href;
        }
    });
});
</script>