## Synopsis

Lightwieght PHP PDO wrapper

## Code Example

require __DIR__ . 'dbLibrary.php';

$db = New Database("LocalMySql");
$jobs = $db->get("select * from jobs limit 1");
var_dump($jobs);

## Motivation

it was to make my life easier

## Installation

It can mbe installed through composer
..

## License

MIT