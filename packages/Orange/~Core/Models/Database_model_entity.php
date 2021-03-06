<?php
/**
 * Orange
 *
 * An open source extensions for CodeIgniter 3.x
 *
 * This content is released under the MIT License (MIT)
 * Copyright (c) 2014 - 2019, Project Orange Box
 */

/**
 * Database Model Entity Abstract Class.
 *
 * This models as database record and provides a automatic "save" function
 *
 * Handles login, logout, refresh user data
 *
 * @package CodeIgniter / Orange
 * @author Don Myers
 * @copyright 2019
 * @license http://opensource.org/licenses/MIT MIT License
 * @link https://github.com/ProjectOrangeBox
 * @version v2.0.0
 * @filesource
 *
 */

abstract class Database_model_entity
{
	/**
	 * The name of the model this entity is attached to
	 * this is used to call the insert or update method on
	 * if left blank on the entity it will try to determine the model name it self.
	 *
	 * @var string
	 */
	protected $_model_name = null;

	/**
	 * errors configuration array
	 *
	 * @var {{}}
	 */
	protected $_save_columns = null;

	/**
	 *
	 * Constructor
	 *
	 * @access public
	 *
	 */
	public function __construct()
	{
		/* strip off the _entity part and replace with _model */
		if (!is_string($this->_model_name)) {
			$this->_model_name = strtolower(substr(get_called_class(), 0, -7).'_model');
		}

		log_message('info', 'Database_model_entity Class Initialized');
	}

	/**
	 *
	 * Provide a save method to auto save (update) a entity back to the database
	 *
	 * @access public
	 *
	 * @return bool
	 *
	 */
	public function save() : bool
	{
		/* get the model */
		$model = ci()->{$this->_model_name};

		/* get the primary id */
		$primary_id = $model->get_primary_key();

		/* if save columns is set then only use those properties */
		if ($this->_save_columns) {
			foreach ($this->_save_columns as $col) {
				$data[$col] = $this->$col;
			}
		} else {
			/* use all public properties */
			$data = get_object_vars($this);
		}

		/* default responds */
		$success = false;

		/* if the primary id is empty then insert the entity */
		if ($data[$primary_id] == null) {
			/* make sure the primary id is not set */
			unset($data[$primary_id]);

			/* insert the record and return the inserted record primary id */
			$success = $model->insert($data);

			/* if success is not false (fail) then set the primary_id to success - inserted record primary id */
			if ($success !== false) {
				$this->$primary_id = $success;

				$success = true;
			}
		} else {
			/* else it's a update */
			$success = $model->update($data);
		}

		/* return success */
		return (bool)$success;
	}
} /* end class */
