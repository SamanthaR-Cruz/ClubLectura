function confirmarAccionFormulario(id, nombreFormulario, mensajeTexto) {
  mostrarConfirmacion(mensajeTexto, () => {
    const form = document.forms[nombreFormulario + id];
    if (form) form.submit();
  });
}

function confirmarEliminacionComentario(idComentario) {
  confirmarAccionFormulario(idComentario, "formEliminar", "¿Estás segura(o) de que deseas eliminar este comentario?");
}

function confirmarEliminacionUsuario(idUsuario) {
  confirmarAccionFormulario(idUsuario, "formEliminar", "¿Estás segura(o) de que deseas eliminar este usuario?");
}

function confirmarEliminacionLibro(idLibro) {
  confirmarAccionFormulario(idLibro, "formEliminarLibro", "¿Estás segura(o) de que deseas eliminar este libro?");
}

function confirmarEliminarLibroUsuario(idLibro) {
  confirmarAccionFormulario(idLibro, "formEliminarLibroUsuario", "¿Estás segura(o) de que deseas eliminar este libro de tu lista?");
}

function confirmarTerminarLibro(idLibro) {
  confirmarAccionFormulario(idLibro, "formTerminarLibro", "¿Deseas marcar este libro como terminado?");
}

function confirmarEliminarEvento(idEvento) {
  confirmarAccionFormulario(idEvento, "formEliminarEvento", "¿Deseas eliminar este evento de tu lista?");
}

function mostrarConfirmacion(mensajeTexto, onConfirmar) {
  const overlay = document.createElement('div');
  Object.assign(overlay.style, {
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100%',
    height: '100%',
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    display: 'flex',
    justifyContent: 'center',
    alignItems: 'center',
    zIndex: 1000
  });

  const popup = document.createElement('div');
  Object.assign(popup.style, {
    background: '#fff',
    padding: '25px 35px',
    borderRadius: '10px',
    textAlign: 'center',
    boxShadow: '0 0 15px rgba(0,0,0,0.3)',
    maxWidth: '400px',
    fontFamily: 'sans-serif'
  });

  const mensaje = document.createElement('p');
  mensaje.textContent = mensajeTexto;
  Object.assign(mensaje.style, {
    fontSize: '16px',
    marginBottom: '20px'
  });

  const btnCancelar = document.createElement('button');
  btnCancelar.textContent = "Cancelar";
  Object.assign(btnCancelar.style, {
    marginRight: '10px',
    backgroundColor: '#ccc',
    color: '#333',
    border: 'none',
    borderRadius: '5px',
    padding: '10px 20px',
    cursor: 'pointer',
    fontWeight: 'bold'
  });

  const btnAceptar = document.createElement('button');
  btnAceptar.textContent = "Aceptar";
  Object.assign(btnAceptar.style, {
    backgroundColor: '#e74c3c',
    color: 'white',
    border: 'none',
    borderRadius: '5px',
    padding: '10px 20px',
    cursor: 'pointer',
    fontWeight: 'bold'
  });

  btnCancelar.onclick = () => document.body.removeChild(overlay);
  btnAceptar.onclick = () => {
    onConfirmar();
    document.body.removeChild(overlay);
  };

  popup.appendChild(mensaje);
  popup.appendChild(btnCancelar);
  popup.appendChild(btnAceptar);
  overlay.appendChild(popup);
  document.body.appendChild(overlay);
}

function confirmarEliminarEventoTotal(id) {
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
  popup.innerHTML = `
    <p>¿Deseas eliminar este evento definitivamente?</p>
    <br>
    <button class="btn-aceptar-popup" onclick="document.forms['formEliminarTotal${id}'].submit(); document.body.removeChild(this.parentElement.parentElement);">Sí, eliminar</button>
    <button onclick="document.body.removeChild(this.parentElement.parentElement);" style="margin-left: 10px;">Cancelar</button>
  `;

  overlay.appendChild(popup);
  document.body.appendChild(overlay);
}
