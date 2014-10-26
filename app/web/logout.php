</html>
<head>
</head>
<body>
<?php
session_start();
session_destroy();
session_unset();
?>
<a href='index.php'>[Logged Out] Visit Landing Page</a>
</body>
</html>