<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 24.05.2023
 * Description : Station model representing the t_station table
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    // table associated with the model
    protected $table = 't_station';
    
    // indicates if the model should be timestamped or not (false = not)
    public $timestamps = false;

    // attributes that can be mass assignable
    protected $fillable = [
        'idStation','staName','staImg'
    ];
}
