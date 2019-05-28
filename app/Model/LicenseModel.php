<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LicenseModel extends Model
{
    protected $table='company';

    public $timestamps = false;

    protected  $primaryKey="company_id";
}
