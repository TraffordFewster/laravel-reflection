<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = ["name","email","logo","website"];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function image()
    {
        if ($this->logo){
            return "/companies/$this->id/image";
        } else {
            return "https://cdn.tmonkeyt.dev/i/8m6ne.png";
        }
    }

    public function setImage($image)
    {
        Storage::delete('public/logos/'.$this->logo);
        $name = $image->hashName();
        $image->storeAs('public/logos', $name);
        $this->logo = $name;
        $this->save();
    }
}
