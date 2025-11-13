<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta name="csrf-token" content="{{csrf_tocken}}">
    <title>Document</title>
</head>

<body>
    <button class="btn btn-info btn-lg m-5" id='sendBtn'>Send Data</button>
</body>


<script type="text/javascript">
    $(document).ready(function() {
        $('#sendBtn').click(function() {
            $.ajax({
                url: "{{ route('ajaxSend') }}", // ✅ Correct way to call route in Blade
                type: "POST", // or "POST"
                data: {
                    name: "Samiullah", // optional example data
                    platform: "youtube",
                    // _token: "{{ csrf_token() }}" // required if POST
                },
                success: function(response) {
                    console.log(response);
                    alert('Data sent successfully!');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>

</html>