<?php
session_start();
session_destroy();
// Redirect to login
echo "<script> alert('Logging out');
window.location.href='../index.html';
</script>";
exit();
?>