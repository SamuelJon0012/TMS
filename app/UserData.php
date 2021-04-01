<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    const DataType_COVID_Test_Questionare = 'COVIDTestQuestions';
    const DataType_Last_Rapid_Antigen = 'LastRapidAntigen';

    protected $table = 'user_data';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'data_type',
        'data',
    ];

    /**
     * inserts or updates the data for a record of the given user_id and data_type
     * 
     * @param int $user_id reference to users.id
     * @param string $data_type 
     * @param mixed $data
     */
    static function write(int $user_id, string $data_type, $data){
        if ( (is_object($data)) or (is_array($data)) )
            $data = json_encode($data);

        self::updateOrCreate(compact('user_id','data_type'), ['data'=>$data]);
    }

    static function read(int $user_id, string $data_type){
        if ($rec = self::where('user_id',$user_id)->where('data_type',$data_type)->first())
            return $rec->data;
    }
}