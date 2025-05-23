<?php

return [
    'validasi_file_rules' => env('VALIDASI_FILE_RULES'),
    'validasi_file_messages' => [
        'foto.file' => 'File yang dikirimkan tidak valid.',
        'foto.mimes' => 'Format file harus PDF.',
        'foto.max' => 'Ukuran file maksimal 5MB.',
    ],
];


?>
