<head>
    <title>Cron</title>
</head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<body>
<h1>Cron page</h1>

<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/bot_buy_1.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script> 
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron_status.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>  
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron_autosellcheckup.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron_autosellcheckup_bgl.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron_autosell.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron_pnl.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>

<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron/cron_ticker.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script>
<script type="text/javascript">
    setInterval(function(){
        $.get('http://localhost/v3/cron/cron_balance.php', function(data) {
            console.log(data);
         });
    }, 60000);
</script> 
</body>