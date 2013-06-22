<?php
// app/Model/Season.php
class Season extends AppModel {
	var $name = "Season";
	var $displayField = "title";
	
    public $hasMany = array(
        'Episode' => array(
            'className'     => 'Episode',
			'order' => 'Episode.original_air_date DESC',
            'foreignKey'    => 'season_id'
        )
    );
	
	public $validate = array(
		'title' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'required' => 'true',
				'message' => 'This season title has already been used'
			)
		)
	);
}

?>