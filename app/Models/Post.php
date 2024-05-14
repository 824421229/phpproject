<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post'; // 指定表名

    protected $fillable = ['title', 'content']; // 根据实际字段进行修改

    // 如果表中没有 `created_at` 和 `updated_at` 字段，请禁用时间戳
    public $timestamps = false;
}
