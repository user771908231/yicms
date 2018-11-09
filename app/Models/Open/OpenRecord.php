<?php
/**
 * Created by PhpStorm.
 * User: company_windows_locahost_wm
 * Date: 2018/11/7
 * Time: 16:54
 */

namespace App\Models\Open;


use App\Models\Users;
use Illuminate\Database\Eloquent\Model;

class OpenRecord extends Model
{
    protected $connection='thing-eye';

    protected $primaryKey='v_id';

    protected $table = 'open_record';

    protected $casts=[
        'time'   => 'date:Y-m-d H:i:s',
    ];

    protected $with=[
            'user'
    ];

    public static function getLists(int $id)
    {
        return OpenRecord::select([
            'v_id',
            'ac_id',
            'ac_name',
            'type',
            'is_out',
            'user_id',
            'time',
            'license_plate',
            'reason'
        ])
            ->where('ac_id',$id)
            ->orderBy('v_id', 'desc')
            ->paginate(20);
    }

    public function user()
    {
        sleep(5);
        return $this->hasOne(Users::class,'id','user_id')->select('id','truename');
    }

    public function getById(int $id)
    {
        return $this->where('v_id',$id)->first();
    }
}