<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body class="bg-success">
        <div class="container">
            <div class="row align-items-center" style="margin-top:30px">
                <div class="col-4">
                    <div class="mb-3">
                        <form acrion="/" method="post">
                            @csrf
                            <label for="city" class="form-label"><b>City:</b></label>
                            <input class="form-control" type="text" name="city" />
                            @if($errors->has('city'))
                                <div class="error">{{ $errors->first('city') }}</div>
                            @endif
                    </div>
                    <div class="mb-3">
                        <label for="submit" class="form-label"></label>
                        <input class="form-control btn btn-info" type="submit" value="show forecast" />
                        </form>
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3"><strong>{{ ucfirst($forecast->city) }}</strong></div>
                    <div class="mb-3"><b>Temp: </b> {{ round($forecast->temp, 2) }}C</div>
                    <div class="mb-3"><b>Feels like:</b> {{ round($forecast->feels_like, 2) }}C</div>
                    <div class="mb-3"><b>Pressure:</b> {{$forecast->pressure}} HPa</div>
                    <div class="mb-3"><b>Humidity:</b> {{$forecast->humidity}}%</div>
                </div>
            </div>
        </div>
    </body>
</html>
