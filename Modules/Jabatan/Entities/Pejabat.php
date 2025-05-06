<?php

namespace Modules\Jabatan\Entities;

use Modules\Jabatan\Entities\Unit;
use Illuminate\Database\Eloquent\Model;
use Modules\Kepegawaian\Entities\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pejabat extends Model
{
    use HasFactory;

    protected $table = 'pejabats';

    protected $guarded = ['id'];

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    
}
