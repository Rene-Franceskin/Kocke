<?php
session_start();

// Brez POST podatkov nazaj na obrazec
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: index.html');
	exit;
}

// Preberi 3 uporabnike (ime, priimek, naslov) - vedno 3 kocke
$users       = [];
$diceResults = []; // ravno polje 9 vrednosti (3 igralci x 3 kocke)
$playerSums  = [];
$winners     = [];

for ($i = 1; $i <= 3; $i++) {
	$ime     = htmlspecialchars(trim($_POST["ime{$i}"]     ?? ''), ENT_QUOTES, 'UTF-8');
	$priimek = htmlspecialchars(trim($_POST["priimek{$i}"] ?? ''), ENT_QUOTES, 'UTF-8');
	$naslov  = htmlspecialchars(trim($_POST["naslov{$i}"]  ?? ''), ENT_QUOTES, 'UTF-8');

	$users[$i] = [
		'ime'     => $ime,
		'priimek' => $priimek,
		'naslov'  => $naslov,
	];

	$sum = 0;
	for ($j = 1; $j <= 3; $j++) {
		$value = rand(1, 6);
		$diceResults[] = $value;
		$sum += $value;
	}
	$playerSums[$i] = $sum;
}

// Poišči vse zmagovalce (lahko jih je več - izenačenje)
$maxSum = max($playerSums);
foreach ($playerSums as $playerIndex => $sum) {
	if ($sum === $maxSum) {
		$winners[] = $playerIndex;
	}
}

// Shrani vse v sejo - rezultati.php bere isto
$_SESSION['users']        = $users;
$_SESSION['diceResults']  = $diceResults;
$_SESSION['playerSums']   = $playerSums;
$_SESSION['winners']      = $winners;
$_SESSION['generatedAt']  = time();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
	<meta charset="utf-8"/>
	<title>Kocke &ndash; Igra</title>
	<link rel="icon" type="image/png" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="head">KOCKE</div>

	<div id="vse">

		<!-- Naslov nad karticami: med animacijo "Mešam kocke...", po razkritju "Met kock" -->
		<div id="rolling-heading" class="rolling-heading">Mešam kocke...</div>

		<div class="igralci-wrapper">
			<?php foreach ($users as $index => $user):
				$start = ($index - 1) * 3;
				$kocke = array_slice($diceResults, $start, 3);
			?>
				<div class="igralci rezultat js-card">
					<h2><?= $index ?>. IGRALEC</h2>
					<div class="separator"></div>

					<div class="atribut">
						<span class="atribut-label">Ime</span>
						<span class="atribut-vrednost"><?= $user['ime'] ?></span>
					</div>
					<div class="atribut">
						<span class="atribut-label">Priimek</span>
						<span class="atribut-vrednost"><?= $user['priimek'] ?></span>
					</div>
					<div class="atribut">
						<span class="atribut-label">Naslov</span>
						<span class="atribut-vrednost"><?= $user['naslov'] ?></span>
					</div>

					<!-- Kocke: najprej dice-anim.gif (vrtenje), nato dice<v>.gif -->
					<div class="kocke-vrstica">
						<?php foreach ($kocke as $v): ?>
							<img class="dice-img rolling"
								 src="img/dice-anim.gif"
								 data-val="<?= $v ?>"
								 alt="Kocka"/>
						<?php endforeach; ?>
					</div>

					<div class="tocke" data-sum="<?= $playerSums[$index] ?>">
						<div class="sestevek">
							Seštevek: <strong class="js-sum">&mdash;</strong>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Gumb je vedno klikabilen (animacija je le vizualna - rezultat je že shranjen) -->
		<div id="vseIgra">
			<form method="POST" action="rezultati.php">
				<input type="hidden" name="show" value="1"/>
				<div class="igra">
					<input type="submit" value="POGLEJ REZULTATE"/>
				</div>
			</form>
		</div>
	</div>

	<div id="footer">&copy; Rene Frančeškin &mdash; 4. Ra</div>

	<script>
		window.addEventListener('DOMContentLoaded', function () {
			// Po ~1.8 s zamenjamo animirano kocko z dejansko sliko vrednosti
			setTimeout(function () {
				// Razkrij kocke
				document.querySelectorAll('.dice-img.rolling').forEach(function (img) {
					var v = img.getAttribute('data-val') || '1';
					img.src = 'img/dice' + v + '.gif';
					img.classList.remove('rolling');
					img.classList.add('reveal');
				});

				// Pokaži seštevke
				document.querySelectorAll('.js-card').forEach(function (card, idx) {
					setTimeout(function () {
						var tocke = card.querySelector('.tocke');
						tocke.querySelector('.js-sum').textContent = tocke.getAttribute('data-sum');
						tocke.classList.add('visible');
					}, idx * 150);
				});

				// Zamenjaj naslov
				document.getElementById('rolling-heading').textContent = 'Met kock';
			}, 1800);
		});
	</script>
</body>
</html>
