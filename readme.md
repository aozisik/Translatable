#Laravel Translatable#
[![Build Status](https://travis-ci.org/aozisik/Translatable.svg)](https://travis-ci.org/aozisik/Translatable)
[![Latest Unstable Version](https://poser.pugx.org/aozisik/translatable/v/unstable.svg)](https://packagist.org/packages/aozisik/translatable)
[![License](https://poser.pugx.org/aozisik/translatable/license.svg)](https://packagist.org/packages/aozisik/translatable)

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

Upon adding the "TranslatableTrait" trait, your model will begin to translate localizedFields on the fly. However, if you have data in the table previously saved without the trait, it might yield unexpected results.

If you are starting from scratch, Translatable works like this:

* When you access an attribute, say $book->name, translatable will automatically translate it to the activated language*

* When you set an attribute, and the value is a string, it will be assumed that this string is in the activated language*

* To store multilingual translations at once, you must assign an array to the attribute. The keys in the array should correspond to language codes. 


		$book->name = array('en' => 'Book', 'fr' => 'Le Livre', 'de' => 'Das Buch');
		$book->save;
		
In the database, the name field for this record looks like this: `{"en":"Book","fr":"Le Livre","de":"Das Buch"}`

Pretty simple! However, please take into account that the designated input length for the field may not be enough to store lengthy strings of JSON.

So rather than VARCHAR(255), you are usually better off using TEXT for localized fields.

**How to Get Translations in a Specific Language**

You may need to get translations in a specific language other than the activated language at that time.

This can be done like that:
    
    $book->getTranslation('name', 'de); // Das Buch
    $book->getTranslation('name', 'en); // Book
    $book->getTranslation('name', 'fr); // Le Livre
    
    $book->name; // Book, if App::getLocale() returns "en"    
	

*Activated language is determined by `App::getLocale()`

## Pros and Cons##

Let's start with pros:

+ No additional tables to store translations,
+ No significant change in code required,
+ No migrations, no configuration, no nothing

Just add the trait to your model and it works out of the box.

However there are some drawbacks

- Sorting can be a problem as localized fields will basically store json serializations. 
- If you have existing data, you should store them in the same format as this trait does.
- You may need to turn some VARCHAR's into TEXT's depending on your current database design.

---	

Overall, I believe this to be a very practical approach and it is quite simple to implement.

I am open to suggestions. Pull requests and bug reports are welcomed.