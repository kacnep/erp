<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{

    protected $table = 'projects';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function skill()
    {
        return $this->hasOne(Skill::class , 'project_id');
    }

    public function getAttachments()
    {
        return json_decode($this->attachments);
    }

}