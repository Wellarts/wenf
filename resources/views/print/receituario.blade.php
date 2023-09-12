<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receituário</title>
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
                    <p style="text-align: center; font-size: 12pt; color: darkgray"><b>Clínica Mamma Baby</b> <br>
                        Avenida 19 de Maio, 426 - Centro - Lajedo-PE<br>
                        (87)9.9904-9226 @mamm_ababy
                    </p>
                </td>
            </tr>
        </table>
        <div>
            <p class="text-center fs-5">RECEITUÁRIO</p>
        </div>
        <table class="table table-striped-columns">
            <tr>
                <td>
                    <p><label class="fw-bold fs-6">Paciente:</label> {{ $receituario->paciente->nome }}</p>
                </td>

            <tr>
                <td>
                    <p><label class="fw-bold fs-6">Data:</label>
                        {{ \Carbon\Carbon::parse($receituario->data_receiturario)->format('d/m/Y') }}</p>
                </td>
            </tr>

            </tr>
            <tr>
                <td class="border 1">
                    <p><label class="fw-bold fs-6">Descrição:</label> {{ $receituario->descricao }}</p>
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
