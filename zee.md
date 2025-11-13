<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <style>
        .text-muted {
            display: none !important;
        }

        .search-container {
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Success Alert for Insert -->
        @if(session('insert_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data has been inserted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Success Alert for Update -->
        @if(session('update_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Data has been updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Search and Add buttons moved outside the table -->
        <div class="d-flex justify-content-between align-items-center search-container">
            <form action="{{url('/view')}}" method="GET" class="d-flex">
                <input type="search" name="search" class="form-control me-2" placeholder="Search the records">
                <input type="submit" class="btn btn-success" value="Search">
            </form>
            <div>
                <a href="{{url('/form')}}" class="btn btn-info">Add</a>
                <a href="{{url('/logout')}}" class="btn btn-danger">logout</a>
            </div>
        </div>

        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>empid</th>
                    <th>fullname</th>
                    <th>email</th>
                    <th>address</th>
                    <th>date</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employee as $key => $val)
                <tr>
                    <td>{{$val['empid']}}</td>
                    <td>{{$val['fullname']}}</td>
                    <td>{{$val['email']}}</td>
                    <td>{!! $val['address'] !!}</td>
                    <td>{{$val['date']}}</td>
                    <td>
                        @if($val['status']=='1')
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Deactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url('edit', ['empid' => $val['id']]) }}" class="btn btn-sm btn-success m-1">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-empid="{{ $val['id'] }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this record?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal for Data Insert -->
    <div class="modal fade" id="insertSuccessModal" tabindex="-1" aria-labelledby="insertSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="insertSuccessModalLabel">Success!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4>Data Inserted Successfully!</h4>
                    <p class="text-muted">The new employee record has been added to the database.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal for Data Update -->
    <div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="updateSuccessModalLabel">Success!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4>Data Updated Successfully!</h4>
                    <p class="text-muted">The employee record has been updated in the database.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Continue</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                // Optional: Customize DataTable options
                "pageLength": 5,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ]
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const empid = button.getAttribute('data-empid');
                confirmDeleteBtn.href = "{{ url('del') }}/" + empid;
            });

            // Auto-show success modals based on session data
            @if(session('insert_success'))
            const insertModal = new bootstrap.Modal(document.getElementById('insertSuccessModal'));
            insertModal.show();
            @endif

            @if(session('update_success'))
            const updateModal = new bootstrap.Modal(document.getElementById('updateSuccessModal'));
            updateModal.show();
            @endif
        });
    </script>
</body>

</html>