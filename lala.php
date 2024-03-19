<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Magnific Popup con CDN</title>
    <!-- Agrega los enlaces a los CDN de jQuery y Magnific Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/magnific-popup.css">

</head>

<body>

    <!-- Botón para abrir la galería -->
    <button id="abrirGaleria">Abrir Galería</button>

    <!-- Contenedor de la galería -->
    <div id="galeria" class="galeria">
        <a href="https://via.placeholder.com/600x400" class="imagen-galeria"><img src="https://via.placeholder.com/150" alt="Imagen 1"></a>
        <a href="https://via.placeholder.com/600x400" class="imagen-galeria"><img src="https://via.placeholder.com/150" alt="Imagen 2"></a>
        <a href="https://via.placeholder.com/600x400" class="imagen-galeria"><img src="https://via.placeholder.com/150" alt="Imagen 3"></a>
    </div>

    <script>
        $(document).ready(function() {
            // Inicializa Magnific Popup al hacer clic en el botón
            $('#abrirGaleria').on('click', function() {
                $('#galeria').magnificPopup({
                    delegate: '.imagen-galeria',
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                }).magnificPopup('open');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/magnific-popup@1.1.0/dist/jquery.magnific-popup.min.js"></script>

</body>

</html>