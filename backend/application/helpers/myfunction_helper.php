<?php 
// My Function Helper contains all created function by user

if(!function_exists('pre'))
{
	function pre($data)
	{
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
}