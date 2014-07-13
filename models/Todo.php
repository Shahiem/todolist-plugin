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

    public $table = 'shahiemseymor_todo';   
    protected $fillable = ['title', 'description', 'deadline', 'priority', 'progress_val'];
    public $dates = ['deadline'];

    public $rules = [
        'title'                  => 'required',
        'deadline'               => 'required',
    ];

    public function beforeCreate()
	{
	    $this->user_id = BackendAuth::getUser()->id;
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

        $progressBar = '<div class="progress">
                          <div class="progress-bar '.$color.'" role="progressbar" style="width: '.$this->progress_val.'%;">'.$this->progress_val.'%</div>
                        </div>';
        return $progressBar;
    }
    
}