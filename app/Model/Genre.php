<?php

// app/Model/Genre.php
class Genre extends AppModel {
	var $name = "Genre";
	var $displayField = "title";
	
    public $hasAndBelongsToMany = array(
        'Show' =>
            array(
                'className'              => 'Show',
                'joinTable'              => 'genres_shows',
                'foreignKey'             => 'genre_id',
                'associationForeignKey'  => 'show_id',
                'unique'                 => true,
                'conditions'             => '',
                'fields'                 => 'title',
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
				'message' => 'This genre title has already been used'
			)
		)
	);
}

?>