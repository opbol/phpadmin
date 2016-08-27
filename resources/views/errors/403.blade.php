<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Forbidden</title>

    {!! Html::style(elixir('css/frontend.css')) !!}

    <style>
        body { padding-top: 100px; }
        h1 { font-size: 50px; margin-top: 0; }
        .icon {
            font-size: 80px;
        }

        @media (max-width: 768px) {
            body { padding-top: 50px; }
        }

        .text-red {
            color: #dd4b39 !important;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="row">
        <div class="col-md-6 col-md-push-3">
            <div class="text-center">
                <div class="icon">
                    <i class="fa fa-lock text-red"></i>
                </div>
                <h1>Forbidden!</h1>
                <br />
                <p>You don't have permission to access this page.</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>