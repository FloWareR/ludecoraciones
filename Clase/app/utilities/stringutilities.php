<?php 
namespace Utilities;

class StringUtilities 
{
  public function __construct()
  {
    
  }
  public static function cleanURIString($text)
	{	
		$text = str_replace(":","",$text);
		$text = str_replace("[","",$text);
		$text = str_replace("]","",$text);
		$text = str_replace(" - ","-",$text);
		$text = str_replace("/","",$text);
		$text = str_replace("ª","",$text);
		$text = str_replace("º","",$text);
		$text = str_replace("?","",$text);
		$text = str_replace("¿","",$text);
		$text = str_replace('"',"",$text);
		$text = str_replace("¨","",$text);
		$text = str_replace("¡","",$text);
		$text = str_replace("\\","",$text);
		$text = str_replace("°","",$text);
		$text = str_replace("¬","",$text);
		$text = str_replace("'","",$text);
		$text = str_replace(" ","-",$text);
		$text = str_replace("(","-",$text);
		$text = str_replace(")","-",$text);
		$text = str_replace("®","-",$text);
		

		//echo $text;
		$text = htmlentities($text, ENT_QUOTES, 'UTF-8');
		//$text = htmlentities($text, ENT_QUOTES);
		//echo $text;
		$text = strtolower($text); 
		$patron = array (
			// Espacios, puntos y comas por guion
			'/[\.,%_@|# ]+/' => '-',
			'/[{}*$!=() +]+/' => '', 
			// Vocales
			'/&agrave;/' => 'a',
			'/&egrave;/' => 'e',
			'/&igrave;/' => 'i',
			'/&ograve;/' => 'o',
			'/&ugrave;/' => 'u',
 
			'/&aacute;/' => 'a',
			'/&eacute;/' => 'e',
			'/&iacute;/' => 'i',
			'/&oacute;/' => 'o',
			'/&uacute;/' => 'u',
 
			'/&acirc;/' => 'a',
			'/&ecirc;/' => 'e',
			'/&icirc;/' => 'i',
			'/&ocirc;/' => 'o',
			'/&ucirc;/' => 'u',
 
			'/&atilde;/' => 'a',
			'/&etilde;/' => 'e',
			'/&itilde;/' => 'i',
			'/&otilde;/' => 'o',
			'/&utilde;/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',
 
			'/&auml;/' => 'a',
			'/&euml;/' => 'e',
			'/&iuml;/' => 'i',
			'/&ouml;/' => 'o',
			'/&uuml;/' => 'u',

			'/&Agrave;/' => 'a',
			'/&Egrave;/' => 'e',
			'/&Igrave;/' => 'i',
			'/&Ograve;/' => 'o',
			'/&Ugrave;/' => 'u',
 
			'/&Aacute;/' => 'a',
			'/&Eacute;/' => 'e',
			'/&Iacute;/' => 'i',
			'/&Oacute;/' => 'o',
			'/&Uacute;/' => 'u',
 
			'/&Acirc;/' => 'a',
			'/&Ecirc;/' => 'e',
			'/&Icirc;/' => 'i',
			'/&Ocirc;/' => 'o',
			'/&Ucirc;/' => 'u',
 
			'/&Atilde;/' => 'a',
			'/&Etilde;/' => 'e',
			'/&Itilde;/' => 'i',
			'/&Otilde;/' => 'o',
			'/&Utilde;/' => 'u',
 
			'/&Auml;/' => 'a',
			'/&Euml;/' => 'e',
			'/&Iuml;/' => 'i',
			'/&Ouml;/' => 'o',
			'/&Uuml;/' => 'u',
 
			'/&Auml;/' => 'a',
			'/&Euml;/' => 'e',
			'/&Iuml;/' => 'i',
			'/&Ouml;/' => 'o',
			'/&Uuml;/' => 'u',
 
			// Otras letras y caracteres especiales
			'/&aring;/' => 'a',
			'/&ntilde;/' => 'n',
			'/&amp;/' => '',
			'/&ldquo;/' => '',
			'/&rdquo;/' => '',
			'/&iquest;/' => '',
			'/[;]+/' => '',
			'/&euro;/' => '',
			'/&pound;/' => '',
			'/&laquo;/' => '',
			'/&raquo;/' => '',
			'/&bull;/' => '',
			'/&dagger;/' => '',
			'/&copy;/' => '',
			'/&reg;/' => '',
			'/&trade;/' => '',
			'/&deg;/' => '',
			'/&permil;/' => '',
			'/&micro;/' => '',
			'/&middot;/' => '',
			'/&ndash;/' => '',
			'/&mdash;/' => '',
			'/&#8470;/' => '',
			'/&ndash;/' => ''
 
			// Agregar aqui mas caracteres si es necesario
 
		);
 
		$text = preg_replace(array_keys($patron),array_values($patron),$text);
		return $text;
	}
}

?>