<!-- application/views/differences_view.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Upwork Job Differences</title>
</head>
<body>

<h2>New Upwork Jobs:</h2>

<?php if (!empty($newJobs)): ?>
    <ul>
        <?php foreach ($newJobs as $newJob): ?>

            <li>
                <h2><a href="<?php echo $newJob['link']; ?>" target="_blank"><?php echo $newJob['title']; ?></a></h2>
                <h4><?php echo $newJob['pubDate']; ?></h4>
                <div><?php echo $newJob['description']; ?></div>
                <?php if (isset($newJob['descriptionHTML'])): ?>
                    <pre><?php echo $newJob['descriptionHTML']; ?></pre>
                <?php endif; ?>
            </li>

        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No new jobs found.</p>
<?php endif; ?>

</body>
</html>
