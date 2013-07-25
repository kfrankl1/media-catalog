<?php

class Show extends AppModel {
	var $name = "Show";
	var $displayField = "title";
	
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
                'className'              => 'Genre',
                'joinTable'              => 'genres_shows',
                'foreignKey'             => 'show_id',
                'associationForeignKey'  => 'genre_id',
                'unique'                 => true,
                'conditions'             => '',
                'fields'                 => 'id',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => ''
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
	);
}

?>