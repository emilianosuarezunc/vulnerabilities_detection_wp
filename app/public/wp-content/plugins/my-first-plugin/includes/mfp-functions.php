<?php
/*
 * Add my new menu to the Admin Control Panel
 */
add_action( 'admin_menu', 'mfp_Add_My_Admin_Link' );

function mfp_Add_My_Admin_Link()
{
    add_menu_page(
        'Vulnerability Page', // Title of the page
        'My First Plugin', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'mfp-vulnerability-plugin',
        'mfp_render_plugin_page'
    );

    add_submenu_page(
        null, // Página oculta, no aparece en el menú
        'API Info',
        'API Info',
        'manage_options',
        'plugin-api-info',
        'mfp_plugin_api_info_page'
    );
}

function mfp_render_plugin_page() {
    include plugin_dir_path(__FILE__) . 'plugin-list-page.php';
}

// Función unificada para renderizar arrays recursivamente
function mfp_render_array_recursive($arr) {
    if (!is_array($arr)) return '';

    $html = '<ul style="margin: 0; padding-left: 20px;">';
    foreach ($arr as $k => $v) {
        if (is_array($v)) {
            $html .= '<li><strong>' . esc_html($k) . ':</strong> ' . mfp_render_array_recursive($v) . '</li>';
        } else {
            $html .= '<li><strong>' . esc_html($k) . ':</strong> ' . esc_html($v) . '</li>';
        }
    }
    $html .= '</ul>';

    return $html;
}

// Función unificada para mostrar datos en tabla legible
function mfp_render_readable_data($data) {
    if (empty($data) || !is_array($data)) {
        echo '<p>No hay datos para mostrar.</p>';
        return;
    }

    echo '<table style="width: 100%; border-collapse: collapse;">';
    echo '<thead><tr><th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Campo</th><th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Valor</th></tr></thead>';
    echo '<tbody>';

    foreach ($data as $key => $value) {
        echo '<tr>';
        echo '<td style="border: 1px solid #ddd; padding: 8px; vertical-align: top;">' . esc_html($key) . '</td>';
        if (is_array($value)) {
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . mfp_render_array_recursive($value) . '</td>';
        } else {
            echo '<td style="border: 1px solid #ddd; padding: 8px;">' . esc_html($value) . '</td>';
        }
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
}

function mfp_plugin_api_info_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'No tenés permisos para ver esta página.' );
    }

    if ( ! isset( $_GET['slug'] ) ) {
        echo '<div class="wrap"><h1>Falta el slug del plugin</h1></div>';
        return;
    }

    $slug = sanitize_text_field( $_GET['slug'] );
    $api_url = 'https://api-vaps.onrender.com/plugins/' . urlencode( $slug );
    $response = wp_remote_get( $api_url );

    ?>
    <style>
        /* Estilo general */
        .mfp-container {
            max-width: 900px;
            margin: 20px auto;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
                Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            color: #222;
        }
        .mfp-container h1, .mfp-container h2, .mfp-container h3, .mfp-container h4 {
            color: #2a6ebb;
        }
        .mfp-back-button {
            margin-bottom: 20px;
        }
        button.mfp-collapsible {
            background-color: #2a6ebb;
            color: white;
            cursor: pointer;
            padding: 12px 20px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 16px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
            margin-bottom: 8px;
            box-shadow: 0 2px 6px rgba(42,110,187,0.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button.mfp-collapsible:hover {
            background-color: #1e4e8c;
        }
        button.mfp-collapsible:after {
            content: '\25B6'; /* flecha derecha */
            font-size: 12px;
            transform: rotate(0deg);
            transition: transform 0.3s ease;
        }
        button.mfp-collapsible.active:after {
            transform: rotate(90deg); /* flecha abajo */
        }
        .mfp-content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background-color: #f9faff;
            border-left: 3px solid #2a6ebb;
            margin-bottom: 15px;
            border-radius: 0 6px 6px 0;
        }
        .mfp-section {
            margin-bottom: 20px;
        }
        p {
            line-height: 1.5;
        }
        ul {
            padding-left: 20px;
            margin-top: 5px;
        }
        ul li {
            margin-bottom: 6px;
        }
        a {
            color: #2a6ebb;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 25px 0;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const coll = document.querySelectorAll('.mfp-collapsible');
            coll.forEach(button => {
                button.addEventListener('click', function() {
                    this.classList.toggle('active');
                    const content = this.nextElementSibling;
                    if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            });
        });
    </script>
    <div class="wrap mfp-container">
        <button onclick="window.history.back();" class="button mfp-back-button">⬅ Volver atrás</button>
        <h1>Detalles del Plugin: <code><?php echo esc_html( $slug ); ?></code></h1>
        <?php

        if ( is_wp_error( $response ) ) {
            echo '<p>Error al conectar con la API.</p>';
        } else {
            $code = wp_remote_retrieve_response_code( $response );
            $body = wp_remote_retrieve_body( $response );

            if ( $code === 200 ) {
                $data = json_decode( $body, true );
                if ( json_last_error() === JSON_ERROR_NONE && is_array($data) ) {

                    // Info general
                    ?>
                    <div class="mfp-section">
                        <h2>Información General</h2>
                        <p><strong>Plugin:</strong> <?php echo esc_html( $data['plugin'] ?? 'N/D' ); ?></p>
                        <p><strong>Versión:</strong> <?php echo esc_html( $data['version'] ?? 'N/D' ); ?></p>
                    </div>
                    <?php

                    if ( ! empty($data['resultados']) && is_array($data['resultados']) ) {
                        echo '<div class="mfp-section"><h2>Resultados</h2>';
                        foreach ( $data['resultados'] as $idx => $resultado ) {
                            ?>
                            <button class="mfp-collapsible">
                                Resultado #<?php echo ($idx+1) . ' - CWE ID: ' . esc_html($resultado['cwe_id'] ?? 'N/D'); ?>
                            </button>
                            <div class="mfp-content">
                                <p><strong>CWE ID:</strong> <?php echo esc_html( $resultado['cwe_id'] ?? 'N/D' ); ?></p>

                                <?php if ( !empty($resultado['antipatron']) && is_array($resultado['antipatron']) ): 
                                    $antipatron = $resultado['antipatron']; ?>
                                    <h3>Antipatrón: <?php echo esc_html($antipatron['nombre'] ?? 'N/D'); ?></h3>

                                    <?php if (!empty($antipatron['aka']) && is_array($antipatron['aka'])): ?>
                                        <p><strong>AKA:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['aka'] as $aka): ?>
                                                <li><?php echo esc_html($aka); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['etapa_sdlc']) && is_array($antipatron['etapa_sdlc'])): ?>
                                        <p><strong>Etapas SDLC:</strong> <?php echo esc_html(implode(', ', $antipatron['etapa_sdlc'])); ?></p>
                                    <?php endif; ?>

                                    <p><strong>CWE ID:</strong> <?php echo esc_html($antipatron['cwe_id'] ?? 'N/D'); ?></p>

                                    <p><strong>CVEs:</strong></p>
                                    <ul>
                                        <?php 
                                        foreach ( ['cve_plugin', 'cve_tema', 'cve_wp'] as $cve_key ) {
                                            if ( !empty($antipatron[$cve_key]) ) {
                                                echo '<li>' . esc_html(strtoupper($cve_key)) . ': ' . esc_html($antipatron[$cve_key]) . '</li>';
                                            }
                                        }
                                        ?>
                                    </ul>

                                    <?php if (!empty($antipatron['ejemplos']) && is_array($antipatron['ejemplos'])): ?>
                                        <p><strong>Ejemplos:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['ejemplos'] as $url): 
                                                $url_esc = esc_url($url); ?>
                                                <li><a href="<?php echo $url_esc; ?>" target="_blank" rel="noopener noreferrer"><?php echo $url_esc; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['fuerzas_desbalanceadas']) && is_array($antipatron['fuerzas_desbalanceadas'])): ?>
                                        <p><strong>Fuerzas desbalanceadas:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['fuerzas_desbalanceadas'] as $f): ?>
                                                <li><?php echo esc_html($f); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['attack_pattern'])): ?>
                                        <p><strong>Attack Pattern:</strong> <?php echo esc_html($antipatron['attack_pattern']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['problema'])): ?>
                                        <p><strong>Problema:</strong> <?php echo esc_html($antipatron['problema']); ?></p>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['consecuencias']) && is_array($antipatron['consecuencias'])): ?>
                                        <p><strong>Consecuencias:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['consecuencias'] as $c): ?>
                                                <li><?php echo esc_html($c); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['solucion_sdlc']) && is_array($antipatron['solucion_sdlc'])): ?>
                                        <p><strong>Solución SDLC:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['solucion_sdlc'] as $sol): ?>
                                                <li><?php echo esc_html($sol); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['ejemplos_solucion']) && is_array($antipatron['ejemplos_solucion'])): ?>
                                        <p><strong>Ejemplos de solución:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['ejemplos_solucion'] as $url): 
                                                $url_esc = esc_url($url); ?>
                                                <li><a href="<?php echo $url_esc; ?>" target="_blank" rel="noopener noreferrer"><?php echo $url_esc; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                    <?php if (!empty($antipatron['patrones_relacionados']) && is_array($antipatron['patrones_relacionados'])): ?>
                                        <p><strong>Patrones relacionados:</strong></p>
                                        <ul>
                                            <?php foreach($antipatron['patrones_relacionados'] as $pr): ?>
                                                <li><?php echo nl2br(esc_html($pr)); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <p><em>No hay información de antipatrón disponible.</em></p>
                                <?php endif; ?>

                                <?php if (!empty($resultado['vulnerabilidades']) && is_array($resultado['vulnerabilidades'])): ?>
                                    <p><strong>Vulnerabilidades asociadas:</strong></p>
                                    <ul>
                                        <?php foreach($resultado['vulnerabilidades'] as $v): ?>
                                            <li><?php echo esc_html($v); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    } else {
                        echo '<p>No hay resultados para mostrar.</p>';
                    }

                    if ( !empty($data['sin_antipatron']) && is_array($data['sin_antipatron']) ) {
                        ?>
                        <div class="mfp-section">
                            <h2>Plugins sin antipatrón</h2>
                            <ul>
                                <?php foreach($data['sin_antipatron'] as $item): ?>
                                    <li><?php echo esc_html($item); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php
                    }

                } else {
                    echo '<p>La respuesta no es un JSON válido.</p>';
                }
            } else {
                echo '<p>Plugin no encontrado en la API.</p>';
            }
        }
        ?>
    </div>
    <?php
}

