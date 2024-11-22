<?php
function fileUpload($picture, $source='user')
{
    // echo($source);
    if ($picture['error'] == 4) {
        $pictureName = "avatar.png";
        $message = "No picture has been chosen, but you can upload a picture later";
        if ($source == 'animals') {
            $pictureName = 'animal.png';
        }
    } else {
        $checkIfImage = getimagesize($picture['tmp_name']);
        $message = $checkIfImage ? "OK" : "Not an image";
    }

    if ($message == "OK") {
        // Modify the name
        // Take out the extension and save it to a variable ex. picture1.jpg
        // Change the name to a unique name, and then add the extension back
        $ext = strtolower(pathinfo($picture['name'], PATHINFO_EXTENSION));
        $pictureName = uniqid("") . "." . $ext;  // 156156156156151.jpg
        $destination = "pictures/{$pictureName}";
        if ($source == 'animals') {
            $destination = "../pictures/{$pictureName}";
        }
        move_uploaded_file($picture["tmp_name"], $destination);
    }
    //        0             1
    return [$pictureName, $message];
}
