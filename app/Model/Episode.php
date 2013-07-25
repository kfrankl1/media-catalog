<?php

// app/Model/Episode.php
class Episode extends AppModel {
	var $name = "Episode";
	
	public $belongsTo = array(
        'Show' => array(
            'className' => 'Show',
			'foreignKey' => 'show_id',
			'dependent' => 'true'
		),
        'Season' => array(
            'className' => 'Season',
			'foreignKey' => 'season_id',
			'dependent' => 'false'
		)
	);
	
    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A title is required'
            )
        ),
        'short_description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A short (one-line) description is required'
            )
        ),
        'long_description' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A long (few sentences) description is required'
            )
        ),
        'episode_number' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'An episode number is required'
			)
        ),
        'original_air_date' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An original air date is required'
            )
        ),
/*      'still_image_file' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A still image file is required'
            )
        ),
        'episode_file' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A episode file is required'
            )
        ),*/
        'show_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
				'message' => 'A show is required'
            )
        ),
		'season_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
				'message' => 'A season is required'
            )
        )
    );
	
	public function isOwnedBy($episode, $user) {
		return $this->field('id', array('id' => $episode, 'created_by' => $user)) === $episode;
	}
}

?>