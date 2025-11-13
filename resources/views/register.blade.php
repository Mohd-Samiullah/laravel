<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Quill.js for rich text editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .custom-editor {
            height: 150px;
            margin-bottom: 50px;
        }

        .ql-toolbar.ql-snow {
            border-top: 1px solid #ccc;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-bottom: none;
        }

        .ql-container.ql-snow {
            border: 1px solid #ccc;
            border-top: none;
        }

        .editor-wrapper {
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .character-count {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: right;
            margin-top: 5px;
        }
    </style>
</head>

<body class="bg-light p-5">
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

        <!-- Error Alert -->
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card shadow-lg p-4" style="max-width: 600px; margin: auto;">
            <h3 class="text-center mb-4">
                @if(!empty($employee->id) && $employee->id)
                Edit Employee
                @else
                Register Form
                @endif
            </h3>

            <!-- @if(session()->has('address'))
            <div class="alert alert-info">
                {{ session('address') }}
            </div>
            @else
            <div class="alert alert-warning">
                No address found
            </div>
            @endif -->

            <form action="{{url(!empty($employee->id) && $employee->id ? '/update/'.$employee->id  : '/register')}}"
                method="POST" enctype="multipart/form-data" id="employeeForm">
                @csrf

                <!-- Hidden input to store the formatted address -->
                <input type="hidden" name="address" id="addressInput" value="{{($employee->address ?? '')}}" required>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                        value="{{($employee->fullname ?? '')}}" placeholder="Enter your full name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email"
                        value="{{($employee->email  ?? '')}}" placeholder="Enter your email" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <div class="editor-wrapper">
                        <!-- Rich Text Editor Container -->
                        <div id="addressEditor" class="custom-editor">
                            {!! $employee->address ?? '<p><br></p>' !!}
                        </div>
                    </div>
                    <div class="character-count">
                        <span id="charCount">0</span> characters
                    </div>
                    <div class="form-text">
                        You can format your address with <strong>bold</strong>, <em>italic</em>, lists, and more.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" id="date" value="{{($employee->date ?? '')}}"
                        placeholder="Enter your address" required>
                </div>

                @if(!empty($employee->image))
                <div class="mb-3 text-center">
                    <img src="{{ asset('storage/uploads/' . $employee->image) }}" alt="Uploaded Image" width="120"
                        class="img-thumbnail mt-2">
                    <p class="text-muted mt-1">{{ $employee->image }}</p>
                </div>
                @endif

                <button type="submit" class="btn btn-primary w-100">
                    @if(!empty($employee->id) && $employee->id)
                    Update
                    @else
                    Submit
                    @endif
                </button>
            </form>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill editor
            const quill = new Quill('#addressEditor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'clean']
                    ]
                },
                placeholder: 'Enter your address with formatting...',
            });

            // Update character count
            function updateCharacterCount() {
                const text = quill.getText().trim();
                const charCount = text.length;
                document.getElementById('charCount').textContent = charCount;
            }

            // Update hidden input with HTML content before form submission
            document.getElementById('employeeForm').addEventListener('submit', function(e) {
                const editorContent = quill.root.innerHTML;
                const plainText = quill.getText().trim();

                // Validate that address is not empty
                if (plainText.length === 0) {
                    e.preventDefault();
                    alert('Please enter an address');
                    return;
                }

                document.getElementById('addressInput').value = editorContent;
            });

            // Set initial content if editing
            const initialAddress = `{!! $employee->address ?? '' !!}`;
            if (initialAddress) {
                quill.root.innerHTML = initialAddress;
            }

            // Update character count on editor changes
            quill.on('text-change', updateCharacterCount);

            // Initialize character count
            updateCharacterCount();

            // Auto-show success modals
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