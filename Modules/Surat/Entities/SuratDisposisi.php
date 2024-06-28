<?php

namespace Modules\Surat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratDisposisi extends Model
{
    use HasFactory;
    protected $table = 'surat_disposisis';

    protected $guarded = ['id'];

    public function surat_masuk(){
        return $this->belongsTo(SuratMasuk::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Surat\Database\factories\SuratDisposisiFactory::new();
    // }
}
