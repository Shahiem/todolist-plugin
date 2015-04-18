<?php namespace ShahiemSeymor\Todo\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use BackendAuth;
use DB;
use Flash;
use ShahiemSeymor\Todo\Models\Assign;
use ShahiemSeymor\Todo\Models\Project;
use Redirect;

class Projects extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig     = 'config_form.yaml';
    public $listConfig     = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('ShahiemSeymor.Todo', 'todo', 'list');
    }

    public function index()
    {
        $this->getClassExtension('Backend.Behaviors.ListController')->index();
    }
 
    public function listExtendQuery($query, $definition = null)
    {
        $query->whereExists(function($query)
        {
            $query->select('*')
                  ->from('shahiemseymor_todo_projects_assigned')
                  ->whereRaw('shahiemseymor_todo_projects_assigned.project_id = shahiemseymor_todo_projects.id')
                  ->where('shahiemseymor_todo_projects_assigned.user_id', '=',  BackendAuth::getUser()->id);
        })->orWhere('shahiemseymor_todo_projects.user_id', '=', BackendAuth::getUser()->id);
    }

    public function update($id)
    {
        $query = Project::where('id', '=', $id)->get();
        
        foreach($query as $fetch)
        {
            $this->vars['user_id']    = $fetch->user_id;
            $this->vars['myId']       = BackendAuth::getUser()->id;    
            $this->vars['isAssigned'] = Assign::checkAssigned(BackendAuth::getUser()->id, $fetch->id);  
        }

        $this->getClassExtension('Backend.Behaviors.FormController')->update($id);
    }

    public function index_onDelete()
    {
        if(($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) 
        {
            foreach ($checkedIds as $projectId) 
            {
                if (!$project = Project::find($projectId))
                    continue;

                Assign::where('project_id', $projectId)->delete();
                $project->delete();
            }

            Flash::success('The selected projects has been deleted successfully.');
        }

        return $this->listRefresh();
    }
}