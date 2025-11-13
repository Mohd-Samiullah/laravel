<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax CRUD Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">AJAX CRUD Operations</h2>

        <!-- Form for Create and Update -->
        <form id="ajaxForm">
            @csrf
            <input type="hidden" name="record_id" id="record_id">

            <div class="row">
                <div class="col-md-5">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                </div>
                <div class="col-md-5">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control"
                        placeholder="Enter your location">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-md w-100" id="submitBtn">Submit</button>
                    <button type="button" class="btn btn-secondary btn-md w-90 d-none ms-1"
                        id="cancelBtn">Cancel</button>
                </div>
            </div>
        </form>

        <!-- Records Table -->
        <table class="table table-bordered mt-4 text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="recordTable">
                <!-- Records will be automatically loaded here when page loads -->
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        // Load all records automatically when page loads
        fetchRecords();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Form submit for Create and Update
        $('#ajaxForm').on('submit', function(e) {
            e.preventDefault();

            let recordId = $('#record_id').val();
            let name = $('#name').val();
            let location = $('#location').val();

            if (recordId) {
                // Update existing record
                updateRecord(recordId, name, location);
            } else {
                // Create new record
                createRecord(name, location);
            }
        });

        // Cancel edit
        $('#cancelBtn').on('click', function() {
            resetForm();
        });

        // Function to create new record
        function createRecord(name, location) {
            $.ajax({
                url: "{{ route('ajaxinsert') }}",
                type: "POST",
                data: {
                    name: name,
                    location: location
                },
                success: function(response) {
                    alert(response.message);
                    $('#ajaxForm')[0].reset();
                    fetchRecords();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(Object.values(errors).join('\n'));
                    } else {
                        alert('Something went wrong!');
                    }
                }
            });
        }

        // Function to update record
        function updateRecord(id, name, location) {
            $.ajax({
                url: "{{ route('ajaxupdate', '') }}/" + id,
                type: "POST",
                data: {
                    _method: 'PUT',
                    name: name,
                    location: location
                },
                success: function(response) {
                    alert(response.message);
                    resetForm();
                    fetchRecords();
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert(Object.values(errors).join('\n'));
                    } else {
                        alert('Something went wrong!');
                    }
                }
            });
        }

        // Function to fetch all records and display in table
        function fetchRecords() {
            $.ajax({
                url: "{{ route('ajaxfetch') }}",
                type: "GET",
                success: function(response) {
                    let tbody = '';

                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function(index, record) {
                            tbody += `<tr>
                                <td>${index + 1}</td>
                                <td>${record.name}</td>
                                <td>${record.location}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit-btn" data-id="${record.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${record.id}">Delete</button>
                                </td>
                            </tr>`;
                        });
                    } else {
                        tbody =
                            `<tr><td colspan="4" class="text-center">No records found</td></tr>`;
                    }

                    $('#recordTable').html(tbody);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    $('#recordTable').html(
                        '<tr><td colspan="4" class="text-center text-danger">Error loading records</td></tr>'
                    );
                }
            });
        }

        // Reset form to create mode
        function resetForm() {
            $('#ajaxForm')[0].reset();
            $('#record_id').val('');
            $('#submitBtn').text('Submit').removeClass('btn-success').addClass('btn-info');
            $('#cancelBtn').addClass('d-none');
        }

        // Edit button click event
        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('ajaxedit', '') }}/" + id,
                type: "GET",
                success: function(response) {
                    $('#record_id').val(response.data.id);
                    $('#name').val(response.data.name);
                    $('#location').val(response.data.location);
                    $('#submitBtn').text('Update').removeClass('btn-info').addClass(
                        'btn-success');
                    $('#cancelBtn').removeClass('d-none');
                },
                error: function(xhr) {
                    alert('Error fetching record data!');
                }
            });
        });

        // Delete button click event
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');

            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: "{{ route('ajaxdelete', '') }}/" + id,
                    type: "POST",
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        alert(response.message);
                        fetchRecords();
                    },
                    error: function(xhr) {
                        alert('Error deleting record!');
                    }
                });
            }
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>