<?php

namespace App\Models;

use CodeIgniter\Model;

class Notice extends Model
{
    protected $table            = 'notices';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_srl','user_id','title', 'content','slug', 'featured_image', 'tags', 'meta_keywords', 'meta_description', 'visibility'];
}
