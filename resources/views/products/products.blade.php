@extends('layouts.app')

@section('content')
    <div class="main-block py-main">
        <div class="container-fluid">
            <div class="bg-lightTran box-padding">

                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-left">
                            <h2>Operators</h2>
                        </div>
                        <div class="modal-header">
                            <a class="btn btn-success" onClick="add()" href="javascript:void(0)">Create Operator</a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered" id="products">
                        <thead>
                            <tr>
                                <th>EMPLOYEE NO</th>
                                <th>NAME</th>
                                <th>QUARANTINE PRIV</th>
                                <th>TASK PRIV</th>
                                <th>PICK OVERRIDE PRIV</th>
                                <th>CREATED BY</th>
                                <th>STATUS</th>
                                <th>LAST UPDATED</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- boostrap product model -->
    <div class="modal fade" id="product-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ProductModal"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="ProductForm" name="ProductForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="employeeNumber" class="col-sm-2 control-label">employeeNumber</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="employeeNumber" name="employeeNumber"
                                    placeholder="Product name" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="operatorName" class="col-sm-2 control-label">operatorName</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="operatorName" name="operatorName"
                                    placeholder="Product name" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pattern" class="mb-0">quarPriv</label>
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="quarPriv" id="quarPriv_yes"
                                        value="Yes">
                                    <label class="form-check-label" for="quarPriv_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="quarPriv" id="quarPriv_no"
                                        value="No">
                                    <label class="form-check-label" for="quarPriv_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pattern" class="mb-0">taskPriv</label>
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="taskPriv" id="taskPriv_yes"
                                        value="Yes">
                                    <label class="form-check-label" for="taskPriv_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="taskPriv" id="taskPriv_no"
                                        value="No" checked="">
                                    <label class="form-check-label" for="taskPriv_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pattern" class="mb-0">pickOverridePriv</label>
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pickOverridePriv"
                                        id="pickOverridePriv_yes" value="Yes">
                                    <label class="form-check-label" for="pickOverridePriv_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pickOverridePriv"
                                        id="pickOverridePriv_no" value="No" checked="">
                                    <label class="form-check-label" for="pickOverridePriv_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pattern" class="mb-0">is_active</label>
                            <div class="col-sm-12">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_yes"
                                        value="Active">
                                    <label class="form-check-label" for="is_active_yes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_active" id="is_active_no"
                                        value="Inactive" checked="">
                                    <label class="form-check-label" for="is_active_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
                            <button type="button" class="btn btn-secondary ml-2" id="btn-reset">Reset</button>
                        </div>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                </div> --}}
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    <script type="text/javascript">
        $(document).ready(function() {
            // Event listener for the reset button
            $('#btn-reset').click(function() {
                $('#ProductForm').trigger("reset");
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#products').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('products') }}",
                columns: [
                    // {
                    //     data: 'id',
                    //     name: 'id'
                    // },
                    {
                        data: 'employeeNumber',
                        name: 'employeeNumber',
                    },
                    {
                        data: 'operatorName',
                        name: 'operatorName'
                    },
                    {
                        data: 'quarPriv',
                        name: 'quarPriv'
                    },
                    {
                        data: 'taskPriv',
                        name: 'taskPriv'
                    },
                    {
                        data: 'pickOverridePriv',
                        name: 'pickOverridePriv'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        function add() {
            $('#ProductForm').trigger("reset");
            $('#ProductModal').html("Add New Operator");
            $('#product-modal').modal('show');
            $('#id').val('');
        }

        function editFunc(id) {
            $.ajax({
                type: "POST",
                url: "{{ url('edit-product') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#ProductModal').html("Edit Operator");
                    $('#product-modal').modal('show');
                    $('#id').val(res.id);
                    $('#employeeNumber').val(res.employeeNumber);
                    $('#operatorName').val(res.operatorName);
                    $('input:radio[name=quarPriv][value=' + res.quarPriv + ']').prop('checked',
                        true); //setting logic for radio button
                    $('input:radio[name=taskPriv][value=' + res.taskPriv + ']').prop('checked', true);
                    $('input:radio[name=pickOverridePriv][value=' + res.pickOverridePriv + ']').prop('checked',
                        true);
                    $('input:radio[name=is_active][value=' + res.is_active + ']').prop('checked', true);
                }
            });
        }

        function deleteFunc(id) {
            if (confirm("Delete record?") == true) {
                var id = id;
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('delete-product') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        var oTable = $('#products').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
        $('#ProductForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('store-product') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#product-modal").modal('hide');
                    var oTable = $('#products').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection
