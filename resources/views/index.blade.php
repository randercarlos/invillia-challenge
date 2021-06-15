<!DOCTYPE html>
<!-- Created By CodingNepal -->
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body class="w3-container">
<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">

    @if (session('error'))
        <div class="w3-panel w3-red">
            @if (is_array(session('error')))
                @foreach(session('error') as $error)
                    <div>{{ implode(',', $error) }}</div>
                @endforeach
            @else
                {!! session('error') !!}
            @endif
        </div>
    @endif

    @if (session('success'))
        <div class="w3-panel w3-green">
            {!! session('success') !!}
        </div>
    @endif

    @if (session('info'))
        <div class="w3-panel w3-light-blue">
            {!! session('info') !!}
        </div>
    @endif

    Selecione o XML para upload: <br />
    <input type="file" name="file" id="file" accept=".xml"> <br />

    Processar assincronamente ?
    <input type="radio" checked value="false" name="isAsynchronous" /> Não
    <input type="radio" value="true" name="isAsynchronous"/> Sim
    <br />
    <input type="submit" value="Enviar" name="submit">


    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">


</form>
</body>
</html>
