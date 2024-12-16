<?php

namespace App\Models;

use CodeIgniter\Model;

class EVCHisotry extends Model
{
    protected $table            = 'EVC_hisotry';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['token_name', 'user_srl', 'user_id', 'type', 'from_address', 'to_address', 'amount', 'usedFee', 'IsExternalTrade', 'transactionHash', 'status'];

}
