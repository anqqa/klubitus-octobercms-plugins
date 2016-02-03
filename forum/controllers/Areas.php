<?php namespace Klubitus\Forum\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use Klubitus\Forum\Models\Area as AreaModel;
use System\Classes\SettingsManager;


/**
 * Areas Back-end Controller
 */
class Areas extends Controller {
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.ReorderController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $reorderConfig = 'config_reorder.yaml';


    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Klubitus.Forum', 'settings');
    }


    public function index_onDelete() {
        $areaIds = post('checked');

        if ($areaIds && is_array($areaIds) && count($areaIds)) {
            foreach ($areaIds as $areaId) {

                if (!$area = AreaModel::find($areaId)) {
                    continue;
                }

                //$area->delete();
            }

            Flash::success('Areas deleted.');
        }

        return $this->listRefresh();
    }
}
