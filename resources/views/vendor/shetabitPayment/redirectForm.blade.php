<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forwarding to secure payment provider</title>
    <link rel="stylesheet" href="/plugin/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        .text-center {
            text-align: center;
        }

        .mt-2 {
            margin-top: 2em;
        }

        .spinner {
            margin: 100px auto 0;
            width: 100px;
            text-align: center;
        }

        .spinner > div {
            width: 25px;
            height: 25px;
            background-color: #ffc107;
            border-radius: 100%;
            display: inline-block;
            -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .spinner .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes sk-bouncedelay {
            0%, 80%, 100% {
                -webkit-transform: scale(0)
            }
            40% {
                -webkit-transform: scale(1.0)
            }
        }

        @keyframes sk-bouncedelay {
            0%, 80%, 100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
            40% {
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
            }
        }
    </style>
</head>
<body onload="submitForm();" class="bg-dark">
<div class="spinner">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<form class="text-center mt-2 text-light" method="{{ $method }}" action="{{ $action }}">
    <h3 class="mt-3 mb-3">{{ __('messages.send_to_gateway') }}...</h3>
    <p>
        {{ __('messages.automatically_send_to_gateway') }}
        <span id="countdown">10</span>
        {{ __('titles.second') }}
    </p>

    @foreach($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach

    <button type="submit" class="btn btn-warning">{{ __('titles.click_here') }}</button>
</form>
<script src="/plugin/bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    // Total seconds to wait
    var seconds = 10;

    function submitForm() {
        document.forms[0].submit();
    }

    function countdown() {
        seconds = seconds - 1;
        if (seconds <= 0) {
            // submit the form
            submitForm();
        } else {
            // Update remaining seconds
            document.getElementById("countdown").innerHTML = seconds;
            // Count down using javascript
            window.setTimeout("countdown()", 1000);
        }
    }

    // Run countdown function
    countdown();
</script>
</body>
</html>
