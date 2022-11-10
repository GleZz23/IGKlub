if (window.history.replaceState) {
  console.log('Evitar el reenvio de formulario');
  window.history.replaceState(null, null, window.location.href);
}