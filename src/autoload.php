<?php

/**
* A simple PHP PSR-4 compatible autoloader.
*/
class ValidatorAutoloader
{
	/**
	* @var array $prefixes A mapping of namespace prefixes to base directories.
	*/
	protected $prefixes = [
		'Validator' => 'src\\Validator',
	];

	/**
	* Registers the autoloader with SPL.
	*/
	public function register()
	{
		spl_autoload_register([$this, 'loadClass']);
	}

	/**
	* Loads a class.
	* @param string $className
	*/
	public function loadClass(string $className)
	{
		//Get list of namespaces, and unqualified class name
		$namespaces = explode('\\', $className);
		$class = array_pop($namespaces);

		//Find the longest prefix to use as the base path
		$basePath = "";
		$pathParts = [];
		while(count($namespaces))
		{
			$prefixStr = implode('\\', $namespaces);
			if(isset($this->prefixes[$prefixStr]))
			{
				$basePath = $this->prefixes[$prefixStr];
				break;
			}

			else
			{
				array_unshift($pathParts, array_pop($namespaces));
			}
		}

		//Found
		if($basePath != "")
		{
			array_unshift($pathParts, $basePath);
			array_push($pathParts, $class . '.php');
			$file = implode(DIRECTORY_SEPARATOR, $pathParts);
			if(file_exists($file))
			{
				require $file;
			}
		}
	}
}

?>