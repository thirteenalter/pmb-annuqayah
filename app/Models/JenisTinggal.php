<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTinggal extends Model
{
  protected $table = 'jenis_tinggal';
  protected $primaryKey = 'id_jns_tinggal';
  public $incrementing = false;
  protected $keyType = 'float';
  public $timestamps = false;

  protected $fillable = ['id_jns_tinggal', 'nm_jns_tinggal'];
}
