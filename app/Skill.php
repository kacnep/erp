<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{

    protected $table = 'skills';

    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getSkills()
    {
        return json_decode($this->skills);
    }

}