<?php
// সেশন শুরু করা হচ্ছে
session_start();

// সমস্ত সেশন ভেরিয়েবল মুছে ফেলা হচ্ছে
session_unset();

// সেশনটি ধ্বংস করা হচ্ছে
session_destroy();

// ব্যবহারকারীকে লগইন পেজে রিডাইরেক্ট করা হচ্ছে
header("Location: login.php");
exit;
?>
