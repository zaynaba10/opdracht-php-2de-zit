<?php
session_start();
require 'config/config.php';

$sortOrder = 'ASC';
$sortType = 'name';

if (isset($_GET['sort']) && in_array($_GET['sort'], ['ascending', 'descending'])) {
    $sortOrder = $_GET['sort'] == 'ascending' ? 'ASC' : 'DESC';
}

if (isset($_GET['type']) && in_array($_GET['type'], ['name', 'deadline'])) {
    $sortType = $_GET['type'];
}

$listsQuery = $pdo->prepare("SELECT * FROM tasks ORDER BY $sortType $sortOrder");
$listsQuery->execute();

$taskSortOrder = 'ASC';
$taskSortType = 'deadline';

if (isset($_GET['sort']) && in_array($_GET['sort'], ['ascending', 'descending'])) {
    $taskSortOrder = $_GET['sort'] == 'ascending' ? 'ASC' : 'DESC';
}

if (isset($_GET['type']) && in_array($_GET['type'], ['name', 'deadline'])) {
    $taskSortType = $_GET['type'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="img/logo.png" alt="Logo">
        </div>
        <div class="logo-heading">TO-DO APP</div>
        <div class="d-flex justify-content-center">
            <button class="btn btn-danger btn-md mb-3 mt-4" onclick="window.location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
        <div class="divider"></div>


        <div class="main-section">
            <div class="add-section">
                <form action="add_list.php" method="POST" autocomplete="off">
                    <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                        <input type="text" name="name" style="border-color: #ff6666" placeholder="This field is required" />
                        <button type="submit" class="btn btn-primary btn-block">
                            Add Task Group
                            <i class="fas fa-plus"></i>
                        </button>
                    <?php } else { ?>
                        <input type="text" name="name" placeholder="Group name: House, School, Business" />
                        <button type="submit" class="btn btn-primary btn-block">
                            Add Task Group
                            <i class="fas fa-plus"></i>
                        </button>
                    <?php } ?>
                </form>
            </div>
            <div class="divider"></div>

            <div class="add-task-section">
                <form action="add_task.php" method="POST" autocomplete="off">
                    <select name="list_id" class="form-control mb-2">
                        <?php
                        $lists = $pdo->query("SELECT * FROM lists ORDER BY id DESC");
                        while ($list = $lists->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value=\"{$list['id']}\">{$list['name']}</option>";
                        }
                        ?>
                    </select>
                    <input type="text" name="task_name" placeholder="Task name: study session PHP"
                        class="form-control mb-2" />
                    <input type="date" name="deadline" class="form-control mb-2" />
                    <button type="submit" class="btn btn-primary btn-block mb-2">
                        Add Task
                        <i class="fas fa-plus"></i>
                    </button>
                </form>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
            </div>
            <div class="divider"></div>

            <div class="sort-section mb-4">
                <a href="?sort=ascending&type=title" class="btn btn-info btn-sm">Title (Asc)</a>
                <a href="?sort=descending&type=title" class="btn btn-info btn-sm">Title (Desc)</a>
                <a href="?sort=ascending&type=deadline" class="btn btn-info btn-sm">Deadline (Asc)</a>
                <a href="?sort=descending&type=deadline" class="btn btn-info btn-sm">Deadline (Desc)</a>
            </div>
            <div class="divider"></div>


            <?php while ($list = $listsQuery->fetch(PDO::FETCH_ASSOC)) { ?>
                <?php
                $tasks = $pdo->prepare("SELECT * FROM tasks WHERE list_id = :list_id ORDER BY $taskSortType $taskSortOrder");
                $tasks->execute(['list_id' => $list['id']]);
                ?>

                <div class="task-list-container">
                    <h3><?php echo htmlspecialchars($list['name']); ?></h3>

                    <?php if ($tasks->rowCount() > 0) { ?>
                        <div class="task-items">
                            <?php while ($task = $tasks->fetch(PDO::FETCH_ASSOC)) {
                                $currentDate = new DateTime();
                                $deadlineDate = new DateTime($task['deadline']);
                                $interval = $currentDate->diff($deadlineDate);
                                $daysRemaining = $interval->format('%r%a');
                                $isOverdue = $daysRemaining < 0;
                                ?>
                                <div class="task-item d-flex flex-column" data-task-id="<?php echo $task['id']; ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span
                                            class="task-text <?php echo $task['is_done'] ? 'task-completed' : 'task-not-completed'; ?>">
                                            <?php echo htmlspecialchars($task['name']); ?>
                                            <small>Deadline: <?php echo htmlspecialchars($task['deadline']); ?></small>
                                        </span>
                                        <div class="delete-btn-wrapper">
                                            <button class="btn btn-danger btn-md delete-task"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </div>
                                    <div class="deadline-info">
                                        <?php if ($isOverdue) { ?>
                                            <small class="text-danger">Verlopen</small>
                                        <?php } else { ?>
                                            <small class="text-info"><?php echo $daysRemaining; ?> dagen resterend</small>
                                        <?php } ?>
                                    </div>
                                    <div class="comment-section mt-2">
                                        <form class="comment-form" method="POST">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>" />
                                            <div class="comment-form-group d-flex">
                                                <input type="text" name="comment" placeholder="Add a comment..."
                                                    class="form-control comment-input" />
                                                <button type="submit"
                                                    class="btn btn-secondary btn-sm comment-submit">Submit</button>
                                            </div>
                                        </form>
                                        <div class="comments">
                                            <?php
                                            $comments = $pdo->prepare("SELECT * FROM comments WHERE task_id = :task_id ORDER BY created_at DESC");
                                            $comments->execute(['task_id' => $task['id']]);
                                            $commentList = [];
                                            while ($comment = $comments->fetch(PDO::FETCH_ASSOC)) {
                                                $commentList[] = htmlspecialchars($comment['comment']);
                                            }
                                            if (!empty($commentList)) {
                                                echo implode(', ', $commentList);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="empty">No tasks to display</div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // if task = 1 toggle to 0 
            $(".task-list-container").on("click", ".task-text", function () {
                const span = $(this);
                const id = span.closest('.task-item').data('task-id');
                const isDone = !span.hasClass('task-completed');

                $.post('check_task.php', { id: id, is_done: isDone }, function (data) {
                    if (data != 'error') {
                        if (isDone) {
                            span.addClass('task-completed').removeClass('task-not-completed');
                        } else {
                            span.addClass('task-not-completed').removeClass('task-completed');
                        }
                    }
                });
            });

            // verwijder een task
            $(".task-list-container").on("click", ".delete-task", function () {
                const taskItem = $(this).closest('.task-item');
                const id = taskItem.data('task-id');

                $.post('delete_task.php', { id: id }, function (data) {
                    if (data != 'error') {
                        taskItem.remove();
                    }
                });
            });

            // Submit comment via AJAX
            $('.comment-form').submit(function (e) {
                e.preventDefault();
                const form = $(this);
                const task_id = form.find('input[name="task_id"]').val();
                const comment = form.find('input[name="comment"]').val();

                $.post('add_comment.php', { task_id: task_id, comment: comment }, function (response) {
                    if (response.startsWith('error')) {
                        alert(response);
                    } else {
                        const commentsDiv = form.closest('.task-item').find('.comments');
                        const existingComments = commentsDiv.text().trim();
                        const newComments = existingComments ? existingComments + ', ' + comment : comment;
                        commentsDiv.text(newComments);
                        form.find('input[name="comment"]').val('');
                    }
                });
            });
        });
    </script>
</body>

</html>