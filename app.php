<?php 
require 'config/config.php'; 
session_start();
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
        <div class="divider"></div> <!-- Using a div as a divider -->
        <div class="main-section">
            <div class="add-section">
                <form action="add_list.php" method="POST" autocomplete="off">
                    <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                        <input type="text" 
                               name="title" 
                               style="border-color: #ff6666"
                               placeholder="This field is required" />
                        <button type="submit" class="btn btn-primary btn-block">Add &nbsp; <span>&#43;</span></button>
                    <?php } else { ?>
                        <input type="text" 
                               name="title" 
                               placeholder="What do you need to do?" />
                        <button type="submit" class="btn btn-primary btn-block">Add &nbsp; <span>&#43;</span></button>
                    <?php } ?>
                </form>
            </div>
            <?php 
            $todos = $pdo->query("SELECT * FROM lists ORDER BY id DESC");
            ?>
            <div class="show-todo-section">
                <?php if($todos->rowCount() <= 0){ ?>
                    <div class="todo-item">
                        <div class="empty">No items to display</div>
                    </div>
                <?php } ?>

                <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="todo-item">
                        <span id="<?php echo $todo['id']; ?>" class="remove-to-do">x</span>
                        <?php if($todo['checked']){ ?> 
                            <input type="checkbox"
                                   class="check-box"
                                   data-todo-id ="<?php echo $todo['id']; ?>"
                                   checked />
                            <h2 class="checked"><?php echo $todo['title'] ?></h2>
                        <?php } else { ?>
                            <input type="checkbox"
                                   data-todo-id ="<?php echo $todo['id']; ?>"
                                   class="check-box" />
                            <h2><?php echo $todo['title'] ?></h2>
                        <?php } ?>
                        <br>
                        <small>created: <?php echo $todo['date_time'] ?></small> 
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              } else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>
