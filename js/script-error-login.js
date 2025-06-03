window.addEventListener('DOMContentLoaded', function () {
    mostrarPopupErrorLogin(mensajeError, 'sesion.php');
  });
  
  function mostrarPopupErrorLogin(mensaje, redireccion) {
    const overlay = document.createElement('div');
    overlay.style.position = 'fixed';
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'center';
    overlay.style.zIndex = 1000;
  
    const popup = document.createElement('div');
    popup.style.background = '#fff';
    popup.style.padding = '20px';
    popup.style.borderRadius = '10px';
    popup.style.textAlign = 'center';
    popup.style.boxShadow = '0 0 10px rgba(0,0,0,0.3)';
  
    const parrafo = document.createElement('p');
    parrafo.textContent = mensaje;
  
    const button = document.createElement('button');
    button.textContent = 'Aceptar';
    button.style.marginTop = '10px';
    button.style.padding = '10px 20px';
    button.style.cursor = 'pointer';
  
    const salto = document.createElement('br');
  
    button.addEventListener('click', function () {
      window.location.href = redireccion;
    });
  
    popup.appendChild(parrafo);
    popup.appendChild(salto);
    popup.appendChild(button);
    overlay.appendChild(popup);
    document.body.appendChild(overlay);
  }
  