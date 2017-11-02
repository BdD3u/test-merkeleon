<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App
 *
 * @property integer $balance
 * @property integer $id
 */
class User extends Model
{
    protected $table = 'user';

    public $timestamps = false;
    public $fillable = [
        'id',
        'balance',
    ];

    protected const C_ERR_FEATURE_DISABLED = 'This feature has been disabled';

    public function setUpdatedAt($value)
    {
        throw new \Exception(static::C_ERR_FEATURE_DISABLED);
    }

    public function setCreatedAt($value)
    {
        throw new \Exception(static::C_ERR_FEATURE_DISABLED);
    }

    public function getUpdatedAtColumn()
    {
        throw new \Exception(static::C_ERR_FEATURE_DISABLED);
    }

    public  function getCreatedAtColumn()
    {
        throw new \Exception(static::C_ERR_FEATURE_DISABLED);
    }

    protected function throwFeatureDisabled()
    {
        throw new \Exception(static::C_ERR_FEATURE_DISABLED);
    }
}
