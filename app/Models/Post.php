<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // esto nos permitirá añadir datos en masa (todos los atributos a la vez y no uno a uno)
    // también nos asegura que cualquier otro atributo no especificado no será recogido y devolverá un error en mysql
    // protected $fillable = ['title', 'excerpt', 'body'];

    // protected $guarded = ['id'];
    // explicado en el readme
    protected $guarded = [];

    public function category()
    {
        // función para la relación elocuente entre posts y categories
        // métodos de laravel: hasOne, hasMany, belongsTo, belongsToMany (pensar cual nos conviene más)
        // en nuestro caso, cada post tendrá 1 sola categoría, específicamente pertenecerá a ella

        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        // función para la relación elocuente entre posts y users
        // e principio, cada post pertenecerá a una persona o usuario

        return $this->belongsTo(User::class);
    }
}
