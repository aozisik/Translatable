<?php namespace Aozisik\Translatable;


class Translator {

	private $translations;

	public function __construct($input){
		$this->translations = array();
		if($this->processInput($input)) {
			return $this->serialize();
		} else {
			return false;
		}
	}

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

	public function processInput($input){
		if(is_string($input)){
			$this->addTranslation(\App::getLocale(), $input);
			return true;
		}

		if(is_array($input)){

			foreach($input as $language => $translation){
				$this->addTranslation($language, $translation);
			}

			return true;
		}

		// do not know what to do with input
		return false;
	}

	public function serialize(){
		return json_encode($this->translations);
	}

}