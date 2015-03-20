<?php 
namespace ShahiemSeymor\Todo\Models;

use BackendAuth;
use Model;

class Project extends Model
{

    use \October\Rain\Database\Traits\Purgeable;
    use \October\Rain\Database\Traits\Validation;
    
    public $table         = 'shahiemseymor_todo_projects'; 

	protected $fillable   = ['title', 'description'];
	protected $purgeable  = ['assign'];

	public $hasMany       = ['todo'     => ['ShahiemSeymor\Todo\Models\Todo']];	
    public $belongsTo     = ['project'  => ['Backend\Models\User', 'key' => 'user_id']];
    public $rules         = ['title'    => 'required'];

    public function beforeCreate()
	{
	    $this->user_id = BackendAuth::getUser()->id;
	}
  	
  	public function getCreatorAttribute()
    {
    	return $this->project->first_name.' '.$this->project->last_name;
    }
    
}