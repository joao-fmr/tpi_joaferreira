<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Values model representing the t_values table
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    // allows fake data to be generated
    use HasFactory;

    // table associated with the model
    protected $table = 't_values';

    // indicates if the model should be timestamped or not (false = not)
    public $timestamps = false;

    // attributes that can be mass assignable
    protected $fillable = [
        'valWindSpeed', 'valWindDirection', 'valGust', 'valEntryDate', 'valStoredDate', 'fkStation'
    ];
}
