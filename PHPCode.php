<?php
session_start();
$host="localhost";$user="root";$pass="";$db="blog";
$conn=new mysqli($host,$user,$pass,$db);
if($conn->connect_error){die("DB Error");}
$page=$_GET['page']??'home';

if($page=="register" && $_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];
    $password=password_hash($_POST['password'],PASSWORD_BCRYPT);
    $conn->query("INSERT INTO users (username,password) VALUES('$username','$password')");
    header("Location:?page=login");exit;
}
if($page=="login" && $_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];$password=$_POST['password'];
    $res=$conn->query("SELECT * FROM users WHERE username='$username'");
    if($res->num_rows>0){
        $row=$res->fetch_assoc();
        if(password_verify($password,$row['password'])){
            $_SESSION['user']=$row['id'];
            header("Location:?page=home");exit;
        }
    }
}
if($page=="logout"){session_destroy();header("Location:?page=login");exit;}
if(!isset($_SESSION['user']) && !in_array($page,["login","register"])){header("Location:?page=login");exit;}

if($page=="create" && $_SERVER["REQUEST_METHOD"]=="POST"){
    $title=$_POST['title'];$content=$_POST['content'];
    $conn->query("INSERT INTO posts (title,content,created_at) VALUES('$title','$content',NOW())");
    header("Location:?page=home");exit;
}
if($page=="edit" && $_SERVER["REQUEST_METHOD"]=="POST"){
    $id=$_GET['id'];$title=$_POST['title'];$content=$_POST['content'];
    $conn->query("UPDATE posts SET title='$title',content='$content' WHERE id=$id");
    header("Location:?page=home");exit;
}
if($page=="delete"){
    $id=$_GET['id'];$conn->query("DELETE FROM posts WHERE id=$id");
    header("Location:?page=home");exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Basic CRUD App</title></head>
<body>
<?php if($page=="register"): ?>
<h2>Register</h2>
<form method="post" action="?page=register">
<input name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button>Register</button>
</form>
<a href="?page=login">Login</a>

<?php elseif($page=="login"): ?>
<h2>Login</h2>
<form method="post" action="?page=login">
<input name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button>Login</button>
</form>
<a href="?page=register">Register</a>

<?php elseif($page=="home"): ?>
<a href="?page=create">New Post</a> | <a href="?page=logout">Logout</a><hr>
<?php $res=$conn->query("SELECT * FROM posts ORDER BY created_at DESC");while($row=$res->fetch_assoc()): ?>
<h3><?php echo $row['title']; ?></h3>
<p><?php echo $row['content']; ?></p>
<a href="?page=edit&id=<?php echo $row['id']; ?>">Edit</a>
<a href="?page=delete&id=<?php echo $row['id']; ?>">Delete</a><hr>
<?php endwhile; ?>

<?php elseif($page=="create"): ?>
<h2>Create Post</h2>
<form method="post" action="?page=create">
<input name="title" placeholder="Title" required><br>
<textarea name="content" placeholder="Content" required></textarea><br>
<button>Create</button>
</form>
<a href="?page=home">Back</a>

<?php elseif($page=="edit"): ?>
<?php $id=$_GET['id'];$res=$conn->query("SELECT * FROM posts WHERE id=$id");$p=$res->fetch_assoc(); ?>
<h2>Edit Post</h2>
<form method="post" action="?page=edit&id=<?php echo $id; ?>">
<input name="title" value="<?php echo $p['title']; ?>" required><br>
<textarea name="content" required><?php echo $p['content']; ?></textarea><br>
<button>Update</button>
</form>
<a href="?page=home">Back</a>
<?php endif; ?>
</body>
</html>