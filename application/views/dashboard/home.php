<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-container">
    <!-- Content Wrapper START -->
    <div class="main-content">
        <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Dashboard</span>
                </nav>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row">
            <!-- Total Employees -->
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="m-b-0 text-muted">Total Employees</p>
                                <h2 class="m-b-0 font-weight-semibold"><?= $total_emp ?></h2>
                                <small class="text-muted">All records</small>
                            </div>
                            <div class="avatar avatar-icon avatar-lg avatar-blue">
                                <i class="anticon anticon-team"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Permanent -->
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="m-b-0 text-muted">Permanent</p>
                                <h2 class="m-b-0 font-weight-semibold"><?= $permanent ?></h2>
                                <small class="text-success">Regular staff</small>
                            </div>
                            <div class="avatar avatar-icon avatar-lg avatar-green">
                                <i class="anticon anticon-idcard"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contract -->
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="m-b-0 text-muted">Contract</p>
                                <h2 class="m-b-0 font-weight-semibold"><?= $contract ?></h2>
                                <small class="text-warning">Contract staff</small>
                            </div>
                            <div class="avatar avatar-icon avatar-lg avatar-gold">
                                <i class="anticon anticon-file-text"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New This Month -->
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="m-b-0 text-muted">New This Month</p>
                                <h2 class="m-b-0 font-weight-semibold"><?= $new_this_month ?></h2>
                                <small class="text-primary"><?= date('F Y') ?></small>
                            </div>
                            <div class="avatar avatar-icon avatar-lg avatar-purple">
                                <i class="anticon anticon-user-add"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Stats Row -->

        <div class="row">
            <!-- BPS Distribution -->
            <div class="col-md-12 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">BPS Distribution</h5>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($bps_data)): ?>
                        <div class="table-responsive">
                            <table class="table table-borderless m-b-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Pay Scale (BPS)</th>
                                        <th>Count</th>
                                        <th>Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bps_data as $row): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-cyan badge-pill">
                                                BPS-<?= isset($row->current_bps) ? $row->current_bps : 'N/A' ?>
                                            </span>
                                        </td>
                                        <td class="font-weight-semibold"><?= $row->cnt ?></td>
                                        <td>
                                            <?php $pct = $total_emp > 0 ? round(($row->cnt / $total_emp) * 100, 1) : 0; ?>
                                            <div class="d-flex align-items-center">
                                                <div class="progress m-r-10" style="width:80px;height:6px;">
                                                    <div class="progress-bar bg-cyan" style="width:<?= $pct ?>%"></div>
                                                </div>
                                                <span class="text-muted font-size-13"><?= $pct ?>%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center p-v-30 text-muted">
                            <i class="anticon anticon-bar-chart font-size-40 d-block m-b-10 opacity-04"></i>
                            No data available
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-md-12 col-lg-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-b-0">Recently Added Employees</h5>
                        <a href="<?= base_url('employee') ?>" class="btn btn-sm btn-default">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($recent)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>BPS</th>
                                        <th>Status</th>
                                        <th>Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent as $emp): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-icon avatar-sm avatar-blue m-r-10">
                                                    <?= strtoupper(substr($emp->full_name, 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <p class="m-b-0 font-weight-semibold"><?= htmlspecialchars($emp->full_name) ?></p>
                                                    <small class="text-muted font-size-12"><?= $emp->emp_code ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($emp->current_bps): ?>
                                            <span class="badge badge-default badge-pill">BPS-<?= $emp->current_bps ?></span>
                                            <?php else: ?>
                                            <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status_class = [
                                                'Permanent'   => 'badge-success',
                                                'Contract'    => 'badge-warning',
                                                'Daily Wages' => 'badge-orange',
                                                'Deputation'  => 'badge-blue',
                                            ];
                                            $cls = isset($status_class[$emp->job_status]) ? $status_class[$emp->job_status] : 'badge-default';
                                            ?>
                                            <span class="badge <?= $cls ?> badge-pill"><?= $emp->job_status ?></span>
                                        </td>
                                        <td class="text-muted font-size-13">
                                            <?= date('d M Y', strtotime($emp->joining_date)) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center p-v-30 text-muted">
                            <i class="anticon anticon-team font-size-40 d-block m-b-10 opacity-04"></i>
                            No employees found. <a href="<?= base_url('employee/add') ?>">Add the first one.</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

        <!-- Quick Action Cards -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 m-b-10">
                                <a href="<?= base_url('employee/add') ?>" class="card card-body text-center border hover-shadow-sm">
                                    <i class="anticon anticon-user-add font-size-30 text-primary m-b-10"></i>
                                    <p class="m-b-0 font-weight-semibold">Add Employee</p>
                                    <small class="text-muted">Register new staff</small>
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 m-b-10">
                                <a href="<?= base_url('employee') ?>" class="card card-body text-center border hover-shadow-sm">
                                    <i class="anticon anticon-team font-size-30 text-success m-b-10"></i>
                                    <p class="m-b-0 font-weight-semibold">All Employees</p>
                                    <small class="text-muted">Browse & search records</small>
                                </a>
                            </div>
                            <?php if (in_array($this->session->userdata('role'), [1, 'admin'])): ?>
                            <div class="col-md-3 col-sm-6 m-b-10">
                                <a href="<?= base_url('users/user_list') ?>" class="card card-body text-center border hover-shadow-sm">
                                    <i class="anticon anticon-setting font-size-30 text-warning m-b-10"></i>
                                    <p class="m-b-0 font-weight-semibold">Manage Users</p>
                                    <small class="text-muted">System user accounts</small>
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-3 col-sm-6 m-b-10">
                                <a href="#" class="card card-body text-center border hover-shadow-sm">
                                    <i class="anticon anticon-file-pdf font-size-30 text-danger m-b-10"></i>
                                    <p class="m-b-0 font-weight-semibold">Reports</p>
                                    <small class="text-muted">Print employee records</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Content Wrapper END -->
</div>