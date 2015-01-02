<?php namespace Aozisik\Translatable;


class Translator {

	public $translations;

	/*
	* You can instantiate this class with no parameters, a string or an array.
	* If you pass arguments as you instantiate, it will process them right away.
	*/
	public function __construct(){

		$this->translations = array();	
	}

	/*
	* Add a translation for a specific language
	*/
	public function addTranslation($language, $translation){

		if(!is_string($language) or !is_string($translation)) {
			return false;
		}

		if(empty($language)){
			return false;
		}

		$this->translations[$language] = $translation;
		return true;
	}

	/*
	* Pass your form, an array, a string, whatever.
	* Trasnlatable will try to make a sense of it.
	*/
	public function processInput($input){

		// if this is a string, mark this as the current language
		if(is_string($input)){
			$this->addTranslation(\App::getLocale(), $input);
			return true;
		}

		// if this is an array, add each item as translations
		if(is_array($input)){

			foreach($input as $language => $translation){
				$this->addTranslation($language, $translation);
			}

			return true;
		}

		// do not know what to do with input
		return false;
	}

	// convert translations to JSON format for storage
	public function serialize(){
		return json_encode($this->translations);
	}

	public function processAndSerialize($input) {
		// empty translations array
		$this->translations = array();
		// process translations
		$this->processInput($input);
		// serialize translations into JSON
		return $this->serialize();
	}

}