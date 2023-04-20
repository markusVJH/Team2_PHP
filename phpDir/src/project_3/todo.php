<?php
// connect to database
$host ='db1';
$dbname = 'todo';
$user = 'root';
$pass = 'lionPass';

$conn = new mysqli($host, $user, $pass, $dbname);

// handle form submissions
if(isset($_POST['create_todo'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];

  $sql = "INSERT INTO tasks (title, description) VALUES ('$title', \"$description\")";
  $conn->query($sql);
}

if(isset($_POST['update_todo'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  $sql = "UPDATE tasks SET title='$title', description='$description' WHERE id='$id'";
  $conn->query($sql);
}

if(isset($_POST['delete_todo'])) {
  $id = $_POST['id'];

  $sql = "DELETE FROM tasks WHERE id='$id'";
  $conn->query($sql);
}

//display editing options when clicking edit
if(isset($_POST['edit_todo'])) {
  $id = $_POST['id'];
  $sql = "SELECT * FROM tasks WHERE id='$id'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
      echo "<div class='container'>
              <form method='POST' id='editform'>
                <h3>Edit this todo task:</h3>
                <input type='hidden' name='id' value='" . $row["id"] . "'>
                <label for='edit-title'>Title:</label>
                <input id='edit-title' type='text' name='title' placeholder='Title' value='" . $row["title"] . "' required><br>
                <label for='edit-description'>Description:</label>
                <textarea id='edit-description' name='description' placeholder='Description'>" . $row["description"] . "</textarea><br>
                <button type='submit' name='update_todo'>Update Todo</button>
              </form>
            </div>";
}
// display all tasks
$result = $conn->query("SELECT * FROM tasks");

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Todo App</title>
  <style>
  <?php include "todo.css" ?>
</style>
</head>
<body>
    <div class="todo-container">
        <?php
            while ($row = $result->fetch_assoc()) {
              echo "
                  <div class='todo-card'>
                    <h3>" . $row["title"] . "</h3>
                    <p>" . $row["description"] . "</p>
                    <form method='POST'>
                      <input type='hidden' name='id' value='" . $row["id"] . "'>
                      <button type='submit' name='delete_todo' id='delete'>Delete</button>
                    </form>
                    <form method='POST' action='todo.php'>
                      <input type='hidden' name='id' value='" . $row["id"] . "'>
                      <button type='submit' name='edit_todo' id='edit'>Edit</button>
                    </form>
                  </div>
              ";
            }
        ?>
    </div>
  <div class="container">
<!-- HTML FORM TO CREATE A NEW TODO -->
 <form method="POST" id="create">
  <input type="text" name="title" placeholder="The task" required><br>
  <textarea name="description" placeholder="Description (optional)"></textarea><br>
  <button type="submit" name="create_todo">Create Todo</button>
</form>
</div>
</body>
</html>