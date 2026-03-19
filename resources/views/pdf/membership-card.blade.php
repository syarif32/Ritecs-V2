<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Membership Card</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .page {
            page-break-after: always;
            text-align: center;
        }
        .page:last-child {
            page-break-after: never;
        }
        img {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    @if($frontImage)
    <div class="page">
        <img src="{{ $frontImage }}" alt="Front Card">
    </div>
    @endif

    @if($backImage)
    <div class="page">
        <img src="{{ $backImage }}" alt="Back Card">
    </div>
    @endif
</body>
</html>