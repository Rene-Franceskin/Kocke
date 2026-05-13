# Kocke

Spletna PHP simulacija igre s tremi igralnimi kockami za tri igralce. Vsak igralec
vnese svoje podatke (ime, priimek, naslov), nato se zanj naključno vržejo tri
kocke. Igralec z najvišjim seštevkom zmaga; v primeru izenačenja se izpišejo vsi
zmagovalci. Po prikazu rezultatov se stran z JavaScript preusmeritvijo po
10 sekundah samodejno vrne na začetni obrazec.

Naloga uporablja PHP seje (`$_SESSION`) za prenos podatkov med stranmi.

## Potek igre (3 okna)

1. **`index.html`** - Začetni obrazec.

2. **`igra.php`** - Stran z metom kock.

3. **`rezultati.php`** - Zadnja stran s končnimi rezultati.

## Uporabljene tehnologije

- **PHP** - generiranje naključnih števil, obdelava obrazca, seje
- **HTML5** - obrazec z obveznimi vnosi
- **CSS3** - postavitev (CSS Grid `repeat(3, 1fr)`), animacije (`@keyframes`)
- **JavaScript (vanilla)** - zamenjava slik kock, odštevalnik in JS preusmeritev

## Pravila

- Vsak igralec dobi natanko **tri kocke** z vrednostmi od 1 do 6.
- Seštevek treh kock določa rezultat igralca.
- Zmaga tisti igralec, ki ima največji seštevek.
- Pri izenačenju imajo vsi takšni igralci status zmagovalca.
- Rezultat je prikazan 10 sekund, nato se igra avtomatsko vrne na začetek.

## Avtor

Rene Frančeškin - 4. Ra
