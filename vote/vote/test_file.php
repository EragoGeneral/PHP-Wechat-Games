<?php
$filename = 'jssdk/access_token.json';
if (is_writable($filename)) {
  echo 'The file is writable';
} else {
  echo 'The file is not writable';
}
?>