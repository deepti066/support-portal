<!DOCTYPE html>
<html>
<head>
    <title>Ticket Confirmation</title>
</head>
<body>
    <h1>Hello {{ auth()->user()->name }},</h1>
    <p>Your ticket has been created successfully.</p>
    <p><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
    <p><strong>Title:</strong> {{ $ticket->title }}</p>
    <p><strong>Description:</strong> {{ $ticket->description }}</p>
    <p>Thank you for reaching out to us!</p>
</body>
</html>
