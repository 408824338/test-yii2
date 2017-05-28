
<?php if ($this->beginCache('cache-out-div', ['duration' => 20])) { ?>
    <div id="cache-out-div">
        <div>这里是外层x</div>

        <?php if ($this->beginCache('cache-in-div', ['duration' => 1])) { ?>
        <div id="cache-in-div">
            <div>这是内层yy</div>
        </div>

        <?php
            $this->endCache();
        } ?>
    </div>

    <?php
    $this->endCache();
}
?>
