<?php

if ( !empty( $_FILES ) ) {

    $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
    $uploadPath = get_dir_path(dirname( __FILE__ ), 1) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
	
 	move_uploaded_file( $tempPath, $uploadPath );

    $answer = array( 'answer' => 'File transfer completed' );
    $json = json_encode( $answer );

    echo $json;

} else {
	echo 'No files';
}

function get_dir_path($path_to_file, $levels_up=0) {
	$directory_path = dirname($path_to_file);

	$directories = preg_split('/\//', $directory_path);
	$levels_to_include = sizeof($directories) - $levels_up;
	$directories_to_return = array_slice($directories, 0, $levels_to_include);
	return implode($directories_to_return, '/');
}


?>