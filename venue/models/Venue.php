<?php namespace Klubitus\Venue\Models;

use Model;
use October\Rain\Database\QueryBuilder;
use October\Rain\Database\Traits\Revisionable;
use October\Rain\Database\Traits\Validation;


/**
 * Venue Model
 */
class Venue extends Model {
    use Revisionable, Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'venues';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'updated_at',
        'name',
        'url',
        'description',
        'info',
        'address',
        'city_name',
        'zip',
        'country',
        'latitude',
        'longitude',
        'facebook_id',
        'foursquare_id',
        'foursquare_category_id',
    ];

    protected $revisionable = ['name', 'description', 'info'];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        'events' => 'Klubitus\Calendar\Models\Event',
    ];
    public $belongsTo = [
        'author' => 'RainLab\User\Models\User',
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [
        'revision_history' => ['System\Models\Revision', 'name' => 'revisionable'],
    ];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * @var  array  Validation rules
     */
    public $rules = [
        'name'      => 'required',
        'url'       => 'url',
        'latitude'  => 'required_with:longitude',
        'longitude' => 'required_with:latitude',
    ];


    /**
     * Get events by Facebook event id.
     *
     * @param   QueryBuilder  $query
     * @param   array         $facebookIds
     * @return  QueryBuilder
     */
    public function scopeFacebook($query, array $facebookIds) {
        return $query->whereIn('facebook_id', $facebookIds);
    }

}
