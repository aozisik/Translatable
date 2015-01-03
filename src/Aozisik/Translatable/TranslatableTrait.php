<?php namespace Aozisik\Translatable;

use \Translator;

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
        
        if(isset($this->localizedFields) and in_array($key, $this->localizedFields)) {
            // translate the value and replace it with values
            $value = Translator::processAndSerialize($value);
        }

        parent::setAttribute($key, $value);
    }


    // translates model into given language
    public function translate($language_code) {
        // check if localized fields exist on model
        if( ! isset($this->localizedFields) || !is_array($this->localizedFields)) {
            return; // no localized fields
        }
        // translate each field
        foreach($this->localizedFields as $field) {
            $this->attributes[$field] = $this->getTranslation($field, $language_code);
        }
    }
}