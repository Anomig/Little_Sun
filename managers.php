<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Managers</h2>
    <div class="managers">
        <?php
        // Controleren of $managers is geïnitialiseerd en niet leeg is
        if (isset($managers) && !empty($managers)) :
            foreach ($managers as $manager) :
        ?>
                <div class="manager">
                    <img src="<?php echo $manager['profile_picture']; ?>" alt="profile_pic">
                    <h3>Name: <?php echo $manager['firstname'] . " " . $manager['lastname']; ?></h3>
                    <h3>Email: <?php echo $manager['email']; ?></h3>
                    <!-- <h3>Job: <?php echo $manager['job']; ?></h3> -->
                    
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Er zijn geen managers gevonden.</p>
        <?php endif; ?>
    </div>

    <button>Add Manager</button>
</body>

</html>