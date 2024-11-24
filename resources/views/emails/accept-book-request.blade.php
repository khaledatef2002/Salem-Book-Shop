<!DOCTYPE html>
<html>
<head>
    <title>Test Email</title>
</head>
<body style="background-color: #f7f7fb;
    min-height: 200px;
    padding: 30px 0;">
    <div style="text-align: center; width:100%;display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;">
        <div style="width:80%;margin:auto;background-color:white;border-radius:7px;    padding: 10px 0;">
            <h1 style="color: black;">Your request for unlocking book</h1>
            <a style="color: black;" href="{{ route('front.book.show', $book) }}">{{ $book->title }}</a>
            <p style="color: {{ $status ? 'green' : 'red' }}; font-weight: bold;">
                @if ($status)
                    Your request has been approved, you can view tha book now
                @else
                    We are sorry that your request has been canceled                    
                @endif
            </p>
        </div>
    </div>
    <a href="{{ route('front.index') }}" style="text-align: center">Salebookshop.ae</a>
</body>
</html>
