<?php 
/**
 * Created by ShahiemSeymor.
 * Date: 6/19/14
 */
namespace ShahiemSeymor\Todo\Models;
use Model;
use BackendAuth;

class Todo extends Model
{
    public $table = 'shahiemseymor_todo';   
    protected $fillable = ['title', 'description', 'deadline', 'priority', 'progress'];
    public $dates = ['deadline'];

    public $rules = [
        'title'                  => 'required',
        'deadline'               => 'required',
    ];

    public function beforeCreate()
	{
	    $this->user_id = BackendAuth::getUser()->id;
	}
}