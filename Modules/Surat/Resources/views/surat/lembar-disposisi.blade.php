<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lembar Disposisi</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;

        }

        .container {
            width: 210mm;
            margin: 0 auto;
            padding: 5mm;
            text-transform: capitalize;
            box-sizing: border-box;
        }

        @media print {
            .print {
                display: none;
            }
        }

        .kop-surat {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .header p {
            margin: 5px 0 0;
        }

        .content,
        .awal {
            width: 100%;
            border-collapse: collapse;
        }

        .content,
        .awal th,
        .content td,
        .content tr {
            border: 1px solid #000000;
            padding: 8px;
            text-align: left;
        }

        .content th {
            border: 1px solid #000000;
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .content td input[type="text"],
        .content td textarea {
            width: 100%;
            border: none;
            box-sizing: border-box;
        }

        .content td textarea {
            resize: vertical;
            height: 60px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .flex-container .left,
        .flex-container .right {
            flex: 1;
        }

        .flex-container .left {}

        .footer {
            margin-top: 20px;
            text-align: right;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="kop-surat">
            <img src="{{ asset('storage/assets/img/surat/kop surat.png') }}" style="width: 100%;height: 100%" alt="">
        </div>
        <button class="print" style="margin-bottom: 10px" onclick="window.print()">Print</button>
        <table class="awal">
            <tr>
                <th>Tanggal Terima : {{ date('d M Y') }}</th>
                <th>Nomor Agenda :</th>
                <th>300</th>
            </tr>
        </table>
        <div class="flex-container">
            <div class="left">
                <p>Jenis Disposisi : {{ $surat->sifat }}</p>
                <p>Nomor Surat: {{ $surat->nomor }}</p>
                <p>Pengirim: {{ $surat->pengirim }}</p>
            </div>
            <div class="right">
                <p>Tanggal: {{ date('d M Y', strtotime($surat->tanggal_surat)) }}</p>
                <p>Perihal: {{ $surat->perihal }}</p>
            </div>
        </div>
        <table class="content">
            <tr>
                <th>DARI</th>
                <th>KEPADA</th>
                <th>ISI DISPOSISI</th>
                <th>TANGGAL</th>
            </tr>
            @foreach ($disposisi as $item)
                @php
                    $array = explode(',', $item->tujuan_disposisi);
                @endphp
                <tr>
                    <td>{{ $item->user->name }}</td>
                    <td>
                        @foreach ($array as $data)
                            - {{ $data }} <br>
                        @endforeach
                    </td>
                    <td>- {{ $item->disposisi_singkat }} <br> - {{ $item->disposisi_narasi }}</td>
                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                </tr>
            @endforeach
        </table>
        @if ($bukti)
            <div class="page-break"></div>
            <h2>Bukti Tugas</h2>
            <div class="bukti">
                @if (pathinfo($bukti->foto, PATHINFO_EXTENSION) === 'pdf')
                <a class="print" href="{{ asset('storage/assets/img/bukti/' . $bukti->foto) }}" title="Lihat File" target="_blank">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-eye" aria-hidden="true"></i> Lihat File
                    </button>
                </a>
                @else
                    <img src="{{ asset('storage/assets/img/bukti/' . $bukti->foto) }}" alt="Bukti Tugas" width="100%" height="500">
                @endif

            </div>
        @endif
    </div>
</body>

</html>
