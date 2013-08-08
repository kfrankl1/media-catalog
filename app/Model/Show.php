<?php

class Show extends AppModel {
	var $name = "Show";
	var $displayField = "title";
	//var $actsAs = array('HabtmValidatable'); //This will apply to all HABTM related models
	var $actsAs = array('HabtmValidatable' => 'Genre'); //One field
	//var $actsAs = array('HabtmValidatable' => array('Genre')); //One or multiple fields 
	
    public $hasMany = array(
        'Episode' => array(
            'className'     => 'Episode',
			'order' => 'Episode.original_air_date DESC',
            'foreignKey'    => 'show_id'
        )
        ,'User' => array(
            'className'     => 'User',
			'conditions' => array('User.is_active' => '1'),
            'foreignKey'    => 'show_id'
        )
    );
	
    public $hasAndBelongsToMany = array(
        'Genre' =>
            array(
                'className' => 'Genre',
                'joinTable' => 'genres_shows',
                'foreignKey' => 'show_id',
                'associationForeignKey' => 'genre_id',
                'unique' => true,
                'fields' => 'id'
            )
    );
	
	public $validate = array(
		'title' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'required' => 'true',
				'message' => 'This show title has already been used'
			)
		),
        'tagline' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A tagline is required'
            )
        ),
        'description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A description is required'
            )
        )
	//	,'Genre' => array(
//			'rule' => array('test')
//			,'message' => 'Please select one or more genres'
//			,'required' => 'true'
//			,'allowEmpty' => 'false'
//		)
		
		// this one actually works with Show.Genre but doesn't save
		,'Genre' => array(
			'rule' => array('multiple', array('min' => 1)),
			'message' => 'Please select one or more genres'
			,'required' => 'false'
			,'allowEmpty' => 'true'
		)

	//	,'Genre' => array(
//			//'required' => array(
//				'rule' => array('beforeValidateTest'),
//				'message' => 'Please select one, two or three options'
//			//)
//    	)
//		,'Genre' => array(
//			'required' => array(
//				'rule' => array('multiple', array(
//					'min' => 1,
//					'max' => 3
//				)),
//				'message' => 'Please select one, two or three options'
//			)
//    	)
	//	,'Genre' => array(
//            'required' => array(
//                'rule' => array('notEmpty'),
//				'allowEmpty' => false,
//                'message' => 'At least one genre is required'
//            )
//        )
	   
	   
	);
	
	//function beforeValidateTest() {
//		if (!isset($this->data['Genre']['Genre']) || empty($this->data['Genre']['Genre'])) {
//			$this->invalidate('non_existent_field'); // fake validation error on Project
//			$this->User->invalidate('Genre', 'At least one genre is required');
//	  	}
//	  	return true;
//	}
}

?>