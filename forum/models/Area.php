<?php namespace Klubitus\Forum\Models;

use Cms\Classes\Controller;
use Model;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\Validation;
use Str;

/**
 * Area Model
 */
class Area extends Model {
    use NestedTree;
    use Validation;

    public $implement = ['@Rainlab.Translate.Behaviors.TranslatableModel'];
    public $translatable = ['name', 'description'];

    /**
     * @var  string  The database table used by the model.
     */
    public $table = 'forum_areas';

    /**
     * @var  array  Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var  array  Fillable fields
     */
    protected $fillable = ['name', 'description', 'parent_id', 'is_hidden', 'is_private', 'is_moderated'];

    /**
     * @var  array  The attributes that should be visible in arrays.
     */
    protected $visible = ['name', 'description'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * @var  array  Validation rules
     */
    public $rules = [
        'name' => 'required',
    ];


    public function scopeIsPublic($query) {
        return $query->where('is_private', '<>', true);
    }


    public function scopeIsVisible($query) {
        return $query->where('is_hidden', '<>', true);
    }


    /**
     * Set current object url.
     *
     * @param  string      $pageName
     * @param  Controller  $controller
     */
    public function setUrl($pageName, Controller $controller) {
        $params = [
            'area_id' => $this->id . '-' . Str::slug($this->name)
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

}
