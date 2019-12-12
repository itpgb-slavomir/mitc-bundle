<?php
/**
 * SK ITC Bundle Mylyn Input
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 *
 */
namespace SK\ITCBundle\Service\Mylyn;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlAttribute;

class Input
{

	/**
	 * @XmlAttribute
	 * @Type("integer")
	 */
	protected $factoryID;

	/**
	 * @XmlAttribute
	 * @Type("string")
	 */
	protected $taskHandle;
}