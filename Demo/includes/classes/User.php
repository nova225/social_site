<?php 

class User {
	private $con;
	private $user;



	# funkcija samo $this->user varijabli pridodaje atribute koji pripadaju login-anom useru

	public function __construct($con, $user) {
		$this->con =$con;
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
		$this->user = mysqli_fetch_array($user_details_query);
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getNumPosts() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username ='$username'");
		$row = mysqli_fetch_array($query);
		return $row ['num_posts'];
	}

	# funkcija varijabli $username pridodaje vrijednost username atributa unutar this->user objekta kako bi s njom izvela novi query na DB iz čega će izvuć first_name i last_name pa s njima napravit lisu $row te vratiti ime i prazime loginanog usera

	public function getFirstAndLastName() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username ='$username'");
		$row = mysqli_fetch_array($query);
		return $row['first_name'] . " " . $row['last_name'];
		
	}

	public function isClosed() {
		$username = $this->user['username'];
		$query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username = '$username'");
		$row = mysqli_fetch_array($query);

		if($row['user_closed'] == 'yes')
			return True;
		else
			return False;

	}
}

?>