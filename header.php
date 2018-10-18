<!--Header-->
<nav class="navbar navbar-expand-sm navbar-light bg-warning pl-4 pr-4 pb-0">
    <a href="/index.php" class="navbar-brand">Lorem Ipsum</a>
    <div class="d-flex flex-nonwrap justify-content-center">
        <ul class="navbar-nav">
            <li class="navbar-text" id="header">Buy Music</li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=songs">Songs</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=albums">Albums</a>
            </li>
            <li class="navbar-text" id="header">Browse By Genre</li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=alternative">Alternative</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=blues">Blues</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=country">Country</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=edm">EDM</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=jazz">Jazz</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=pop">Pop</a>
            </li>
            <li>
                <a class="nav-link" href="/musicInfo/catalog.php?type=rb">R&B</a>
            </li>
        </ul>
    </div>
</nav>
<nav class="navbar navbar-expand-sm navbar-light bg-warning pl-4 pr-4 pt-0">
    <div class="collapse navbar-collapse justify-content-center">
        <form action="/musicInfo/catalog.php" method="post" id="search" class="d-inline w-100">
            <div class="input-group">
                <input type="text" name="search" class="form-control border" placeholder="Search Music" />
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary border" type="submit" form="search">
                        Search
                    </button>
                </span>
            </div>
        </form>

		<ul class="navbar-nav">
            <li class="nav-item">
                <?php
				session_start();
				if (isset($_SESSION["username"])) {
					echo "<a id='bold' class='nav-link text-dark' href='/signIn/signOut.php'>Sign Out</a>";
				}
				else {
					echo "<a id='bold' class='nav-link text-dark' href='/signIn/signIn.php'>Sign In</a>";
				}
				?>
            </li>
        </ul>
		<ul class="navbar-nav">
			<li class="nav-item">
				<?php
				session_start();
				if (isset($_SESSION["username"])) {
					echo "<a id='bold' class='nav-link text-dark' href='/order/orderHistory.php'>Order History</a>";
				}
				else {
					echo "<a id='bold' class='nav-link text-dark' href='/signIn/signIn.php'>Order History</a>";
				}
				?>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item">
				<?php
				session_start();
				if (isset($_SESSION["username"])) {
					echo "<a id='bold' class='nav-link text-dark' href='/order/cart.php'>Cart</a>";
				}
				else {
					echo "<a id='bold' class='nav-link text-dark' href='/signIn/signIn.php'>Cart</a>";
				}
				?>
			</li>
		</ul>
    </div>
</nav>