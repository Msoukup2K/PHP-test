<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;
use Nette\Application\LinkGenerator;

class UrlShortManager 
{

 	use Nette\SmartObject;

	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Context $database)
	{
		$this->database = $database;

	}

	public function insertRed( int $id )
	{
		$ip_add = $_SERVER['REMOTE_ADDR'];

		$this->database->table('stats')->insert([
			'url_id' => $id,
			'ip_add' => $ip_add,
			'db_down' => date("Y-m-d H:i:s"),
		]);


		return $this->database->table('url')->where('id = ?', $id)->fetch()['long_url'];
	}
	

	public function getUrl( string $url )
	{
		return $this->database->table('url')->where('short_url = ?', $url)->fetch()['long_url'];

	}
	public function shortUrl( string $value )
	{
		if( filter_var($value, FILTER_VALIDATE_URL) )
		{
			//vytvoříme Shortcode
			$short = substr(md5(uniqid(strval(rand()), true)),0,6);


			$url = $this->database->table('url')->insert([
				'long_url' => $value,
				'short_url' => $short,
				'created' => date("Y-m-d H:i:s"),
			]);

			$this->database->table('stats')->insert([
				'url_id' => $url->id,
				'ip_add' => $_SERVER['REMOTE_ADDR'],
			]);

		}


	}


	public function getUrls(): array
	{
		$ip_add = $_SERVER['REMOTE_ADDR'];
	
		$stats = $this->database->table('stats')->where('ip_add = ?', $ip_add);

		$data = [];
		foreach( $stats as $stat )
		{
			if( $stat['db_down'] != NULL || (strtotime(strval($stat['db_down'])) < time() + 86400) )
			{
				if( !in_array($stat->url,$data) ) 
					$data[] = $stat->url;
			}
				
		}

		return $data;
	}


}