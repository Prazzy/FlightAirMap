<?php
require_once('require/class.Connection.php');
include_once('require/libs/geoPHP/geoPHP.inc');

if (isset($_GET['download']))
{
	header('Content-disposition: attachment; filename="airspace.geojson"');
}
header('Content-Type: text/javascript');

$Connection = new Connection();

if (!$Connection->tableExists('airspace')) {
    die;
}

if (isset($_GET['coord'])) 
{
	$coords = explode(',',$_GET['coord']);
        if ($globalDBdriver == 'mysql') {
		$query = "SELECT *, ST_AsWKB(SHAPE) AS wkb FROM airspace WHERE ST_Intersects(SHAPE, ST_Envelope(linestring(point(:minlon,:minlat), point(:maxlon,:maxlat))))";
		try {
			$sth = $Connection->db->prepare($query);
			$sth->execute(array(':minlon' => $coords[0],':minlat' => $coords[1],':maxlon' => $coords[2],':maxlat' => $coords[3]));
			//$sth->execute();
		} catch(PDOException $e) {
			echo "error";
		}
	} else {
		$query = "SELECT *, ST_AsBinary(wkb_geometry,'NDR') AS wkb FROM airspace WHERE wkb_geometry && ST_MakeEnvelope(".$coords[0].",".$coords[1].",".$coords[2].",".$coords[3].",4326)";
		try {
			$sth = $Connection->db->prepare($query);
			//$sth->execute(array(':minlon' => $coords[0],':minlat' => $coords[1],':maxlon' => $coords[2],':maxlat' => $coords[3]));
			$sth->execute();
		} catch(PDOException $e) {
			echo "error";
		}
	}
} else {
        if ($globalDBdriver == 'mysql') {
		$query = "SELECT *, ST_AsWKB(SHAPE) AS wkb FROM airspace";
	} else {
		$query = "SELECT *, ST_AsBinary(wkb_geometry,'NDR') AS wkb FROM airspace";
	}
	try {
		$sth = $Connection->db->prepare($query);
		$sth->execute();
	} catch(PDOException $e) {
		echo "error";
	}
}

$geojson = array(
    'type' => 'FeatureCollection',
    'features' => array()
);

while ($row = $sth->fetch(PDO::FETCH_ASSOC))
{
		date_default_timezone_set('UTC');
		$properties = $row;
		unset($properties['wkb']);
		unset($properties['SHAPE']);
		if ($globalDBdriver == 'mysql') {
			$geom = geoPHP::load($row['wkb']);
		} else {
			$geom = geoPHP::load(stream_get_contents($row['wkb']));
		}
		if (isset($properties['type'])) $properties['type'] = trim($properties['type']);
		$feature = array(
		    'type' => 'Feature',
		    'geometry' => json_decode($geom->out('json')),
		    'properties' => $properties
		);
		array_push($geojson['features'], $feature);
}
print json_encode($geojson, JSON_NUMERIC_CHECK);

?>