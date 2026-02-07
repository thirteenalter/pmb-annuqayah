<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghasilan extends Model
{
  protected $table = 'penghasilan';
  protected $primaryKey = 'id_penghasilan';
  public $incrementing = false;
  protected $keyType = 'float';
  public $timestamps = false;

  protected $fillable = [
    'id_penghasilan',
    'nm_penghasilan',
    'batas_bawah',
    'batas_atas'
  ];
}
