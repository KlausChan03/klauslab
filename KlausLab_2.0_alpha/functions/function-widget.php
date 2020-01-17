<?php

// Style the Tag Cloud
function KlausLab_tag_cloud_widget( $args )
{
	$args['largest'] = 12; //largest tag
	$args['smallest'] = 12; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['number'] = '18'; //number of tags
	return $args;
}

add_filter( 'widget_tag_cloud_args', 'KlausLab_tag_cloud_widget' );

?>