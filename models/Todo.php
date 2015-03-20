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

    use \October\Rain\Database\Traits\Validation;

    public $table       = 'shahiemseymor_todo'; 
    public $dates       = ['deadline'];
    public $belongsTo   = ['task'  => ['Backend\Models\User', 'key' => 'user_id']];
    protected $fillable = ['title', 'description', 'deadline', 'priority', 'progress_val'];

    public $rules = [
        'title'                  => 'required',
        'deadline'               => 'required',
    ];

    public function beforeCreate()
	{
	    $this->user_id = BackendAuth::getUser()->id;
	}

    public function getCreatorAttribute()
    {
        return $this->task->first_name.' '.$this->task->last_name;
    }

    public function getProgressAttribute()
    {
        $color = '';
        if($this->progress_val > 50 && $this->progress_val < 65)
        {
            $color = 'progress-bar-warning';
        }
        elseif($this->progress_val == 100)
        {
            $color = 'progress-bar-success';
        }

        $progressBar = '<div class="progress" style="width: 100%; height: 20px; background: #444;"><div class="progress-bar '.$color.'" role="progressbar" style="width: '.$this->progress_val.'%; padding-left: 2px;">'.$this->progress_val.'%</div></div>';
        return $progressBar;
    }
    
}