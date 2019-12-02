<?php
/**
 * Created by PhpStorm.
 * User: gee
 * Date: 17/05/17
 * Time: 20:13
 */

namespace App\Models;

use Moloquent\Eloquent\Model as Moloquent;

class BaseModel extends Moloquent
{

    protected $connection = 'mongodb';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'createdAt';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updatedAt';

}