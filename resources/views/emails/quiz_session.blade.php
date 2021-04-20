<!DOCTYPE html>

<html>

<head>

    <title>Educatioo</title>

</head>

<body>

<h1>{{ $details['title'] }}</h1>

<p>{{ $details['body'] }}</p>

<p>Course Code: {{ isset($details['Course_Code']) ? $details['Course_Code'] : "" }}</p>

<p>Pin: {{ isset($details['pincode']) ? $details['pincode'] : "" }}</p>



<p>Thank you</p>

</body>

</html>
