<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DataTransportasi extends Model
{
  protected $table = 'data_transportasi';
  protected $primaryKey = 'id_alat_transport';
  public $incrementing = false; // Karena float dan bukan auto-increment standar
  protected $keyType = 'float';
  public $timestamps = false; // Di SQL tidak ada kolom created_at/updated_at

  protected $fillable = ['id_alat_transport', 'nm_alat_transport'];
}
