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
        padding: 20mm;
        border: 1px solid #000;
        box-sizing: border-box;
      }
      .kop-surat {
        text-align: center;
        margin-bottom: 20px;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
      }
      .kop-surat img {
        max-height: 100px;
        margin-bottom: 10px;
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
      .content td,.content tr {
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
        .flex-container .left, .flex-container .right {
            flex: 1;
        }
        .flex-container .left {
            margin-right: 20px;
        }
      .footer {
        margin-top: 20px;
        text-align: right;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <!-- <div class="kop-surat">
        <img src="logo_instansi.png" alt="Logo Instansi" />
        <h2>Nama Instansi</h2>
        <p>Alamat Instansi</p>
        <p>Telepon: (021) 12345678 | Email: info@instansi.go.id</p>
      </div> -->
      <div class="header">
        <h1>Lembar Disposisi</h1>
      </div>
      <table class="awal">
        <tr>
          <th>Tanggal Terima : {{date('d M Y')}}</th>
          <th>Nomor Agenda :</th>
          <th>300</th>
        </tr>
      </table>
      <div class="flex-container">
        <div class="left">
            <p>Jenis Disposisi :</p>
            <input type="radio" name="jenis" value="rahasia" id="rahasia" {{ isset($surat) && $surat->sifat == 'Rahasia' ? 'checked' : '' }}/>
            <label for="rahasia">Rahasia</label><br><br>
            <input type="radio" name="jenis" value="penting" id="penting" {{ isset($surat) && $surat->sifat == 'Penting' ? 'checked' : '' }} />
            <label for="penting">Penting</label><br><br>
            <input type="radio" name="jenis" value="segera" id="segera" {{ isset($surat) && $surat->sifat == 'Segera' ? 'checked' : '' }} />
            <label for="segera">Segera</label><br><br>
            <input type="radio" name="jenis" value="biasa" id="biasa" {{ isset($surat) && $surat->sifat == 'Biasa' ? 'checked' : '' }}/>
            <label for="biasa">Biasa</label><br><br>
            <input type="radio" name="jenis" value="pentingsegera" id="pentingsegera" {{ isset($surat) && $surat->sifat == 'Penting Segera' ? 'checked' : '' }}/>
            <label for="penting segera">Penting Segera</label>
        </div>
        <div class="right">
            <p>Pengirim: {{$surat->pengirim}}</p>
            <p>Nomor Surat: {{$surat->nomor}}</p>
            <p>Tanggal: {{date('d M Y',strtotime($surat->tanggal_surat))}}</p>
            <p>Perihal: {{$surat->perihal}}</p>
        </div>
    </div>
      <table class="content">
        <tr>
          <th>DARI</th>
          <th>KEPADA</th>
          <th>ISI DISPOSISI</th>
          <th>PARAF</th>
        </tr>
        <tr>
          <td><input type="text" placeholder="Nama pengirim" /></td>
          <td><input type="text" placeholder="Nama penerima" /></td>
          <td><textarea placeholder="Isi disposisi"></textarea></td>
          <td><input type="text" placeholder="Paraf" /></td>
        </tr>
        <tr>
          <td><input type="text" placeholder="Nama pengirim" /></td>
          <td><input type="text" placeholder="Nama penerima" /></td>
          <td><textarea placeholder="Isi disposisi"></textarea></td>
          <td><input type="text" placeholder="Paraf" /></td>
        </tr>
        <tr>
          <td><input type="text" placeholder="Nama pengirim" /></td>
          <td><input type="text" placeholder="Nama penerima" /></td>
          <td><textarea placeholder="Isi disposisi"></textarea></td>
          <td><input type="text" placeholder="Paraf" /></td>
        </tr>
        <tr>
          <td><input type="text" placeholder="Nama pengirim" /></td>
          <td><input type="text" placeholder="Nama penerima" /></td>
          <td><textarea placeholder="Isi disposisi"></textarea></td>
          <td><input type="text" placeholder="Paraf" /></td>
        </tr>
      </table>
    </div>
  </body>
</html>
