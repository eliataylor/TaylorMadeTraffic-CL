<?php

if (!empty($qtfilter)) {
    $devtools = sortDevToolsByFilters($devtools, $qtfilter);
}
if (empty($devtools)) return '';

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
