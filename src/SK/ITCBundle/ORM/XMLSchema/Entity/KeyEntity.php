<?php

/**
 * SK ITCBundle XML Schema Entity KeyEntity
 *
 * @licence GNU GPL
 * 
 * @author Slavomir Kuzma <slavomir.kuzma@gmail.com>
 */
namespace SK\ITCBundle\ORM\XMLSchema\Entity;

use SK\ITCBundle\ORM\XMLSchema\Entity;

class KeyEntity extends Entity
{

	/**
	 * SK ITCBundle XML Schema Entity KeyEntity Name
	 *
	 * @var string
	 */
	protected $elementTagName = 'key';

	/**
	 *
	 * @var SelectorEntity[]
	 */
	protected $selector;

	/**
	 *
	 * @var FieldEntity[]
	 */
	protected $field;

}