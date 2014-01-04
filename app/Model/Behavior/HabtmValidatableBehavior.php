<?php 
/**
 * Gives models the ability to validate the save or update of a HABTM associated model (typically a 
 * multiple select or check box) 
 * 
 * Example:
 * 
 * Post HABTM Tag
 * 
 * Usage:
 * 
 * post.php
 * ----------------
 * var $validate = array('Tag' => array('rule' => array('multiple', array('min' => 1))));
 * 
 * var $actsAs = array('HabtmValidatable'); //This will apply to all HABTM related models
 * var $actsAs = array('HabtmValidatable' => 'Tag'); //One field
 * var $actsAs = array('HabtmValidatable' => array('Tag')); //One or multiple fields
 * 
 * posts_controller.php
 * ----------------
 *     function add($id = null) {
 *         if(!empty($this->data)) {
 *             $this->Post->save($this->data);
 *      }
 *         $tags = $this->Post->Tag->find('list');
 *         $this->set(compact('tags));
 *     }
 * 
 * posts/add.ctp
 * ----------------
 * echo $form->create('Post');
 * echo $form->input('Post.Tag'); //This is the only change to the user code
 * echp $form->end();
 * 
 */
class HabtmValidatableBehavior extends ModelBehavior {
	// compatibility error with version? Modified declaration
	public function setup(Model $model, $config = array()) {
        if(empty($settings)) {
            $config = $model->getAssociated('hasAndBelongsToMany');
        }
        foreach((array)$config as $key) {
            $fieldName = $key;
            $this->settings[$model->alias][] = $fieldName;
        }
    }
    
	// compatibility error with version? Modified declaration
    function beforeSave(Model $model) {
        foreach($this->settings[$model->alias] as $fieldName) {
            if(isset($model->data[$model->alias][$fieldName]) && 
                !isset($model->data[$fieldName][$fieldName])) {
                $model->data[$fieldName][$fieldName] = $model->data[$model->alias][$fieldName];
                unset($model->data[$model->alias][$fieldName]);
            }
        }
        return true;
    }
}
?>