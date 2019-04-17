<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Zillow</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h2>Serach </h2>
      <form action="improveObject.php" method="post">
        <div class="form-group">
          <label for="zwsId">zwsId</label>
          <input type="text" class="form-control" placeholder="Enter zws id" name="zwsId" required>
        </div>
        <div class="form-group">
          <label for="email">address</label>
          <input type="text" class="form-control" placeholder="Enter address" name="address" required>
        </div>
        <div class="form-group">
          <label for="pwd">citystatezip</label>
          <input type="text" class="form-control" id="pwd" placeholder="Enter citystatezip" name="citystatezip">
        </div>
        <input  type="submit" name="submit" class="btn btn-primary" value="submit">
      </form>
    </div>
  </body>
</html>