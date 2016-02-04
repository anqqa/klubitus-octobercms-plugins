<?php namespace Klubitus\Forum\Components;

use Illuminate\Database\Eloquent\Collection;
use Klubitus\Forum\Models\Area as AreaModel;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Lang;


class Areas extends ComponentBase {

    /**
     * @var  string
     */
    public $areaPage;

    /**
     * @var  string
     */
    public $topicPage;

    /**
     * @var  AreaModel
     */
    protected $areas;


    public function componentDetails() {
        return [
            'name'        => 'Forum Areas',
            'description' => 'Detailed forum areas list.'
        ];
    }


    public function defineProperties() {
        return [
            'areaPage' => [
                'title'       => 'Area Page',
                'description' => 'Page name for a single forum area.',
                'type'        => 'dropdown',
            ],
            'topicPage' => [
                'title'       => 'Topic Page',
                'description' => 'Page name for a single forum topic.',
                'type'        => 'dropdown',
            ],
        ];
    }


    public function getPropertyOptions($property) {
        return ['' => '- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }


    public function listAreas() {
        if (!is_null($this->areas)) {
            return $this->areas;
        }

        $areas = AreaModel::isVisible()->get();

        // Add URLs
        $areas->each(function(AreaModel $area) {
            $area->setUrl($this->areaPage, $this->controller);
        });

        $areas = $areas->toNested();

        return $this->areas = $areas;
    }


    public function onRun() {
        $this->prepareVars();

        $this->page['areas'] = $this->listAreas();
        $this->page['title'] = Lang::get('klubitus.forum::lang.forum.title');
    }


    protected function prepareVars() {
        $this->areaPage = $this->page['areaPage'] = $this->property('areaPage');
        $this->topicPage = $this->page['topicPage'] = $this->property('topicPage');
    }

}
