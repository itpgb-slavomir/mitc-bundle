<?php
/**
 * SK ITC Bundle Mylyn Editors
 *
 * @author Slavomir <slavomir.sidor@gmail.com>
 *
 */
namespace SK\ITCBundle\Service\Mylyn;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\XmlAttribute;

class MylynEditors
{

	/**
	 * @Type("SK\ITCBundle\Service\Mylyn\MonitoredWindowOpenEditors")
	 * @SerializedName("MonitoredWindowOpenEditors")
	 *
	 * @var MonitoredWindowOpenEditors
	 */
	protected $monitoredWindowOpenEditors;

	/**
	 * @XmlAttribute
     * @Type("string")
     */
	protected $class;

	/**
	 * @XmlAttribute
	 * @Type("boolean")
	 */
	protected $isActive;

	/**
	 * @XmlAttribute
	 * @Type("boolean")
	 */
	protected $isLaunching;

	/**
	 * @XmlAttribute
	 * @Type("integer")
	 */
	protected $number;
}