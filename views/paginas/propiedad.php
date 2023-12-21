<main class="contenedor seccion ">
        <h1><?php echo $propiedad->titulo;  ?></h1>
        <div class="anuncio">
            <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">

            <div class="resumen-propiedad contenido-anuncio">
                <p class="precio">$<?php echo $propiedad->precio;  ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                        <p><?php echo $propiedad->wc;  ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                        <p><?php echo $propiedad->estacionamientos;  ?></p>
                    </li>
                    <li>
                        <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                        <p><?php echo $propiedad->habitaciones;  ?></p>
                    </li>
                </ul>

                <p><?php echo $propiedad->descripcion;  ?></p>

                
            </div>
        </div>
    </main>