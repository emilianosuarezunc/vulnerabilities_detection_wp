<?php
if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

$all_plugins = get_plugins();
?>

<style>
    .mfp-plugins-table {
        max-width: 1000px;
        border-collapse: collapse;
        width: 100%;
    }

    .mfp-plugins-table th, .mfp-plugins-table td {
        padding: 12px 10px;
        vertical-align: top;
        text-align: left;
    }

    .mfp-plugins-table th {
        background-color: #f1f1f1;
        font-weight: 600;
    }

    .mfp-description {
        max-height: 3.6em; /* ~2 líneas */
        overflow: hidden;
        position: relative;
        transition: max-height 0.3s ease;
    }

    .mfp-description.expanded {
        max-height: 1000px; /* auto fallback */
    }

    .mfp-read-more {
        display: inline-block;
        color: #2271b1;
        margin-top: 6px;
        cursor: pointer;
        font-size: 13px;
    }

    .mfp-code {
        display: block;
        font-family: monospace;
        font-size: 12px;
        color: #444;
    }

    .mfp-status {
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    .mfp-status.active {
        color: #155724;
        background-color: #d4edda;
    }

    .mfp-status.inactive {
        color: #721c24;
        background-color: #f8d7da;
    }
    .button.button-primary {
        background: #0073aa;
        border-color: #006799;
        color: #fff;
        box-shadow: none;
    }

    .button.button-primary:hover {
        background: #006799;
        border-color: #005e8a;
    }

    .plugin-description {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.mfp-read-more').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const description = this.previousElementSibling;
                description.classList.toggle('expanded');
                this.textContent = description.classList.contains('expanded') ? 'Leer menos' : 'Leer más';
            });
        });
    });
</script>

<div class="wrap">
    <h1>Plugins instalados</h1>

    <table class="widefat striped mfp-plugins-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Versión</th>
                <th>Autor</th>
                <th>URL Plugin</th>
                <th>Descripción</th>
                <th>Slug</th>
                <th>Estado</th>
                <th>API Info</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $all_plugins as $plugin_path => $plugin_data ): ?>
                <?php 
                    $slug = basename( $plugin_path, '.php' );
                    $description = wp_strip_all_tags($plugin_data['Description']);
                ?>
                <tr>
                    <td><?php echo esc_html( $plugin_data['Name'] ); ?></td>
                    <td><?php echo esc_html( $plugin_data['Version'] ); ?></td>
                    <td><?php echo esc_html( $plugin_data['Author'] ); ?></td>
                    <td>
                        <?php if ( ! empty( $plugin_data['PluginURI'] ) ): ?>
                            <a href="<?php echo esc_url( $plugin_data['PluginURI'] ); ?>" target="_blank" class="button button-primary">
                                Ver plugin
                            </a>
                        <?php else: ?>
                            <span style="color: #999;">No disponible</span>
                        <?php endif; ?>
                    </td>
                    <td style="min-width: 200px; max-width: 300px;">
                        <div class="mfp-description"><?php echo esc_html( $description ); ?></div>
                        <?php if (strlen($description) > 120): ?>
                            <span class="mfp-read-more">Leer más</span>
                        <?php endif; ?>
                    </td>
                    <td><code class="mfp-code"><?php echo esc_html( $plugin_path ); ?></code></td>
                    <td>
                        <span class="mfp-status <?php echo is_plugin_active( $plugin_path ) ? 'active' : 'inactive'; ?>">
                            <?php echo is_plugin_active( $plugin_path ) ? 'Activo' : 'Inactivo'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo admin_url( 'admin.php?page=plugin-api-info&slug=' . urlencode( $slug ) ); ?>" class="button button-secondary">
                            Ver página API
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
