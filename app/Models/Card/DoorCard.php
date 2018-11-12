<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-10-11
 * Time: 下午4:28
 */

namespace App\Models\Card;

use Illuminate\Database\Eloquent\Model;


class DoorCard extends Model
{
    protected $connection="thing-eye";

    protected $table = "door_card";

    protected $guarded = [];

    public $timestamps = false;

    public static function getDoorById($id){
        return DoorCard::where('id','=',$id)->first();
    }

    public static function getDoorCardByCommunityId($id)
    {
        $info = DoorCard::where('cid', '=', $id)->orderBy('id', 'DESC')->paginate(20);
        return $info;
    }

    public static function getAllDoorCard()
    {
        $info = DoorCard::select('*')->where([
            ['is_delete', '=', 0],
            ['state', '!=', 2]
        ])
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return $info;
    }
    public static function updateById($id,array $array){
        return DoorCard::where('id','=',$id)->update($array);
    }
    public static function deleteById($id){
        return DoorCard::where('id','=',$id)->delete();
    }
}