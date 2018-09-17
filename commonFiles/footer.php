</div>
<footer class="container">
    <span>
        <?php
        global $en;
        echo $en['labels']['common']['copyrights'];
        ?>
    </span>
</footer>

<?php
global $siteRoot, $docRoot;
$module = getCurrentModuleName();
$jsFile = $docRoot . 'static/js/' . $module . '.js';
if (file_exists($jsFile)) {
    echo '<script src="' . $siteRoot . 'static/js/' . $module . '.js"></script>';
}
?>

</body>
</html>	
