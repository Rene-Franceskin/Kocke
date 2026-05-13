<?php
session_start();

// Brez seje ni česa prikazati
if (!isset($_SESSION['users']) || !isset($_SESSION['diceResults'])) {
	header('Location: index.html');
	exit;
}

$users       = $_SESSION['users'];
$diceResults = $_SESSION['diceResults'];
$playerSums  = $_SESSION['playerSums'];
$winners     = $_SESSION['winners'];
$maxSum      = max($playerSums);
?>
<!DOCTYPE html>
<html lang="sl">
<head>
	<meta charset="utf-8"/>
	<title>Kocke &ndash; Rezultati</title>
	<link rel="icon" type="image/png" href="img/favicon.png">
	<link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
	<div id="head">KOCKE</div>

	<div id="vse">

		<div class="rolling-heading">Končni rezultati</div>

		<!-- Kartice igralcev v eni vrsti (3 stolpci) -->
		<div class="igralci-wrapper">
			<?php foreach ($users as $index => $user):
				$start = ($index - 1) * 3;
				$kocke = array_slice($diceResults, $start, 3);
				$jeZmagovalec = in_array($index, $winners, true);
			?>
				<div class="igralci rezultat <?= $jeZmagovalec ? 'zmagovalec' : '' ?>">
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

					<div class="kocke-vrstica">
						<?php foreach ($kocke as $v): ?>
							<img class="dice-img" src="img/dice<?= $v ?>.gif" alt="Kocka <?= $v ?>"/>
						<?php endforeach; ?>
					</div>

					<div class="tocke visible">
						<div class="sestevek">
							Seštevek: <strong><?= $playerSums[$index] ?></strong>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Zmagovalec(i) -->
		<div id="zmagovalec-box">
			<?php if (count($winners) === 1):
				$w = $winners[0];
			?>
				<div class="zmagovalec-naslov">ZMAGOVALEC</div>
				<div class="zmagovalec-ime">
					<?= trim($users[$w]['ime'] . ' ' . $users[$w]['priimek']) ?>
				</div>
				<div class="zmagovalec-tocke">
					s seštevkom <strong><?= $maxSum ?></strong>
				</div>
			<?php else: ?>
				<div class="zmagovalec-naslov">IZENAČENJE &mdash; ZMAGOVALCI</div>
				<?php foreach ($winners as $w): ?>
					<div class="zmagovalec-ime">
						<?= trim($users[$w]['ime'] . ' ' . $users[$w]['priimek']) ?>
					</div>
				<?php endforeach; ?>
				<div class="zmagovalec-tocke">
					vsi s seštevkom <strong><?= $maxSum ?></strong>
				</div>
			<?php endif; ?>
		</div>

		<div id="odstevanje">
			Rezultat bo prikazan še <span id="cas">10</span> sekund, nato preusmeritev nazaj...
		</div>
	</div>

	<div id="footer">&copy; Rene Frančeškin &mdash; 4. Ra</div>

	<script>
		// 10-sekundni odštevalnik + JS preusmeritev nazaj na obrazec
		(function () {
			var sekunde = 10;
			var prikaz  = document.getElementById('cas');

			var iv = setInterval(function () {
				sekunde--;
				if (sekunde >= 0) {
					prikaz.textContent = sekunde;
				} else {
					clearInterval(iv);
				}
			}, 1000);

			setTimeout(function () {
				window.location.href = 'index.html';
			}, 10000);
		})();
	</script>
</body>
</html>
<?php
// Ko zaključimo igro, počistimo sejo (da se ob vrnitvi začne na novo)
session_unset();
session_destroy();
?>
