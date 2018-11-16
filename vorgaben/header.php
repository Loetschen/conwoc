<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light">
  <a class="navbar-brand" href="index.php">
    <img src="pics/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
    CONWOC
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="friend_post.php">Posts von Freunden</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Chats</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Profil
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="myprofil.php">Mein Profil</a>
          <a class="dropdown-item" href="mypost.php">Meine Posts</a>
          <a class="dropdown-item" href="myfriend.php">Meine Freunde</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="friend_search.php" method="post">
      <input name="suche" class="form-control mr-sm-2" type="search" placeholder="Nutzer suchen" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Suchen</button>
    </form>
  </div>
</nav>
