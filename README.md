# Kocke

Spletna PHP simulacija igre s tremi igralnimi kockami za tri igralce. Vsak igralec
vnese svoje podatke (ime, priimek, naslov), nato se zanj naključno vržejo tri
kocke. Igralec z najvišjim seštevkom zmaga; v primeru izenačenja se izpišejo vsi
zmagovalci. Po prikazu rezultatov se stran z JavaScript preusmeritvijo po
10 sekundah samodejno vrne na začetni obrazec.

Naloga uporablja PHP seje (`$_SESSION`) za prenos podatkov med stranmi.

## Potek igre (3 okna)

1. **`index.html`** - Začetni obrazec. Uporabnik vnese ime, priimek in naslov za
   tri igralce in pritisne **IGRAJ**. Polja so obvezna.

2. **`igra.php`** - Stran z metom kock.
   - Iz `POST` podatkov prebere igralce in jih shrani v `$_SESSION['users']`.
   - Za vsakega igralca generira **tri naključna števila** (`rand(1, 6)`) ter
     izračuna seštevek. Vse je shranjeno v sejo (`diceResults`, `playerSums`,
     `winners`).
   - Najprej se za vsako kocko prikaže `dice-anim.gif` (vrteča animacija) z
     rahlim tresenjem prek CSS keyframes.
   - Po približno 1.8 sekunde JavaScript zamenja vsako sliko z ustrezno
     `dice<vrednost>.gif` in razkrije seštevke.
   - Gumb **POGLEJ REZULTATE** pelje na zadnjo stran.

3. **`rezultati.php`** - Zadnja stran s končnimi rezultati.
   - Prebere podatke iz seje. Če seja ni postavljena, preusmeri nazaj na obrazec.
   - Pokaže vse tri igralce v eni vrsti z atributi, statičnimi kockami in
     seštevki. Kartica zmagovalca dobi zlat obrobni okvir.
   - Pod karticami je škatla **ZMAGOVALEC** (ali **IZENAČENJE - ZMAGOVALCI**,
     če sta seštevka enaka).
   - 10-sekundni odštevalnik (JavaScript `setInterval` + `setTimeout`) preusmeri
     nazaj na `index.html` z `window.location.href`.
   - Po izrisu strani se seja počisti z `session_unset()` in `session_destroy()`,
     da se naslednja igra začne na novo.

## Uporabljene tehnologije

- **PHP** - generiranje naključnih števil, obdelava obrazca, seje
- **HTML5** - obrazec z obveznimi vnosi
- **CSS3** - postavitev (CSS Grid `repeat(3, 1fr)`), animacije (`@keyframes`)
- **JavaScript (vanilla)** - zamenjava slik kock, odštevalnik in JS preusmeritev

## Zaganjanje

Igra teče lokalno v okolju z PHP-jem (XAMPP, WAMP, MAMP, vgrajen `php -S` ipd.).

Z XAMPP:
1. Mapo `Kocke` postavi v `C:\xampp\htdocs\`.
2. Zaženi Apache iz XAMPP nadzorne plošče.
3. V brskalniku odpri `http://localhost/Kocke/`.

## Pravila

- Vsak igralec dobi natanko **tri kocke** z vrednostmi od 1 do 6.
- Seštevek treh kock določa rezultat igralca.
- Zmaga tisti igralec, ki ima največji seštevek.
- Pri izenačenju imajo vsi takšni igralci status zmagovalca.
- Rezultat je prikazan 10 sekund, nato se igra avtomatsko vrne na začetek.

## Avtor

Rene Frančeškin - 4. Ra
