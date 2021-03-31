<!DOCTYPE html>

<html>

<head>

    <title>Educatioo</title>

</head>

<body>

<h1>{{ $details['title'] }}</h1>

<p>{{ $details['body'] }}</p>
<p>{{ isset($details['link']) ? $details['link'] : ""}}</p>



<p>Thank you</p>

</body>

</html>
