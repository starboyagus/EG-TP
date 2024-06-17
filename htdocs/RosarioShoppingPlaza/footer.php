<footer class="footer mt-4 text-center text-lg-start footer-text">

    <!-- Seccion Redes Sociales -->
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <div class="me-5 d-none d-lg-block">
            <span>Conectate con nosotros en las redes sociales:</span>
        </div>
        <div>
            <a href="" class="me-4 footer-item ">
                <i class="fa-brands fa-facebook"></i>
            </a>
            <a href="" class="me-4 footer-item">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="" class="me-4 footer-item">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="" class="me-4 footer-item">
                <i class="fa-brands fa-github"></i>
            </a>
        </div>
    </section>

    <!-- Owner Request -->
    <div class="text-center footer-text p-3 border-bottom">
        <a href="request_owner.php" class="footer-text footer-item fw-bold">TRABAJA CON NOSOTROS</a>
    </div>

    <!-- Form Contacto -->
    <section class="border-bottom">
    <?php
        // Funcion para enviar Mail
        function enviarMAIL($f_name, $l_name, $mail, $tel, $msg){
                $needle = 'dueño';
        
                // Si contiene la palabra dueño salta error
                if (strpos($msg, $needle) !== false){
                    ?>
                    <div class="container form-container mt-4" style="max-width:32em">
                        <h1>Detectamos un error</h1>
                        <p>Detectamos que usted quiere inscribirse como dueño <br> 
                        Para inscribirse como dueño tiene que ir a la siguiente pagina</p>
                        <a class="btn form-btn form-control" href="locales_alta.php">Registrarse como dueño</a>
                    </div>
                <?php
                }
            
                // Si no contiene, envia el mail
                else{
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "From:". $f_name. " " . $l_name . "\r\n";
                //$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                
                $to="agusdownbad@icloud.com";
                $subject="Solicitud de Contacto - Rosario Shopping Plaza";
                $body=  "Nombre: ". $f_name . " " . $l_name ."\n" . 
                        "Mail: ".$mail."\n".
                        "Telefono: ".$tel."\n".
                        "Comentario: ". $msg;
                
                mail($to, $subject, $body, $headers);
                ?>
                <div class="container form-container" style="max-width:32em">
                    <h1>Mail Enviado</h1>
                    <p>El Mail fue enviado con exito! <br> 
                    Recuerde que recibira una respuesta en las siguientes 48 horas</p>
                </div>
                <?php
                return true;
                }
            }
        
            // Form de Contacto
            if(!isset($_POST['submit'])){
                ?>
                <br>
                <h1 class="form-contact">Contactanos</h1>
                <div class="container form-container" style="max-width:70em;">
                    <!-- Formulario -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="row g-3">
                        <!-- Campo Nombre -->
                        <div class="col-12 col-sm-6">
                            <label for="f_name" class="form-label">Nombre</label>
                            <input type="text" name="f_name" id="f_name" class="form-control" placeholder="Nombre" required>
                        </div>
            
                        <!-- Campo Apellido -->
                        <div class="col-12 col-sm-6">
                            <label for="l_name" class="form-label">Apellido</label>
                            <input type="text" name="l_name" id="l_name" class="form-control" placeholder="Apellido" required>
                        </div>
            
                        <!-- Campo Email -->
                        <div class="col-12">
                            <label for="mail" class="form-label">Email</label>
                            <input type="email" name="mail" id="mail" class="form-control" placeholder="Email" required>
                        </div>
            
                        <!-- Campo Telefono -->
                        <div class="col-12">
                            <label for="tel" class="form-label">Telefono</label>
                            <input type="tel" name="tel" id="tel" placeholder="XXXX-XXXXXX" class="form-control" pattern="[0-9]{4}-[0-9]{6}" required>
                        </div>
            
                        <!-- Campo Mensaje -->
                        <div class="col-12">
                            <label for="msg" class="form-label">Dejanos tu mensaje</label>
                            <textarea class="form-control form-textarea" name="msg" id="msg" placeholder="Mensaje" rows="10" required></textarea>
                        </div>
            
                        <!-- Boton Submit -->
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn form-control form-btn" for="btn-modal" >Enviar Mensaje</button>
                        </div>
                    </form>
                </div>
            <?php
            }
        
            // Variables para utilizar en la funcion
            else{
                $f_name = ucfirst($_POST['f_name']);
                $l_name = ucfirst($_POST['l_name']);
                $mail = $_POST['mail'];
                $tel = $_POST['tel'];
                $msg = ucfirst($_POST['msg']);
            
                enviarMAIL($f_name, $l_name, $mail, $tel, $msg);
            } ?>
        </section>
        
        
        
    <!-- Section main del footer -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">

                <!-- Descripcion del shopping -->
                <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
                    <h6 class="text-uppecase fw-bold mb-4 footer-text">
                        <i class="fa-solid fa-city me-3"></i> Rosario Shopping Plaza
                    </h6>
                    <p class="footer-text">
                        Informacion del local bla bla bla bla bla bla bla
                    </p>
                </div>

                <!-- About -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4 footer-text">
                        About
                    </h6>
                    <p class="footer-text">
                        <a href="#" class="footer-item">About Us</a>
                    </p>
                    <p class="footer-text">
                        <a href="#" class="footer-item">Privacy Policy</a>
                    </p>
                    <p class="footer-text">
                        <a href="#" class="footer-item">Cookies Policy</a>
                    </p>
                </div>

                <!-- Links del shopping -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold mb-4 footer-text">
                        Useful Links
                    </h6>
                    <p class="footer-text">
                        <a href="#" class="footer-item">Shopping</a>
                    </p>
                    <p class="footer-text">
                        <a href="#" class="footer-item">Servicios</a>
                    </p>
                    <p class="footer-text">
                        <a href="locales.php" class="footer-item">Locales</a>
                    </p>
                    <p class="footer-text">
                        <a href="#" class="footer-item">Promociones</a>
                    </p>
                </div>

                <!-- Informacion clave del Shopping -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold mb-4 footer-text">Contacto</h6>
                    <p class="footer-text"><i class="fa-solid fa-location-dot me-3"></i>Ubicacion del Shopping</p>
                    <p class="footer-text"><i class="fa-solid fa-envelope me-3"></i>Mail del Shopping</p>
                    <p class="footer-text"><i class="fa-solid fa-phone me-3"></i>Telefono del Shopping</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Copyright -->
    <div class="text-center footer-text p-3" style="background-color: #26303b">
        © 2024 Copyright:
        <a class="footer-text footer-item fw-bold" href="index.php">Rosario Shopping Plaza</a>
    </div>
</footer>