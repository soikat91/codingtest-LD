
<table id="datatable" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
<script>
    $(document).ready(function () {
        // Initialize DataTable via AJAX (no blade loops)
        var table = $('#datatable').DataTable({
            processing: true,
            serverSide: false,
            ajax: "{{ route('users.data') }}",
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'email' },
                { data: 'created_at', render: function (data) { return new Date(data).toLocaleString(); } },
                { data: null, orderable: false, searchable: false, render: function (data, type, row) {
                        return '<button class="editUser px-2 py-1 btn btn-primary text-white rounded" data-id="' + row.id + '">Edit</button>';
                    }
                }
            ]
        });

        // Open Edit Modal and Load Data
        $(document).on('click', '.editUser', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr).data();
            if (!row) {
                // fallback: try to get via ajax
                var id = $(this).data('id');
                $.get('/users/' + id, function (data) {
                    $('#editUserId').val(data.id);
                    $('#editUserName').val(data.name);
                    $('#editUserEmail').val(data.email);
                    var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    modal.show();
                });
                return;
            }
            $('#editUserId').val(row.id);
            $('#editUserName').val(row.name);
            $('#editUserEmail').val(row.email);
            var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
            modal.show();
        });

        // Update User via AJAX
        $(document).on('click', '#updateUserBtn', function () {
            var id = $('#editUserId').val();
            var name = $('#editUserName').val().trim();
            var email = $('#editUserEmail').val().trim();

            // Client-side basic validation
            if (!name) {
                toastr.error('Name is required');
                return;
            }
            if (!email) {
                toastr.error('Email is required');
                return;
            }

            $.ajax({
                url: '/users/' + id,
                method: 'PUT',
                data: { name: name, email: email, _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    if (res.success) {
                        toastr.success(res.message || 'User updated');
                            var instance = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
                            if (instance) instance.hide();
                        table.ajax.reload(null, false);
                    } else {
                        toastr.error(res.message || 'Update failed');
                    }
                },
                error: function (xhr) {
                    var msg = 'Update failed';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        msg = Object.values(errors).map(function (v) { return v[0]; }).join('<br>');
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    toastr.error(msg);
                }
            });
        });
    });
</script>