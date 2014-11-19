<?php namespace Aozisik\Translatable;

trait TranslatableTrait {
	
	public function getTranslation($field, $language_code)
	{
		if(empty($this->attributes[$field])) {
			return null;
		}

		$localized = json_decode($this->attributes[$field], 1);

		if(!isset($localized[$language_code])) {
			return null;
		}

		return $localized[$language_code];
	}

    public function getAttribute($key) {

    	if(!isset($this->localizedFields) or !in_array($key, $this->localizedFields)) {
			return parent::getAttribute($key);
    	}
        
        return $this->getTranslation($key, \App::getLocale());
    }

    public function setAttribute($key, $value) {
		
    	if(!isset($this->localizedFields) or !in_array($key, $this->localizedFields)) {

    		parent::setAttribute($key, $value);

    	} else {

    		$translator = new \Aozisik\Translatable\Translator($value);
    		parent::setAttribute($key, $translator->serialize());
    	}
    }
}