<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lagoon test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        .container {
            max-width: 960px;
        }
        .error {
            color: #A00;
            border: solid 1px #A00;
            padding: 15px;
            margin: 5px 0;
        }
    </style>
    <script>
        const csrf_token = '{{ csrf_token() }}';
    </script>
</head>
<body>
<div class="container">
    <main>
        <div class="py-5 text-center">
            <h2>Registration</h2>
        </div>
        <div class="row g-5">
            <div class="col-md-12 col-lg-12">
                <form class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="" value="" required>
                        </div>
                        <div class="col-12">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="" value="" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Password</label>
                            <input type="password" class="form-control" id="address" name="password" placeholder="" required>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Password Confirmation</label>
                            <input type="password" class="form-control" id="address" name="password_confirmation" placeholder="" required>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="button" id="submit_registration">Continue to checkout</button>
                </form>
            </div>
        </div>
    </main>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#submit_registration').on('click', function() {
            const formData = {};

            $('form input').each(function(index, element) {
                formData[$(this).attr('name')] = $(this).val();
            });

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{{ route('register') }}',
                data: formData,
                success: function(json) {
                    if(json.status) {
                        $('form').before('<h3>' + json.message + '</h3>').remove();
                    } else {
                        $('form').prepend('<div class="bd-callout bd-callout-danger error">' + json.error + '</div>');
                    }
                },
                complete: function(json) {
                    for(i in json.responseJSON.errors) {
                        $('form').prepend('<div class="bd-callout bd-callout-danger error">' + json.responseJSON.errors[i][0] + '</div>');
                    }
                },
                beforeSend: function() {
                    $('.error').remove();
                },
            });
        });
    });
</script>
</body>
</html>
