<?php
#https://stackoverflow.com/questions/22240248/how-to-commit-github-using-php
$question_asked = '';
$extension = '.txt';
$_POST = json_decode(file_get_contents("php://input"), true);

( isset($_POST['one']) ) && $question_asked = 'one';
( isset($_POST['two']) ) && $question_asked = 'two';
( isset($_POST['three']) ) && $question_asked = 'three';
( isset($_POST['four']) ) && $question_asked = 'four';

read_and_change_file($question_asked, $extension);
commit_to_git();

function read_and_change_file($question_asked, $extension) {

    if ( $question_asked !== '' ) {
        $file = fopen( $question_asked . $extension, 'r' ) or die('File not found!');
        $file_content = fread($file,filesize( $question_asked . $extension));
        $file_content_array = explode(',', $file_content);
        $file_content_array[$_POST[$question_asked]]++;
        fclose($file);
        
        $file = fopen( $question_asked . $extension, 'w+' ) or die('File not found!');
        fwrite($file, implode(',', $file_content_array));
        $file_data = fread($file,filesize( $question_asked . $extension));
        fclose($file);

        echo implode(',', $file_content_array);
    }

}

function commit_to_git() {

    shell_exec('git config user.name "Tiinocm"');
    shell_exec('git config user.email tinoclase@gmail.com');
    shell_exec('git add --all');
    shell_exec('git commit -m "' . strtotime("now") .'"');
    shell_exec('git push');
}