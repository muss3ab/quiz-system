<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $fillable = ['domain', 'tenant_id'];
    
    protected $table = 'domains';
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
