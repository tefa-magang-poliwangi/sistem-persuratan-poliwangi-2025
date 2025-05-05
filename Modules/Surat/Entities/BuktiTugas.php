<?php

namespace Modules\Surat\Entities;

use App\Models\Core\User;
use Modules\Surat\Entities\SuratMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuktiTugas extends Model
{
    use HasFactory;
    protected $table = 'bukti_tugas';

    protected $guarded = ['id'];

    public function surat_masuk(){
        return $this->belongsTo(SuratMasuk::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
