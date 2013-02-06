<?php //I might be able to delete this
require('');
class NameFormatModule
{
	function __construct(){}
	
	public function activate($name = NULL)
	{
		return ucwords ( strtolower( $name ) ) ;
	}	
}
?>