<?php

namespace Modules\Kinerja\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iku extends Model
{
    use HasFactory;

    protected $fillable = ['tahun', 'no', 'sasaran'];

    protected $searchableFields = ['*'];

    protected $table = 'iku';

    protected static function newFactory()
    {
        return \Modules\Kinerja\Database\factories\IkuFactory::new();
    }
}
