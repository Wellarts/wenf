<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orientação para Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <table class="table">
            <tr>
                <td style="width: 10%">
                    <img src="{{ asset('/images/logo.png') }}" alt="Logo"  style="width: 3cm">
                </td>
                
                <td style="width: 90%">
                    <p style="text-align: center; font-size: 12pt; color: darkgray"><b>Wenf</b> <br>
                        Rua Manoel Joaquim Vilela, 120 - Centro - Lajedo-PE<br>
                        (87)99930-2121
                    </p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text-center fs-5">ORIENTAÇÕES PARA PACIENTE</p>
        </div>
        <table class="table table-striped-columns">
            <tr>
                <td>
                    <p><label class="fw-bold fs-6">Paciente:</label> {{ $orientacao->paciente->nome }}</p>
                </td>

            <tr>
                <td>
                    <p><label class="fw-bold fs-6">Data:</label>
                        {{ \Carbon\Carbon::parse($orientacao->data_orientacao)->format('d/m/Y') }}</p>
                </td>
            </tr>

            </tr>
            <tr>
                <td class="border 1">
                    <p><label class="fw-bold fs-6">Descrição:</label> {{ $orientacao->descricao }}</p>
                </td>
            </tr>
        </table>
        <br><br>
        <div>
            <p class="text-center">_________________________________________<br>
                Enfermeira

            </p>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>
