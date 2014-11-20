<?php namespace Aozisik\Translatable;

class TranslatorTest extends \PHPUnit_Framework_TestCase {

	 public function testInstantiationWithoutArguments(){
	 	$translator = new Translator();
	 	$this->assertInstanceOf('Aozisik\Translatable\Translator', $translator);
	 }

	 public function testInstantiationWithString(){
	 	$translator = new Translator('test');
	 	$this->assertInstanceOf('Aozisik\Translatable\Translator', $translator);
	 }	 

	 public function testInstantiationWithArray(){
	 	$translator = new Translator(array('test' => 'test'));
	 	$this->assertInstanceOf('Aozisik\Translatable\Translator', $translator);
	 }

	 public function testAddsTranslation(){
	 	$translator = new Translator();
	 	$translator->addTranslation('en', 'test');

	 	// it should add this, count should be 1
	 	$this->assertCount(1, $translator->translations);

	 	// passing invalid data types.
	 	$translator->addTranslation(2323, array('e'));
	 	// count should stay the same
	 	$this->assertCount(1, $translator->translations);

	 	// language is missing
	 	$translator->addTranslation('', 'translation');
		// count should stay the same
		$this->assertCount(1, $translator->translations);

		// adding another valid translation
		$translator->addTranslation('fr', 'Test');
		// the cound should increase
		$this->assertCount(2, $translator->translations);
	 }
}