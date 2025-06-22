<!DOCTYPE html>
<html>
<head>
    <title>New Memo Notification</title>
</head>
<body>
    <h2>{{ $memo->title }}</h2>
    <p>{{ $memo->description }}</p>
    <p><strong>Date:</strong> {{ $memo->date ? $memo->date->format('F d, Y') : 'N/A' }}</p>
    <p>You can view or download the memo from the system.</p>
</body>
</html>
