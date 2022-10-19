
<h1>Erregistratu</h1>
<!-- Nickname -->
<div class="input-container">
  <i class="fa-solid fa-user"></i>
  <input type="text" name="nickname" id="nickname" placeholder="Nickname" autofocus>
</div>
<!-- Email -->
<div class="input-container">
  <i class="fa-solid fa-at"></i>
  <input type="email" name="email" id="email" placeholder="Email-a">
</div>
<!-- Nombre completo -->
<div class="input-container">
  <i class="fa-solid fa-address-card"></i>
  <div>
    <input type="text" name="name" id="name" placeholder="Izena">
    <input type="text" name="surnames" id="surnames" placeholder="Abizenak">
  </div>
</div>
<!-- Fecha de nacimiento -->
<div class="input-container">
  <i class="fa-solid fa-cake-candles"></i>
  <input type="text" id="date" name="date" placeholder="Jaioteguna" onfocus="(this.type='date')">
</div>
<!-- Contraseñas -->
<div class="input-container">
  <i class="fa-solid fa-key"></i>
  <div>
    <input type="password" name="password" id="password" placeholder="Pasahitza">
    <input type="password" name="password2" id="password2" placeholder="Pasahitza egiaztatu">
  </div>
</div>
<!-- Contrato -->

<!-- Rol -->
<input type="hidden" name="role" value="ikasle">

<input type="checkbox" id="cb">Terminoak eta baldintzak onartu</input>
<button id="botonRegistrar">Erregistratu</button>