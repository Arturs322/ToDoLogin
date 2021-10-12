<!doctype html>
<html lang="en">
<style>
    body {background: lightgreen};

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To do list</title>
</head>
<style>
    .styled-table th,
    .styled-table td {
        padding: 12px 15px;
    }
    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }
    .styled-table {
        background-color: cornflowerblue;
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }
</style>
<body>
<h1>Tasks</h1> (<a href="/tasks/create">Create</a>)
<ul>
    <?php foreach ($tasks->getTasks() as $task): ?>
        <li>
            <a href="/tasks/<?php echo $task->getId(); ?>">
            <?php  echo $task->getTitle(); ?></li>
        </a>
    <small>(<?php echo $task->getCreatedAt(); ?>)</small>
        <form action="/tasks/<?php echo $task->getId()?>" method="post">
            <button type="submit">X</button>
        </form>
    <?php endforeach; ?>
</ul>
<header>
    <h1 style="text-align: center">To do list!</h1>
</header>

<table class="styled-table">
    <thead>
    <tr>
        <th>What to do</th>
        <th>When</th>
    </tr>
    </thead>
    <tbody>
    <tr class="active-row">
        <td><?php echo $todo . PHP_EOL;?></td>
        <td><?php echo $when . PHP_EOL;?></td>
    </tr>
    <tr class="active-row">
        <td><?php fwrite($data, $todo) . PHP_EOL;?></td>
        <td><?php fwrite($data, $when) . PHP_EOL;?></td>
    </tr>
    </tbody>
</table>

<form method="POST" style="text-align: center">
    <label for="todo"><b>To do:</b></label><br>
    <textarea name="todo" id="todo" cols="20" rows="5"></textarea><br><br>
    <div style="color: red">
        <?php if (empty($_POST['todo']))
        {
            echo "* You have not entered what to do!" . PHP_EOL;
        }?>
    </div>

    <br>
    <label for="when"><b>When:</b></label><br>
    <input type="text" id="when" name="when"><br><br>
    <div style="color: red">
        <?php if (empty($_POST['when']))
        {
            echo "* You have not entered when!" . PHP_EOL;
        }?>
    </div>
    <input style="font-size: 20px" type="submit" value="Add">
</form>

</body>
</html>