<header class="site-header">
    <div class="container">
        <div class="barra">
            <a href="/" class="logo-contenedor">
                <img src="Client/imgs/logo_final.png" alt="Logo DinoKing Games">
                <h1 class="m0">Dino<span>King Games</span></h1>
            </a>
            <div class="navegacion">
                <a href="/jugar">Jugar</a>
                <a href="/seguimiento">Seguimiento</a>
                <a href="/nosotros">Nosotros</a>
                <a href="/contacto">Contacto</a>
                <a href="#" id="openModal" class="btn-nav btn-ingresar">Ingresar</a>
                <a href="#" id="openRegister" class="btn-nav btn-registrarse">Registrarse</a>
            </div>
        </div>
        <div class="texto-header">
            <h2 class="m0">¡Descubre nuestros juegos!</h2>
            <p class="m0">Diviertete con amigos mientras disfrutas un desafio.</p>
        </div>
    </div>

    <div id="loginModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-modal">&times;</span>
      
      <section class="form-log">
        <div class="form-wrap">
          <form action="action_page.php" method="post" class="login">
            <legend>Bienvenido</legend>
            <label for="nombre">Usuario</label>
            <input type="text" id="nombre" name="nombre" placeholder="Usuario" required>
  
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
  
            <input type="submit" value="Ingresar" class="boton-login">
            <a href="#" class="forgotten">¿Olvidaste tu contraseña?</a>
          </form>
        </div>
      </section>
    </div>
  </div>

  <div id="registerModal" class="modal-overlay">
    <div class="modal-content">
      <span class="close-modal close-register">&times;</span>
      
      <section class="form-log">
        <div class="form-wrap">
          <form action="register_action.php" method="post" class="login">
            <legend>Registrarse</legend>
            
            <label for="nombre_reg">Nombre de usuario</label>
            <input type="text" id="nombre_reg" name="nombre_reg" placeholder="Usuario" required>
            
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ejemplo@gmail.com" required>
            
            <label for="contraseña">Contraseña</label>
            <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
            
            <label for="confirmar_contraseña">Confirmar contraseña</label>
            <input type="password" id="confirmar_contraseña" name="confirmar_contraseña" placeholder="Confirmar contraseña" required>
            
            <input type="submit" value="Registrarse" class="boton-login">
            <a href="#" class="forgotten">¿Ya tienes cuenta? Inicia sesión</a>
          </form>
        </div>
      </section>
    </div>
  </div>
</header>