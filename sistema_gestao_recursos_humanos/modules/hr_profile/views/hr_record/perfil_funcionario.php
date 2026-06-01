<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>

        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a style="color:#333; font-size:16px;" href="">Gestão de Integração</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">Funcionários</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">Perfil de Funcionário</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container">
            <section class="section">
                <h2><i class="fa fa-user"></i> E-Profile</h2>
                <table class="e-profile-table">
                    <tbody>
                        <tr>
                            <td>Company</td>
                            <td>San Mateo Division</td>
                            <td>Cell Phone 1 <span style="color: red;">*</span></td>
                            <td><input type="text" name="cell_phone_1" class="form-control" value="410-804-4694"></td>
                            <td rowspan="4" class="profile-picture">
                                <img src="<?= base_url('assets/images/user.png'); ?>" alt="Profile">
                            </td>
                        </tr>
                        <tr>
                            <td>Empl. Code</td>
                            <td>00011</td>
                            <td>Cell Phone 2</td>
                            <td><input type="text" name="cell_phone_2" class="form-control" value="410-655-8723"></td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>kris@gmail.com</td>
                            <td>Email</td>
                            <td><input type="email" name="email" class="form-control" value="kris@gmail.com"></td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>HCMC</td>
                            <td>Permanent Address</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>REPUBLIC</td>
                            <td>Street</td>
                            <td><input type="text" name="street_address" class="form-control" value="228 Runamuck Pl #2808"></td>
                        </tr>
                        <tr>
                            <td>Position</td>
                            <td>Driver</td>
                            <td>Full Address</td>
                            <td><input type="text" name="full_address" class="form-control" value="228 Runamuck Pl #2808"></td>
                        </tr>
                        <tr>
                            <td>City/Province</td>
                            <td>
                                <select name="province" id="province" class="form-control" onchange="updateCities()" style="margin-bottom: 10px;">
                                    <option value="">Selecione Província</option>
                                    <option value="1">Luanda</option>
                                    <option value="2">Benguela</option>
                                    <option value="3">Kwanza Norte</option>
                                </select>
                                <select name="city" id="city" class="form-control">
                                    <option value="">Selecione Cidade</option>
                                </select>
                            </td>
                            <td>Ward</td>
                            <td>
                                <select name="ward" class="form-control">
                                    <option value="select">Select Ward</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>District</td>
                            <td>
                                <select name="district" id="district" class="form-control">
                                    <option value="">Selecione District</option>
                                    <option value="1">District 1</option>
                                    <option value="2">District 2</option>
                                    <option value="3">District 3</option>
                                </select>
                            </td>
                            <td>Country</td>
                            <td>
                                <select name="country" class="form-control">
                                    <option value="select">Select Country</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="section">
                <div style="background-color: #f1f1f1; display: flex; justify-content: space-between; align-items: center; padding: 7px; margin-bottom: 15px;">
                    <h2 style="margin: 0;">
                        <i class="fa fa-file-alt"></i> Informações do Documento
                    </h2>
                    <button type="button" class="btn btn-primary" style="background-color: #52bf11; border: none;">Add Novo Documento</button>
                </div>

                <div style="background-color: rgba(29, 201, 183, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <span style="font-size: 14px; color: #666666;">Total: 2</span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Document Type</th>
                            <th>Document No.</th>
                            <th>Nationality</th>
                            <th>Issue Date</th>
                            <th>Expiry Date</th>
                            <th>Issue Place</th>
                            <th>Remark</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ID Card</td>
                            <td>1212242122422</td>
                            <td>American</td>
                            <td>10/09/2009</td>
                            <td></td>
                            <td>Baltimore</td>
                            <td></td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px;">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>NBU</td>
                            <td>n</td>
                            <td>Swiss</td>
                            <td>01/04/2022</td>
                            <td>01/04/2022</td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px;">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="section">
                <div style="background-color: #f1f1f1; display: flex; justify-content: space-between; align-items: center; padding: 7px; margin-bottom: 15px;">
                    <h2 style="margin: 0;">
                        <i class="fa fa-phone-alt"></i> Contacto de Emergência
                    </h2>
                    <button type="button" class="btn btn-primary" style="background-color: #52bf11; border: none;">Add Novo Contacto</button>
                </div>

                <div style="background-color: rgba(29, 201, 183, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 15px;">
                    <span style="font-size: 14px; color: #666666;">Total: 3</span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Contact Phone</th>
                            <th>Contact Address</th>
                            <th>Contact Relationship</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Burak Gokgoz</td>
                            <td>05079289686</td>
                            <td>Tantavi Mh. Ester Gon Cd. Suryapi Exen Kule</td>
                            <td></td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px;">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>sdfsfs</td>
                            <td>fsdfs</td>
                            <td>dfsdf</td>
                            <td>sdfsdfsdf</td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px;">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Test contract</td>
                            <td>Test contract</td>
                            <td>hello town</td>
                            <td>NSA</td>
                            <td>
                                <div class="action-buttons" style="display: flex; gap: 5px;">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </div>
    </div>
</div>

<style>
    /* Centralizar conteúdo no meio da tela */
    #wrappe {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    body {
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        width: 100%;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .section {
        margin-bottom: 20px;
    }

    h2 {
        padding-bottom: 5px;
        margin-bottom: 15px;
        color: #007bff;
    }

    h2 i {
        margin-right: 8px;
    }

    .e-profile-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background-color: #fff;
    }

    .e-profile-table td {
        border: 1px solid #ddd;
        padding: 10px;
        vertical-align: middle;
        font-size: 14px;
    }

    .e-profile-table .profile-picture {
        text-align: center;
        vertical-align: top;
    }

    .e-profile-table .profile-picture img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 2px solid black;
    }

    h2 {
        font-size: 18px;
        color: #007bff;
        margin-bottom: 15px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 7px;
        text-align: left;
        vertical-align: middle;
    }

    .e-profile-table tr:first-child {
        background-color: transparent;
    }

    table th {
        background-color: #0961a5;
        color: white;
    }

    table tr:first-child {
        background-color: #f1f1f1;
    }

    table tr:first-child td {
        color: #333;
    }

    table tbody tr {
        border-top: 0;
    }

    body {
        font-family: 'Roboto', sans-serif;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    table .btn {
        padding: 2px 4px;
        font-size: 12px;
        border-radius: 4px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: background-color 0.3s ease, border-color 0.3s ease;
        text-align: center;
        min-width: 30px;
    }

    table .btn-warning {
        background-color: white;
        color: #ffc107;
        border-color: #ffc107;
    }

    table .btn-warning:hover {
        background-color: #e0a800;
    }

    table .btn-danger {
        background-color: white;
        color: #dc3545;
        border-color: #dc3545;
    }

    table .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<?php init_tail(); ?>
