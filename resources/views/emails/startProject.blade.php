<!DOCTYPE html>


<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Start Project</title>
</head>
<body>
    {{-- @foreach($data as $datas) --}}
    {{-- <p>Email: {{ $email }}</p> --}}
    {{-- @endforeach --}}
    {{-- --}}
    <i>
        <h3>Congrats</h3>
    </i>
    <div>
        <img src={{ asset('http://localhost:8000/public/assets/mail_template/Optimized-Email-marketing (1).jpg') }}


    </div>



</body>
</html>

