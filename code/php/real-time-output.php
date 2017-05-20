<p>Ctrl+Shift+J</p>
<script>
    function showMsg(msg) {
        console.log(msg)
    }
</script>
<?php
    /*
    PHP实时输出到前端
     */
    $output = [
        'Installing databases...',
        'create user...success',
        'create post...success',
        'completed.',
    ];
    if (ob_get_level() == 0) ob_start();
    for ($i = 0,$len = count($output); $i < $len; ++$i) {
        echo $output[$i],'<br>';
        showMsg($output[$i]);
        usleep(300000);
    }
    ob_end_flush();

    function showMsg($msg)
    {
        echo str_pad('',4096) . "\n";
        echo '<script>showMsg("'.$msg.'")</script>';
        flush();
        ob_flush();
    }
