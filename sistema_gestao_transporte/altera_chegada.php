<html>
    <head>
        <title>Editar passageiros-CHEGADAS</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>		
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            body
            {
                margin:0;
                padding:0;
                background-color:#f1f1f1;
            }
            .box
            {
                width:1270px;
                padding:20px;
                background-color:#fff;
                border:1px solid #ccc;
                border-radius:5px;
                margin-top:25px;
            }
        </style>
    </head>
    <body>
        <div class="container box">
            <h1 align="center">Editar passageiros - CHEGADAS</h1>
            <br />
            <div class="table-responsive">
                <br />
                <div align="right">
                    <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info btn-lg">Adicionar passageiros</button>
                </div>
                <br /><br />
                <table id="user_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">Imagem</th>
                            <th width="5%">Nome</th>
                            <th width="10%">Apelido</th>
                            <th width="10%">Proveniencia</th>
                            <th width="10%">Destino</th>
                            <th width="10%">Descrição</th>
                            <th width="10%">Terceiro</th>
                            <th width="10%">Motorista</th>
                            <th width="5%">Data</th>
                            <th width="10%">Hora</th>
                            <th width="10%">Voo</th>
                            <th width="5%">Edit</th>
                            <th width="5%">Delete</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">
                    <label>Enter First Name</label>
                    <input type="text" name="Nome" id="Nome" class="form-control" />
                    <br />
                    <label>Enter Last Name</label>
                    <input type="text" name="Apelido" id="Apelido" class="form-control" />
                    <br />
                    <label>Proveniencia</label>
                    <input type="text" name="Proveniencia" id="Proveniencia" class="form-control" />
                    <br />
                    <label>Destino</label>
                    <input type="text" name="Destino" id="Destino" class="form-control" />
                    <br />
                    <label>Descrição</label>
                    <input type="text" name="Descricao" id="Descricao" class="form-control" />
                    <br />
                    <label>Terceiro</label>
                    <input type="text" name="Terceiro" id="Terceiro" class="form-control" />
                    <label>Motorista</label>
                    <input type="text" name="Motorista" id="Motorista" class="form-control" />
                    <br />
                    <label>Data</label>
                    <input type="text" name="Data" id="Data" class="form-control" />
                    <br />
                    <label>Hora</label>
                    <input type="text" name="Hora" id="Hora" class="form-control" />
                    <br />
                    <label>Voo</label>
                    <input type="text" name="Voo" id="Voo" class="form-control" />
                    <br />
                    <label>Select User Image</label>
                    <input type="file" name="user_image" id="user_image" />
                    <span id="user_uploaded_image"></span>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="hidden" name="operation" id="operation" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
    $(document).ready(function () {
        $('#add_button').click(function () {
            $('#user_form')[0].reset();
            $('.modal-title').text("Add User");
            $('#action').val("Add");
            $('#operation').val("Add");
            $('#user_uploaded_image').html('');
        });

        var dataTable = $('#user_data').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "fetch.php",
                type: "POST"
            },
            "columnDefs": [
                {
                    "targets": [0, 3, 4, 5],
                    "orderable": false,
                },
            ],

        });


        $(document).on('submit', '#user_form', function (event) {
            event.preventDefault();
            var Nome = $('#Nome').val();
            var Apelido = $('#Apelido').val();
            var Proveniencia = $('#Proveniencia').val();
            var Destino= $('#Destino').val();
            var Descricao= $('#Descricao').val();
            var Motorista= $('#Terceiro').val();
            var Motorista= $('#Motorista').val();
            var Data= $('#Data').val();
            var Hora= $('#Hora').val();
            var Voo= $('#Voo').val();

            var extension = $('#user_image').val().split('.').pop().toLowerCase();
            if (extension != '')
            {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1)
                {
                    alert("Invalid Image File");
                    $('#user_image').val('');
                    return false;
                }
            }
            if (Nome != '' && Apelido != '' && Proveniencia != '' && Destino != '' && Descricao !='' && Terceiro != '' && Motorista != '' && Data != '' && Hora != '' && Voo != '')
            {
                $.ajax({
                    url: "insert.php",
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function (data)
                    {
                        alert(data);
                        $('#user_form')[0].reset();
                        $('#userModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            } else
            {
                alert("Both Fields are Required");
            }
        });

        $(document).on('click', '.update', function () {
            var user_id = $(this).attr("id");
            $.ajax({
                url: "fetch_single.php",
                method: "POST",
                data: {user_id: user_id},
                dataType: "json",
                success: function (data)
                {
                    $('#userModal').modal('show');
                    $('#Nome').val(data.Nome);
                    $('#Apelido').val(data.Apelido);
                    $('#Proveniencia').val(data.Proveniencia);
                    $('#Destino').val(data.Destino);
                    $('#Descricao').val(data.Descricao);
                    $('#Terceiro').val(data.Terceiro);
                    $('#Motorista').val(data.Motorista);
                    $('#Data').val(data.Data);
                    $('#Hora').val(data.Hora);
                    $('#Voo').val(data.Voo);


                    $('.modal-title').text("Edit User");
                    $('#user_id').val(user_id);
                    $('#user_uploaded_image').html(data.user_image);
                    $('#action').val("Edit");
                    $('#operation').val("Edit");
                }
            })
        });

        $(document).on('click', '.delete', function () {
            var user_id = $(this).attr("id");
            if (confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url: "delete.php",
                    method: "POST",
                    data: {user_id: user_id},
                    success: function (data)
                    {
                        alert(data);
                        dataTable.ajax.reload();
                    }
                });
            } else
            {
                return false;
            }
        });


    });
</script>