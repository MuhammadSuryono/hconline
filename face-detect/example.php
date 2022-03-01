<?php

include "FaceDetector.php";

$detector = new svay\FaceDetector('detection.dat');
$detector->faceDetect('sample-image1.jpg');
$detector->cropFaceToJpeg();

?>
