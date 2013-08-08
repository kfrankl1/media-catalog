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
    function setup(&$Model, $settings) {
        if(empty($settings)) {
            $settings = $Model->getAssociated('hasAndBelongsToMany');
        }
        foreach((array)$settings as $key) {
            $fieldName = $key;
            $this->settings[$Model->alias][] = $fieldName;
        }
    }
    
    function beforeSave(&$Model, $options = array()) {
        foreach($this->settings[$Model->alias] as $fieldName) {
            if(isset($Model->data[$Model->alias][$fieldName]) && 
                !isset($Model->data[$fieldName][$fieldName])) {
                $Model->data[$fieldName][$fieldName] = $Model->data[$Model->alias][$fieldName];
                unset($Model->data[$Model->alias][$fieldName]);
            }
        }
        return true;
    }
}
?>