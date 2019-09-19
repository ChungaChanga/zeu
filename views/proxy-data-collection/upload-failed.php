<?php
    $this->title = "Upload Result";
?>

    <h1>Upload Failed</h1>
<pre>
    <?php
        if ( isset($validationErrors) ) {
            print_r($validationErrors);
        }
    ?>
</pre>
