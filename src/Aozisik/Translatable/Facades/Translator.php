<?php namespace Aozisik\Translatable\Facades;

use Illuminate\Support\Facades\Facade;

class Translator extends Facade
{
	protected static function getFacadeAccessor() { return 'Translator'; }
}