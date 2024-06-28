<?php

namespace Modules\Surat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuratMasuk extends Model
{
    use HasFactory;
    protected $table = 'surat_masuks';

    protected $guarded = ['id'];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Surat\Database\factories\SuratMasukFactory::new();
    // }
}
