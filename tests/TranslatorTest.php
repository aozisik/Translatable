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

	 public function testProcessesInput(){

	 	$translator = new Translator();

	 	// can process strings
	 	$this->assertTrue($translator->processInput('string'));
	 	// the string is added to translations
	 	$this->assertContains('string', $translator->translations);

	 	// can process an array
	 	$this->assertTrue($translator->processInput(array('en' => 'english', 'fr' => 'french')));
	 	
	 	// elements from this array are added to translations
	 	$this->assertContains('english', $translator->translations);
	 	$this->assertContains('french', $translator->translations);

	 	// it should not process integers
	 	$this->assertFalse($translator->processInput(1));
	 	// it should not process classes
	 	$this->assertFalse($translator->processInput(new \StdClass));
	 }

	 public function testSerialize(){

	 	$test = array('en' => 'english', 'fr' => 'french');

	 	$translator = new Translator();
	 	$translator->processInput($test);
	 	// test if json serialization is correct
	 	$this->assertJsonStringEqualsJsonString(json_encode($test), $translator->serialize());
	 }
}