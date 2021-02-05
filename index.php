<?php

$insert = false;
$update = false;
$delete = false;
// DB connection
$servername="localhost";
$username="root";
$password="";
$database="todo";

$conn=mysqli_connect($servername,$username,$password,$database);

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `taks` WHERE `sr.no` = $sno";
  $result = mysqli_query($conn, $sql);
}


if($_SERVER['REQUEST_METHOD']=="POST"){
  if (isset( $_POST['snoEdit'])){
    // Update the task
      $sno = $_POST["snoEdit"];
      $titleEdit = $_POST["titleEdit"];
      $descriptionEdit = $_POST["descriptionEdit"];
     
    // Sql query to be executed
    $sql = "UPDATE `tasks` SET `title` = '$titleEdit' , `description` = '$descriptionEdit' WHERE `tasks`.`sr.no` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update = true;
  }
}
  else{
  // insertion of tasks 
    $title=$_POST["title"];
    $description=$_POST["description"];
    $sql="INSERT INTO `tasks` ( `title`, `description`) VALUES ('$title', '$description')";
    $result= mysqli_query($conn,$sql);

    if($result){
        $insert=true;
    }
}
}

?>


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="style.css"> -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
  <title>i-Notes</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <a class="navbar-brand" href="#">i-Notes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
 <!-- insert alert  -->
 <?php
if($insert){
echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>success!</strong> Your task added successfully.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
}
?>
  <!-- delete alert  -->
  <?php
  if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been deleted successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>
  <!-- update alert  -->
<?php
  if($update){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been updated successfully
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span>
    </button>
  </div>";
  }
  ?>


  <div class="container-fluid">


    <div class="container my-4">
      <h4>Add a Note</h4>
      <form action="/crud/index.php" method="post">
        <div class="form-group">
          <label for="title"><b>To Do</b></label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
            placeholder="Add a task">
        </div>
        <div class="form-group">
          <label for="desc"><b>Description</b></label>
          <textarea class="form-control" id="description" name="description" rows="3"
            placeholder="Add a description"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add</button>
      </form>
    </div>
    <!-- content  -->
    <div class="container my-4">
      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">Sr.no</th>
            <th scope="col">To Do</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
    $sql="SELECT * FROM `tasks`";
    $result= mysqli_query($conn,$sql);
    $srno=0;
    while($row=mysqli_fetch_Assoc($result)){
      $srno=$srno+1;
        echo "<tr>
                <th scope='row'>". $srno ."</th>
                <td>". $row['title'] ."</td>
                <td>". $row['description'] ."</td>
                <td> <button class='edit btn btn-sm btn-primary' id=". $row['sr.no'] .">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sr.no'].">Delete</button> </td>
              </tr>";
    }
    ?>
        </tbody>
      </table>
    </div>
    <hr>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="/crud/index.php" method="POST">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="modal-body">
              <div class="form-group">
                <label for="title">To do</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>

              <div class="form-group">
                <label for="desc">Description</label>
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Update</button>

              <div class="modal-footer d-block mr-auto">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      })
    })
  </script>
</body>

</html>