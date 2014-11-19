#Laravel Translatable#
[![Build Status](https://travis-ci.org/aozisik/Translatable.svg)](https://travis-ci.org/aozisik/Translatable)

This package is designed to work with Laravel 4 and Eloquent ORM.

It requires no additional migrations, no changes to your current data models or no significant code revisions. The implementation is very simple and straight forward.

I devised this package as a simple means to enable fields on Eloquent models to be translatable. You just add the TranslatableTrait and you're set.


Go to your composer.json and add the following line

		"aozisik/translatable": "dev-master"

An exemplary implementation:

	<?php
	use Aozisik\Translatable\TranslatableTrait;
	
	class Books extends \Eloquent {
	
		use TranslatableTrait;
	
		protected $guarded = ['id'];
		protected $localizedFields = ['name', 'description'];
		
	}

Name and description fields in your Book model are now translatable.

##How does it Work?##

After adding the trait, your model will start automatically translating data. However, if you have previous data, it might yield unexpected results.

If you are starting from scratch, Translatable works like this:

* When you access an attribute, say $book->name, translatable will automatically translate it to the activated language* and saved to the database as if you posted a single language text. 

* When you set an attribute, and the value is a string, it will be regarded as using the activated language* 


* To send translations in multiple language you must assign an array to the attribute. The keys in the array should correspond to language codes. 


		$book->name = array('en' => 'Book', 'fr' => 'Le Livre', 'de' => 'Das Buch');
		$book->save;
		
In the database, name field for this record looks like this: `{"en":"Book","fr":"Le Livre","de":"Das Buch"}`

Pretty simple! However, please take into account that the designated input length for the field may not be enough to store paragraphs of translated data.

So rather than VARCHAR(255), you are usually better off using TEXT

**How to Get A Translation for A Specific Language**

You may need to get the translation for a specific language which is not necessarily the activated language.

This can be done like this
    
    $book->getTranslation('name', 'de); // Das Buch
    $book->getTranslation('name', 'en); // Book
    $book->getTranslation('name', 'fr); // Le Livre
    
    $book->name; // Book, if App::getLocale() returns "en"    
	


*Activated language is determined by `App::getLocale()`

## Pros and Cons##

Let's start with good news:

	1) You need no additional tables,
	2) no significant code change,
	3) no complicated stuff

Just works out of the box.

However there are some drawbacks

	1) Sorting can be a problem as localized fields will basically store json serializations. 
	2) You may need to do some prep work to get it to work with your existing data.
	3) You may need to turn some VARCHAR's into TEXT's depending on your current database design.
	
	
Overall, this is a very practical approach and it is dead simple to use it.

I am open to your suggestions. Pull requests and bug reports are welcomed.