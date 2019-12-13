<?php

/**
 * SS MAPI Bundle SOAP WSDL tDefinitions
 *
 * @licence GNU GPL
 * 
 * @author Slavomir <slavomir.sidor@gmail.com>
 */
namespace SS\MAPIBundle\ORM\WSDL;

class tDefinitions extends Element
{

	const ELEMENT_NAME = 'wsdl:definitions';

	/**
	 * SS MAPI Bundle XML Document Contructor
	 *
	 * @param string $uri        	
	 */
	public function __construct( 
		\DOMElement $element )
	{

		$this->setDOMElement( $element );
		
		foreach( $element->childNodes as $childNode )
		{
			if( $childNode instanceof \DOMElement )
			{
				switch( $childNode->tagName )
				{
					case tMessage::ELEMENT_NAME:
						$this->message[] = new tMessage( $childNode );
						break;
					case tPortType::ELEMENT_NAME:
						$this->portType[] = new tPortType( $childNode );
						break;
					case tTypes::ELEMENT_NAME:
						$this->types = new tTypes( $childNode );
						break;
					case tBinding::ELEMENT_NAME:
						$this->binding[] = new tBinding( $childNode );
						break;
					case tService::ELEMENT_NAME:
						$this->service[] = new tService( $childNode );
						break;
				}
			}
		}
	
	}

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions Target Namespace
	 *
	 * @var string
	 */
	protected $tagretNamespace;

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions Name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions
	 *
	 * @var tImport[]
	 */
	protected $import;

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions
	 *
	 * @var tTypes[]
	 */
	protected $types;

	/**
	 * SS MAPI Bundle SOAP WSDL tMessage
	 *
	 * @var tMessage[]
	 */
	protected $message;

	/**
	 * SS MAPI Bundle SOAP WSDL Port Type
	 *
	 * @var tPortType[]
	 */
	protected $portType;

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions Bindings
	 *
	 * @var tBinding[]
	 */
	protected $binding;

	/**
	 * SS MAPI Bundle SOAP WSDL tDefinitions tService
	 *
	 * @var tService[]
	 */
	protected $service;

	/**
	 *
	 * @return string
	 */
	public function getTagretNamespace()
	{

		return $this->tagretNamespace;
	
	}

	/**
	 *
	 * @param string $tagretNamespace        	
	 */
	public function setTagretNamespace( 
		$tagretNamespace )
	{

		$this->tagretNamespace = $tagretNamespace;
		return $this;
	
	}

	/**
	 *
	 * @return string
	 */
	public function getName()
	{

		return $this->name;
	
	}

	/**
	 *
	 * @param string $name        	
	 */
	public function setName( 
		$name )
	{

		$this->name = $name;
		return $this;
	
	}

	/**
	 *
	 * @return tImport[]
	 */
	public function getImport()
	{

		return $this->import;
	
	}

	/**
	 *
	 * @param tImport[] $import        	
	 */
	public function setImport( 
		$import )
	{

		$this->import = $import;
		return $this;
	
	}

	/**
	 *
	 * @return tTypes[]
	 */
	public function getTypes()
	{

		return $this->types;
	
	}

	/**
	 *
	 * @param tTypes[] $types        	
	 */
	public function setTypes( 
		$types )
	{

		$this->types = $types;
		return $this;
	
	}

	/**
	 *
	 * @return tMessage[]
	 */
	public function getMessage()
	{

		return $this->message;
	
	}

	/**
	 *
	 * @param tMessage[] $message        	
	 */
	public function setMessage( 
		$message )
	{

		$this->message = $message;
		return $this;
	
	}

	/**
	 *
	 * @return tPortType[]
	 */
	public function getPortType()
	{

		return $this->portType;
	
	}

	/**
	 *
	 * @param tPortType[] $portType        	
	 */
	public function setPortType( 
		$portType )
	{

		$this->portType = $portType;
		return $this;
	
	}

	/**
	 *
	 * @return tBinding[]
	 */
	public function getBinding()
	{

		return $this->binding;
	
	}

	/**
	 *
	 * @param tBinding[] $binding        	
	 */
	public function setBinding( 
		$binding )
	{

		$this->binding = $binding;
		return $this;
	
	}

	/**
	 *
	 * @return tService[]
	 */
	public function getService()
	{

		return $this->service;
	
	}

	/**
	 *
	 * @param tService[] $service        	
	 */
	public function setService( 
		$service )
	{

		$this->service = $service;
		return $this;
	
	}

}