<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Display a logout success message
echo "<script>
  alert('Berhasil logout');
  window.location.href = 'login.php';
</script>";

// Ensure the script stops executing after the redirect
exit();
?>