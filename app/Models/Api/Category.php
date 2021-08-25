<?php

namespace App\Models\Api;

use DateTimeInterface;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, GeneralTrait;

    protected $table = 'categories';
    
    protected $guarded = [];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:s:i');
    }

    public function getCategoryStatus()
    {
        switch ($this->status) {
            case 0:
                return 'Inactive';
                break;

            default:
                return 'Active';
                break;
        }
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'name_' . $this->getCurrentLang() . ' as name', 'status','created_at');
    }
}
