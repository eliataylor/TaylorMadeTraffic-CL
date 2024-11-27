<?php

$devtools = sortDevToolsByFilters($devtools, $qtfilter);

?>


<div class="chip-container">
    <?php foreach ($devtools as $tool): ?>
        <span class="chip" >
            <a href="/technologies?qtfilter=<?php echo trim($tool); ?>" class="nolink">
            <?php echo trim($tool); ?>
            </a>
        </span>
    <?php endforeach; ?>
</div>
