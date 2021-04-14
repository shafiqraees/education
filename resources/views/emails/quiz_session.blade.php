<!DOCTYPE html>

<html>

<head>

    <title>Educatioo</title>

</head>

<body>

<h1>{{ $details['title'] }}</h1>

<p>{{ $details['body'] }}</p>

<p>Course Cose: {{ isset($details['Course_Code']) ? $details['Course_Code'] : "" }}</p>

<p>Pin: {{ isset($details['Pin']) ? $details['Pin'] : "" }}</p>



<p>Thank you</p>

</body>

</html>
