<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">

            <!-- Dashboard -->
            <li class="<?= ($this->router->fetch_class() == 'dashboard') ? 'active' : '' ?>">
                <a href="<?= base_url('dashboard') ?>">
                    <span class="icon-holder">
                        <i class="anticon anticon-dashboard"></i>
                    </span>
                    <span class="title">Dashboard</span>
                </a>
            </li>

            <!-- Employees -->
            <li class="nav-item dropdown <?= ($this->router->fetch_class() == 'employee') ? 'open' : '' ?>">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-team"></i>
                    </span>
                    <span class="title">Employees</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="<?= ($this->router->fetch_class() == 'employee' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">
                        <a href="<?= base_url('employee') ?>">
                            <span>All Employees</span>
                        </a>
                    </li>
                    <li class="<?= ($this->router->fetch_class() == 'employee' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">
                        <a href="<?= base_url('employee/add') ?>">
                            <span>Add Employee</span>
                        </a>
                    </li>
                </ul>
            </li>

            <?php if (in_array($this->session->userdata('role'), [1, 'admin'])): ?>
            <!-- Administration (admin only) -->
            <li class="nav-item dropdown <?= ($this->router->fetch_class() == 'users') ? 'open' : '' ?>">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-setting"></i>
                    </span>
                    <span class="title">Administration</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="<?= ($this->router->fetch_class() == 'users' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index')) ? 'active' : '' ?>">
                        <a href="<?= base_url('users/user_list') ?>">
                            <span>Manage Users</span>
                        </a>
                    </li>
                    <li class="<?= ($this->router->fetch_class() == 'users' && $this->uri->segment(2) == 'add') ? 'active' : '' ?>">
                        <a href="<?= base_url('users/add') ?>">
                            <span>Add User</span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Reports -->
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                        <i class="anticon anticon-file-text"></i>
                    </span>
                    <span class="title">Reports</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">
                            <span>Employee Report</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Print Records</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>