<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataWilayah extends Model
{
  protected $table = 'data_wilayah';
  protected $primaryKey = 'id_wil';
  public $incrementing = false;
  protected $keyType = 'string';
  public $timestamps = false;

  protected $fillable = ['id_wil', 'nm_wil', 'id_induk_wilayah', 'id_level_wil'];
}
