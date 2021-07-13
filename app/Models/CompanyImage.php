<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyImage extends Model
{
    use HasFactory;

    protected $table = 'company_image';
    protected $fillable = ["path","company_id"];

    public function deleteImg()
    {
        Storage::delete('public/logos/'.$this->path);
        $this->delete();
    }

    public function link()
    {
        return asset("storage/logos/$this->path");
    }
}
